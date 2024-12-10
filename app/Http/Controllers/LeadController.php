<?php

namespace App\Http\Controllers;
use App\Imports\LeadImport;
use App\Models\Client;
use App\Models\ClientDeal;
use App\Models\Deal;
use App\Models\DealCall;
use App\Models\DealDiscussion;
use App\Models\DealEmail;
use App\Models\DealFile;
use App\Models\DealStage;
use App\Models\Item;
use App\Models\Label;
use App\Models\Lead;
use App\Models\LeadActivityLog;
use App\Models\LeadCall;
use App\Models\LeadDiscussion;
use App\Models\LeadDiscussions;
use App\Models\LeadEmail;
use App\Models\LeadFile;
use App\Models\LeadStage;
use App\Models\Pipeline;
use App\Models\Product;
use App\Models\Source;
use App\Models\Stage;
use App\Models\Substatus;
use App\Models\Budget;
use App\Models\Booking;
use App\Models\User;
use App\Models\Employee;
use App\Models\Project;
use App\Models\LeadStatusHistory;
use App\Models\UserDeal;
use App\Models\UserDefualtView;
use App\Models\UserLead;
use App\Models\Utility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\ImportRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LeadsImport; // Assuming you use Laravel Excel for import
use Illuminate\Support\Facades\Log;
use DB;


class LeadController extends Controller
{

    public function index()
    {
      if (\Auth::user()->type == 'company' || \Auth::user()->type == 'employee') {
            if (\Auth::user()->default_pipeline) {
                $pipeline = Pipeline::where('created_by', '=', \Auth::user()->creatorId())->where('id', '=', \Auth::user()->default_pipeline)->first();
                if (!$pipeline) {
                    $pipeline = Pipeline::where('created_by', '=', \Auth::user()->creatorId())->first();
                }
            } else {
                $pipeline = Pipeline::where('created_by', '=', \Auth::user()->creatorId())->first();
            }

            $pipelines = Pipeline::where('created_by', '=', \Auth::user()->creatorId())->get();
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        $defualtView         = new UserDefualtView();
        $defualtView->route  = \Request::route()->getName();
        $defualtView->module = 'lead';
        $defualtView->view   = 'kanban';
        User::userDefualtView($defualtView);
        
        return view('lead.index', compact('pipelines', 'pipeline'));
    }
    
public function list()
{
    try {
        // Get the authenticated user
        $user = auth()->user();
        
        
        if($user->type === 'company')
        {
        $ulist = Employee::where('created_by', auth()->user()->id)->get();
        }
        else
        {
        
        $empid = Employee::where('user_id', auth()->user()->id)->first();
        $ulist = Employee::where('team_owner', $empid->id)->get();


        }
        
        //dd($ulist);

        // Determine the leads to fetch based on user type
        $leads = $user->type === 'company'
            ? Lead::where('created_by', $user->id)->get()
            : Lead::where('user_id', $user->id)->get();
        
        // Return the 'leads.list' view with the retrieved data
        return view('lead.list', ['leads' => $leads,'ulist'=>$ulist]);

    } catch (\Exception $e) {
        // Log the exception for debugging
        \Log::error('Error fetching leads: ' . $e->getMessage());

        // Optionally, return an error view or flash message to the user
        return redirect()->back()->with('error', 'Unable to retrieve leads at this time. Please try again later.');
    }
}
public function assign(Request $request)
{
    // Validate the input
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'lead_ids' => 'required|array|min:1',
        'lead_ids.*' => 'string',
    ]);

    // Retrieve and convert lead IDs to an array
    $userId = $request->input('user_id');
    $leadIds = explode(',', $request->input('lead_ids')[0]); // Split the string into an array

    try {
        // Get the current user (the one performing the assignment)
        $assignedByUserId = \Auth::id();

        // Update the leads and save assignment history
        foreach ($leadIds as $leadId) {
            // Update the lead with the new user ID
            $lead = Lead::find($leadId);
            if ($lead) {
                $lead->user_id = $userId;
                $lead->save();

                // Save to assignment_histories table
                \DB::table('assignment_histories')->insert([
                    'lead_id' => $leadId,
                    'user_id' => $userId,  // Assigned user
                    'assigned_by_user_id' => $assignedByUserId, // The user who assigned
                    'assigned_at' => now(), // Current timestamp
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Redirect with success message if update was successful
        return redirect()->route('lead.list')->with('success', 'Leads have been successfully assigned.');
    } catch (\Exception $e) {
        // Log the exception or handle it as needed
        \Log::error("Failed to assign leads: " . $e->getMessage());

        // Redirect back with an error message
        return redirect()->route('lead.index')->with('error', 'An error occurred while assigning leads. Please try again.');
    }
}

  public function addlead()
    {
        $employees = User::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 'employee')->get()->pluck('name', 'id');
        $employees->prepend(__('Select Employee'), '');
        return view('lead.create', compact('employees'));
    }

    public function create()
    {
        $employees = User::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 'employee')->get()->pluck('name', 'id');
         $budget = Budget::all();
        $projects = Project::get();
        $source = Source::all();
      //  dd($projects);
        $employees->prepend(__('Select Employee'), '');
        return view('lead.create', compact('employees','projects','budget','source'));
    }
    
   public function addcontact(Request $request)
   {
    try {
        // Get the authenticated user
        $user = \Auth::user();
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_no' => 'required|string|max:15'
        ]);

        // Store the lead information
        $lead = new Lead();
        $lead->name = $request->name;
        $lead->email = $request->email;
        $lead->phone_no = $request->phone_no;
        $lead->lead_type = $request->lead_type;
        $lead->requirements = $request->requirement_type;
        $lead->alternative_no = $request->alternative_no;
        $lead->unit_no = $request->unit_no;
        $lead->project_id = $request->project_id;
        $lead->property_stage = $request->property_stage;
        $lead->property_type = $request->property_type;
        $lead->property_sub_type = $request->property_sub_type;
        $lead->budget_id = $request->budget;
        $lead->location = $request->location;
        $lead->lead_stage = $request->lead_stage;
        $lead->sources = $request->lead_source;
        $lead->dob = $request->dob;
        $lead->campaign_id = $request->campaign;
        $lead->created_by = $user->id;
        $lead->date = now();
        $lead->save();

        // Redirect with success message
        return redirect()->back()->with('success', __('Lead successfully created.'));
    } catch (\Exception $e) {
        // Handle the exception and return an error message
        return redirect()->back()->with('error', __('An error occurred while creating the lead: ') . $e->getMessage());
    }
}

   public function leadsimport()
   {
    return view('lead.import');

   }


    public function importStore(ImportRequest $request)
    {
     
     dd($request);
     
    }

    public function importProcess(ImportProcessRequest $request)
    {
        // clear previous import
        Artisan::call('queue:clear database --queue=import_lead');
        Artisan::call('queue:flush');
        // Get index of an array not null value with key
        $columns = array_filter($request->columns, function ($value) {
            return $value !== null;
        });

        $excelData = Excel::toArray(new LeadImport, public_path(Files::UPLOAD_FOLDER . '/' . Files::IMPORT_FOLDER . '/' . $request->file))[0];

        if ($request->has_heading) {
            array_shift($excelData);
        }

        $jobs = [];

        foreach ($excelData as $row) {

            $jobs[] = (new ImportLeadJob($row, $columns));
        }

        $batch = Bus::batch($jobs)->onConnection('database')->onQueue('import_lead')->name('import_lead')->dispatch();

        Files::deleteFile($request->file, Files::IMPORT_FOLDER );

        return Reply::successWithData(__('messages.importProcessStart'), ['batch' => $batch]);
    }
   
  public function show($id)
    {
        if (\Auth::user()->type == 'company' || \Auth::user()->type == 'employee') {
            if ($id == 'null') {
                return redirect()->back()->with('error', 'Lead is not available.');
            }
            $calenderTasks = [];

            $ids           = \Crypt::decrypt($id);
            $lead          = Lead::where('id', '=', $ids)->with('stage')->with('files')->with('pipeline')->with('userEmp')->with('activities')
            ->with('discussions')->with('calls')->with('emails')->with('users')->first();
            $deal          = Deal::where('id', '=', $lead->is_converted)->first();
            $stageCnt      = LeadStage::where('pipeline_id', '=', $lead->pipeline_id)->where('created_by', '=', $lead->created_by)->get();
            $i             = 0;
            foreach ($stageCnt as $stage) {
                $i++;
                if ($stage->id == $lead->stage_id) {
                    break;
                }
            }
            $precentage = number_format(($i * 100) / count($stageCnt));
            
           // dd($lead);
            return view('lead.view', compact('lead', 'calenderTasks', 'deal', 'precentage'));
            
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    
    public function leadview($id)
    {
        $user_id =  Auth::user()->id;
        $leaddata = Lead::where('id',$id)->first();
        $budget = Budget::where('created_by' , $user_id)->get();
        $source = Source::where('created_by' , $user_id)->get();
        $leadhistory = LeadStatusHistory::where('lead_id',$id)->get();
        $callbackStatus = Substatus::where('status_id',2)->get();
        $notInterestedStatus = Substatus::where('status_id',3)->get();
        return view('lead.view', compact('leaddata','source','callbackStatus','notInterestedStatus','leadhistory','budget'));

    }

   public function importleads(Request $request)
{
    // Validate file input
    try {
        // Load file
        $file = $request->file('import_file');
        Log::info('Importing leads started', ['file_name' => $file->getClientOriginalName()]);
        $leadsData = [];
        // Parse CSV or Excel data
        $data = Excel::toArray([], $file);
        // Log parsed data for debugging
        Log::debug('Parsed data from file', ['data' => $data]);
        // Check if data has headers or not
        $hasHeaders = $request->has('heading');
        Log::info('Heading detected', ['hasHeaders' => $hasHeaders]);
        // Map data to table columns
        foreach ($data[0] as $index => $row) {
            if ($index === 0 && $hasHeaders) continue; // Skip header row if checkbox selected

            $leadsData[] = [
                'name'       => $row[0] ?? null,
                'email'      => $row[1] ?? null,
                'phone_no'   => $row[2] ?? null,
                'project_id' => $row[3] ?? null,
                'source_id'  => $row[4] ?? null,
                'notes'      => $row[5] ?? null,
            ];
        }

        // Log data to be inserted
        Log::debug('Prepared data for insertion', ['leadsData' => $leadsData]);

        // Insert data into leads table
        Lead::insert($leadsData);
        Log::info('Leads data inserted successfully', ['record_count' => count($leadsData)]);

        // Return success response with updated table view
        $view = view('leads.import_table', compact('leadsData'))->render();

        return response()->json(['status' => 'success', 'view' => $view]);

    } catch (\Exception $e) {
        Log::error('Failed to import leads', ['error_message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        return response()->json(['status' => 'error', 'message' => 'Failed to import leads. Please check the file and try again.']);
    }
 }
  
     

    public function edit(Lead $lead)
    {
        $pipelines = Pipeline::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $pipelines->prepend(__('Select Pipeline'), '');
        $stages = LeadStage::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        // dd($pipelines);
        $sources   = Source::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $products  = Item::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $employees = User::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 'employee')->get()->pluck('name', 'id');
        $employees->prepend(__('Select Employee'), '');

        $lead->sources  = explode(',', $lead->sources);
        $lead->products = explode(',', $lead->products);
        $budget = Budget::all();
        $projects = Project::get();
        $source = Source::all();
        

        return view('lead.edit', compact('lead', 'pipelines', 'stages', 'sources', 'products', 'employees','budget','source','projects'));
    }


  public function update(Request $request, $id)
{
    // Validate the input data
  /*  $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone_no' => 'required|string|max:15',
        'requirement_type' => 'nullable|string',
        'country_code' => 'nullable|string|max:5',
        'alternative_no' => 'nullable|string|max:15',
        'unit_no' => 'nullable|string|max:50',
        'project_id' => 'nullable|exists:projects,id',
        'property_stage' => 'nullable|string',
        'property_type' => 'nullable|string',
        'property_sub_type' => 'nullable|string',
        'budget' => 'nullable|string',
        'location' => 'nullable|string',
        'lead_type' => 'nullable|string',
        'lead_source' => 'nullable|exists:sources,id',
        'campaign' => 'nullable|string|max:255',
        // Add other validation rules as needed
    ]); */

    // Find the lead by ID or throw a 404 error if not found
    $lead = Lead::findOrFail($id);

    // Update only the fields that are present in the request
    $lead->name = $request->input('name');
    $lead->email = $request->input('email');
    $lead->phone_no = $request->input('phone_no');
    $lead->requirements = $request->input('requirement_type');
    $lead->alternative_no = $request->input('alternative_no');
    $lead->unit_no = $request->input('unit_no');
    $lead->project_id = $request->input('project_id');
    $lead->property_stage = $request->input('property_stage');
    $lead->property_type = $request->input('property_type');
    $lead->property_sub_type = $request->input('property_sub_type');
    $lead->budget_id = $request->input('budget_id');
    $lead->location = $request->input('location');
    $lead->lead_type = $request->input('lead_type');
    $lead->sources = $request->input('lead_source');
      $lead->save();
    // Redirect to the lead index page with a success message
    return redirect()->route('lead.list')->with('success', 'Lead updated successfully');
}



    public function destroy(Lead $lead)
    {
        if (\Auth::user()->type == 'company') {
            LeadFile::where('lead_id', '=', $lead->id)->delete();
            UserLead::where('lead_id', '=', $lead->id)->delete();
            LeadActivityLog::where('lead_id', '=', $lead->id)->delete();
            $lead->delete();

            return redirect()->back()->with('success', __('Lead successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function order(Request $request)
    {
        if (\Auth::user()->type == 'company' || \Auth::user()->type == 'employee') {
            $usr = \Auth::user();

            $post       = $request->all();
            $lead       = Lead::find($post['lead_id']);
            $lead_users = $lead->users->pluck('email', 'id')->toArray();

            if ($lead->stage_id != $post['stage_id']) {
                $newStage = LeadStage::find($post['stage_id']);

                LeadActivityLog::create(
                    [
                        'user_id' => $usr->id,
                        'lead_id' => $lead->id,
                        'log_type' => 'Move',
                        'remark' => json_encode(
                            [
                                'title' => $lead->name,
                                'old_status' => $lead->stage->name,
                                'new_status' => $newStage->name,
                            ]
                        ),
                    ]
                );
            }

            foreach ($post['order'] as $key => $item) {
                $lead           = Lead::find($item);
                $lead->order    = $key;
                $lead->stage_id = $post['stage_id'];
                $lead->save();
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function json(Request $request)
    {
        $lead_stages = new LeadStage();
        if ($request->pipeline_id && !empty($request->pipeline_id)) {
            $lead_stages = $lead_stages->where('pipeline_id', '=', $request->pipeline_id);
            $lead_stages = $lead_stages->get()->pluck('name', 'id');
        } else {
            $lead_stages = [];
        }

        return response()->json($lead_stages);
    }

    public function userDestroy($id, $user_id)
    {
        if (\Auth::user()->type == 'company') {
            $lead = Lead::find($id);
            UserLead::where('lead_id', '=', $lead->id)->where('user_id', '=', $user_id)->delete();

            return redirect()->back()->with('success', __('User successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function userEdit($id)
    {
        $lead = Lead::find($id);

        $users = User::where('created_by', '=', \Auth::user()->creatorId())->where('type', 'employee')->whereNOTIn(
            'id',
            function ($q) use ($lead) {
                $q->select('user_id')->from('user_leads')->where('lead_id', '=', $lead->id);
            }
        )->get();

        $users = $users->pluck('name', 'id');


        return view('lead.users', compact('lead', 'users'));
    }

    public function userUpdate($id, Request $request)
    {
        if (\Auth::user()->type == 'company') {
            $usr  = \Auth::user();
            $lead = Lead::find($id);

            if (!empty($request->users)) {
                $users   = array_filter($request->users);
                $leadArr = [
                    'lead_id' => $lead->id,
                    'name' => $lead->name,
                    'updated_by' => $usr->id,
                ];

                foreach ($users as $user) {
                    UserLead::create(
                        [
                            'lead_id' => $lead->id,
                            'user_id' => $user,
                        ]
                    );

                }

                $useres = User::whereIn('id', $users)->get();

                $userName = $useres->pluck('name')->toArray();

                LeadActivityLog::create(
                    [
                        'user_id' => $usr->id,
                        'lead_id' => $lead->id,
                        'log_type' => 'Add user',
                        'remark' => json_encode(['title' => implode(",", $userName)]),
                    ]
                );
            }

            if (!empty($users) && !empty($request->users)) {
                return redirect()->back()->with('success', __('Users successfully updated.'));
            } else {
                return redirect()->back()->with('error', __('Please select valid user.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function productEdit($id)
    {
        $lead     = Lead::find($id);
        $products = Item::where('created_by', '=', \Auth::user()->creatorId())->whereNOTIn('id', explode(',', $lead->items))->get()->pluck('name', 'id');

        return view('lead.items', compact('lead', 'products'));
    }

    public function productUpdate($id, Request $request)
    {
        if (\Auth::user()->type == 'company') {
            $usr        = \Auth::user();
            $lead       = Lead::find($id);
            $lead_users = $lead->users->pluck('id')->toArray();

            if (!empty($request->items)) {
                $products     = array_filter($request->items);
                $old_products = explode(',', $lead->items);
                $lead->items  = !empty($old_products) ? implode(',', array_merge($old_products, $products)) : $products;

                $lead->save();

                $objProduct = Item::whereIN('id', $products)->get()->pluck('name', 'id')->toArray();

                LeadActivityLog::create(
                    [
                        'user_id' => $usr->id,
                        'lead_id' => $lead->id,
                        'log_type' => 'Add Product',
                        'remark' => json_encode(['title' => implode(",", $objProduct)]),
                    ]
                );
            }

            if (!empty($products) && !empty($request->items)) {
                return redirect()->back()->with('success', __('Products successfully updated.'))->with('status', 'products');
            } else {
                return redirect()->back()->with('error', __('Please select valid product.'))->with('status', 'general');
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function productDestroy($id, $product_id)
    {
        if (\Auth::user()->type == 'company') {
            $lead     = Lead::find($id);
            $products = explode(',', $lead->items);
            foreach ($products as $key => $product) {
                if ($product_id == $product) {
                    unset($products[$key]);
                }
            }
            $lead->items = implode(',', $products);
            $lead->save();

            return redirect()->back()->with('success', __('Products successfully deleted.'))->with('status', 'products');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function fileUpload($id, Request $request)
    {
        if (\Auth::user()->type == 'company') {
            $lead = Lead::find($id);
            $request->validate(['file' => 'required']);
            $file_name = $request->file->getClientOriginalName();
            $file_path = $id . "_" . md5(time()) . "_" . $request->file->getClientOriginalName();
            $request->file->storeAs('uploads/lead_files', $file_path);

            $dir = 'lead_files/';

            $path = Utility::upload_file($request, 'file', $file_name, $dir, []);
            if ($path['flag'] == 1) {
                $file = $path['url'];
            } else {
                return redirect()->back()->with('error', __($path['msg']));
            }

            $file                 = LeadFile::create(
                [
                    'lead_id' => $id,
                    'file_name' => $file_name,
                    'file_path' => $file_path,
                ]
            );
            $return               = [];
            $return['is_success'] = true;
            $return['download']   = route(
                'lead.file.download',
                [
                    $lead->id,
                    $file->id,
                ]
            );
            $return['delete']     = route(
                'lead.file.delete',
                [
                    $lead->id,
                    $file->id,
                ]
            );

            LeadActivityLog::create(
                [
                    'user_id' => \Auth::user()->id,
                    'lead_id' => $lead->id,
                    'log_type' => 'Upload File',
                    'remark' => json_encode(['file_name' => $file_name]),
                ]
            );

            return response()->json($return);
        } else {
            return response()->json(
                [
                    'is_success' => false,
                    'error' => __('Permission denied.'),
                ],
                200
            );
        }
    }

    public function fileDownload($id, $file_id)
    {
        if (\Auth::user()->type == 'company') {
            $lead = Lead::find($id);

            $file = LeadFile::find($file_id);
            if ($file) {
                $file_path = storage_path('uploads/lead_files/' . $file->file_path);
                $filename  = $file->file_name;

                return \Response::download(
                    $file_path,
                    $filename,
                    [
                        'Content-Length: ' . filesize($file_path),
                    ]
                );
            } else {
                return redirect()->back()->with('error', __('File is not exist.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function fileDelete($id, $file_id)
    {
        if (\Auth::user()->type == 'company') {
            $lead = Lead::find($id);
            $file = LeadFile::find($file_id);
            if ($file) {

                $path = storage_path('uploads/lead_files/' . $file->file_path);
                if (file_exists($path)) {
                    \File::delete($path);
                }
                $file->delete();

                return redirect()->back()->with('success', __('Lead file successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('File is not exist.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function noteStore($id, Request $request)
    {

        if (\Auth::user()->type == 'company') {
            $lead        = Lead::find($id);
            $lead->notes = $request->notes;
            $lead->save();

            LeadActivityLog::create(
                [
                    'user_id' => \Auth::user()->id,
                    'lead_id' => $lead->id,
                    'log_type' => 'Add Notes',
                    'remark' => json_encode(['title' => 'Create new Notes']),
                ]
            );

            return redirect()->back()->with('success', __('Note successfully saved.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied'));
        }
    }

    public function sourceEdit($id)
    {
        $lead    = Lead::find($id);
        $sources = Source::where('created_by', '=', \Auth::user()->creatorId())->get();

        $selected = $lead->sources();
        if ($selected) {
            $selected = $selected->pluck('name', 'id')->toArray();
        }

        return view('lead.sources', compact('lead', 'sources', 'selected'));
    }

    public function sourceUpdate($id, Request $request)
    {
        if (\Auth::user()->type == 'company') {
            $usr        = \Auth::user();
            $lead       = Lead::find($id);
            $lead_users = $lead->users->pluck('id')->toArray();
            if (!empty($request->sources) && count($request->sources) > 0) {
                $lead->sources = implode(',', $request->sources);
            } else {
                $lead->sources = "";
            }
            $lead->save();
            LeadActivityLog::create(
                [
                    'user_id'        =>  $usr->id,
                    'lead_id'        =>  $lead->id,
                    'log_type'       =>  'Update Sources',
                    'remark'         =>  json_encode(['title' => 'Update Sources']),
                ]
            );

            return redirect()->back()->with('success', __('Sources successfully updated.'))->with('status', 'sources');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function sourceDestroy($id, $source_id)
    {
        if (\Auth::user()->type == 'company') {
            $lead    = Lead::find($id);
            $sources = explode(',', $lead->sources);
            foreach ($sources as $key => $source) {
                if ($source_id == $source) {
                    unset($sources[$key]);
                }
            }
            $lead->sources = implode(',', $sources);
            $lead->save();

            return redirect()->back()->with('success', __('Sources successfully deleted.'))->with('status', 'sources');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function discussionCreate($id)
    {
        $lead = Lead::find($id);

        if ($lead) {
            return view('lead.discussions', compact('lead'));
        } else {
            return redirect()->back()->with('error', __('Lead Not Found.'));
        }
    }

    public function discussionStore($id, Request $request)
    {
        $this->validate($request, [
            'comment' => 'required'
        ]);

        if (\Auth::user()->type == 'company' || \Auth::user()->type == 'employee') {
            $usr        = \Auth::user();
            $lead       = Lead::find($id);
            $lead_users = $lead->users->pluck('id')->toArray();

            $discussion             = new LeadDiscussions();
            $discussion->comment    = $request->comment;
            $discussion->lead_id    = $lead->id;
            $discussion->created_by = \Auth::user()->id;
            $discussion->save();

            LeadActivityLog::create(
                [
                    'user_id' => $usr->id,
                    'lead_id' => $lead->id,
                    'log_type' => 'Add Discussion',
                    'remark' => json_encode(['title' => 'Create new Discussion']),
                ]
            );

            return redirect()->back()->with('success', __('Message successfully added.'))->with('status', 'discussion');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    // Lead Calls
    public function callCreate($id)
    {
        $lead = Lead::find($id);

        $users = UserLead::where('lead_id', '=', $lead->id)->get();

        return view('lead.calls', compact('lead', 'users'));
    }

    public function callStore($id, Request $request)
    {
        if (\Auth::user()->type == 'company') {
            $usr       = \Auth::user();
            $lead      = Lead::find($id);
            $validator = \Validator::make(
                $request->all(),
                [
                    'subject'       =>  'required',
                    'call_type'     =>  'required',
                    'user_id'       =>  'required',
                    'duration'      =>  'required',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $leadCall = LeadCall::create(
                [
                    'lead_id'      =>   $lead->id,
                    'subject'      =>   $request->subject,
                    'call_type'    =>   $request->call_type,
                    'duration'     =>   $request->duration,
                    'user_id'      =>   $request->user_id,
                    'description'  =>   $request->description,
                    'call_result'  =>   $request->call_result,
                ]
            );

            LeadActivityLog::create(
                [
                    'user_id' => $usr->id,
                    'lead_id' => $lead->id,
                    'log_type' => 'Create Lead Call',
                    'remark' => json_encode(['title' => 'Create new Lead Call']),
                ]
            );


            return redirect()->back()->with('success', __('Call successfully created.'))->with('status', 'calls');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function callEdit($id, $call_id)
    {
        $lead = Lead::find($id);

        $call  = LeadCall::find($call_id);
        $users = UserLead::where('lead_id', '=', $id)->get();

        return view('lead.calls', compact('call', 'lead', 'users'));
    }

    public function callUpdate($id, $call_id, Request $request)
    {
        if (\Auth::user()->type == 'company') {
            $lead      = Lead::find($id);
            $validator = \Validator::make(
                $request->all(),
                [
                    'subject' => 'required',
                    'call_type' => 'required',
                    'user_id' => 'required',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $call = LeadCall::find($call_id);

            $call->update(
                [
                    'subject' => $request->subject,
                    'call_type' => $request->call_type,
                    'duration' => $request->duration,
                    'user_id' => $request->user_id,
                    'description' => $request->description,
                    'call_result' => $request->call_result,
                ]
            );

            return redirect()->back()->with('success', __('Call successfully updated.'))->with('status', 'calls');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function callDestroy($id, $call_id)
    {
        if (\Auth::user()->type == 'company') {
            $lead = Lead::find($id);
            $task = LeadCall::find($call_id);
            $task->delete();

            return redirect()->back()->with('success', __('Call successfully deleted.'))->with('status', 'calls');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function emailCreate($id)
    {
        $lead = Lead::find($id);
        return view('lead.emails', compact('lead'));
    }

    public function emailStore($id, Request $request)
    {
        if (\Auth::user()->type == 'company') {
            $lead      = Lead::find($id);
            $settings  = Utility::settings();
            $validator = \Validator::make(
                $request->all(),
                [
                    'to' => 'required|email',
                    'subject' => 'required',
                    'description' => 'required',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $leadEmail = LeadEmail::create(
                [
                    'lead_id' => $lead->id,
                    'to' => $request->to,
                    'subject' => $request->subject,
                    'description' => $request->description,
                ]
            );

         

            LeadActivityLog::create(
                [
                    'user_id' => \Auth::user()->id,
                    'lead_id' => $lead->id,
                    'log_type' => 'Create Lead Email',
                    'remark' => json_encode(['title' => 'Create new Deal Email']),
                ]
            );

            return redirect()->back()->with('success', __('Email successfully created!') . ((isset($smtp_error)) ? '<br> <span class="text-danger">' . $smtp_error . '</span>' : ''))->with('status', 'emails');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function showConvertToDeal($id)
    {
        if (\Auth::user()->type == 'company') {
            $lead         = Lead::findOrFail($id);
            $exist_client = User::where('type', '=', 'client')->where('email', '=', $lead->email)->where('created_by', '=', \Auth::user()->creatorId())->first();
            $clients      = User::where('type', '=', 'client')->where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('lead.convert', compact('lead', 'exist_client', 'clients'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function convertToDeal($id, Request $request)
    {
        if (\Auth::user()->type == 'company') {
            $lead = Lead::findOrFail($id);
            
            $usr  = \Auth::user();
            if (!empty($request->clients) && $request->client_check == 'exist') {
                $client = User::where('type', '=', 'client')->where('email', '=', $request->clients)->where('created_by', '=', $usr->creatorId())->first();

                if (empty($client)) {
                    return redirect()->back()->with('error', 'Client is not available now.');
                }
            } else {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'client_name' => 'required',
                        'client_email' => 'required|email|unique:users,email',
                        'client_password' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $user             = new User();
                $user->name       = $request->client_name;
                $user->email      = $request->client_email;
                $user->password   = \Hash::make($request->client_password);
                $user->type       = 'client';
                $user->lang       = 'en';
                $user->created_by = $usr->creatorId();
                $user->save();


                if (!empty($user)) {
                    $client             = new Client();
                    $client->user_id    = $user->id;
                    $client->client_id  = $this->clientNumber();
                    $client->created_by = \Auth::user()->creatorId();
                    $client->save();
                }
            }

            // Create Deal
            $stage = DealStage::where('pipeline_id', '=', $lead->pipeline_id)->first();
            if (empty($stage)) {
                return redirect()->back()->with('error', __('Please create stage for this pipeline.'));
            }
            $deal              = new Deal();
            $deal->name        = $request->name;
            $deal->price       = empty($request->price) ? 0 : $request->price;
            $deal->pipeline_id = $lead->pipeline_id;
            $deal->stage_id    = $stage->id;
            $deal->sources     = in_array('sources', $request->is_transfer) ? $lead->sources : '';
            $deal->products    = in_array('products', $request->is_transfer) ? $lead->products : '';
            $deal->notes       = in_array('notes', $request->is_transfer) ? $lead->notes : '';
            $deal->labels      = $lead->labels;
            $deal->status      = 'Active';
            $deal->created_by  = $lead->created_by;
            $deal->save();

            ClientDeal::create(
                [
                    'deal_id' => $deal->id,
                    'client_id' => $client->id,
                ]
            );

            $leadUsers = UserLead::where('lead_id', '=', $lead->id)->get();
            foreach ($leadUsers as $leadUser) {
                UserDeal::create(
                    [
                        'user_id' => $leadUser->user_id,
                        'deal_id' => $deal->id,
                    ]
                );
            }
            // end

            //Transfer Lead Discussion to Deal
            if (in_array('discussion', $request->is_transfer)) {
                $discussions = LeadDiscussions::where('lead_id', '=', $lead->id)->where('created_by', '=', $usr->creatorId())->get();
                if (!empty($discussions)) {
                    foreach ($discussions as $discussion) {
                        DealDiscussion::create(
                            [
                                'deal_id' => $deal->id,
                                'comment' => $discussion->comment,
                                'created_by' => $discussion->created_by,
                            ]
                        );
                    }
                }
            }
            // end Transfer Discussion

            // Transfer Lead Files to Deal
            if (in_array('files', $request->is_transfer)) {
                $files = LeadFile::where('lead_id', '=', $lead->id)->get();
                if (!empty($files)) {
                    foreach ($files as $file) {
                        $location     = base_path() . '/storage/uploads/lead_files/' . $file->file_path;
                        $new_location = base_path() . '/storage/uploads/deal_files/' . $file->file_path;
                        $copied       = copy($location, $new_location);

                        if ($copied) {
                            DealFile::create(
                                [
                                    'deal_id' => $deal->id,
                                    'file_name' => $file->file_name,
                                    'file_path' => $file->file_path,
                                ]
                            );
                        }
                    }
                }
            }
            // end Transfer Files

            // Transfer Lead Calls to Deal
            if (in_array('calls', $request->is_transfer)) {
                $calls = LeadCall::where('lead_id', '=', $lead->id)->get();
                if (!empty($calls)) {
                    foreach ($calls as $call) {
                        DealCall::create(
                            [
                                'deal_id' => $deal->id,
                                'subject' => $call->subject,
                                'call_type' => $call->call_type,
                                'duration' => $call->duration,
                                'user_id' => $call->user_id,
                                'description' => $call->description,
                                'call_result' => $call->call_result,
                            ]
                        );
                    }
                }
            }
            //end

            // Transfer Lead Emails to Deal
            if (in_array('emails', $request->is_transfer)) {
                $emails = LeadEmail::where('lead_id', '=', $lead->id)->get();
                if (!empty($emails)) {
                    foreach ($emails as $email) {
                        DealEmail::create(
                            [
                                'deal_id' => $deal->id,
                                'to' => $email->to,
                                'subject' => $email->subject,
                                'description' => $email->description,
                            ]
                        );
                    }
                }
            }

            // Update is_converted field as deal_id
            $lead->is_converted = $deal->id;
            $lead->save();

            $settings  = Utility::settings();

            if (isset($settings['convert_lead_to_deal_notification']) && $settings['convert_lead_to_deal_notification'] == 1) {
                $uArr = [
                    'user_name' => \Auth::user()->name,
                    'lead_name' => $lead->name,
                    'lead_email' => $lead->email,
                ]; // dd($uArr);
                Utility::send_slack_msg('lead_to_deal_conversion', $uArr);
            }
            if (isset($settings['telegram_convert_lead_to_deal_notification']) && $settings['telegram_convert_lead_to_deal_notification'] == 1) {
                $uArr = [
                    'user_name' => \Auth::user()->name,
                    'lead_name' => $lead->name,
                    'lead_email' => $lead->email,
                ]; // dd($uArr);
                Utility::send_telegram_msg('lead_to_deal_conversion', $uArr);
            }
            
            $module = "Lead to Deal Conversion";

            $webhook = Utility::webhookSetting($module);
            if ($webhook) {
                $parameter = json_encode($lead);

                // 1 parameter is URL , 2  (Lead Data) parameter is data , 3 parameter is method
                $status = Utility::WebhookCall($webhook['url'], $parameter, $webhook['method']);
                if ($status == true) {
                    return redirect()->back()->with('success', __('Lead to deal conversion  successfully created.'));
                } else {
                    return redirect()->back()->with('error', __('Lead to deal conversion call failed.'));
                }
            }

            return redirect()->back()->with('success', __('Lead to deal conversion successfully converted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function labels($id)
    {
        $lead = Lead::find($id);

        $labels   = Label::where('pipeline_id', '=', $lead->pipeline_id)->get();
        $selected = $lead->labels();
        if ($selected) {
            $selected = $selected->pluck('name', 'id')->toArray();
        } else {
            $selected = [];
        }

        return view('lead.labels', compact('lead', 'labels', 'selected'));
    }

    public function labelStore($id, Request $request)
    {
        if (\Auth::user()->type == 'company') {
            $leads = Lead::find($id);
            if ($request->labels) {
                $leads->labels = implode(',', $request->labels);
            } else {
                $leads->labels = $request->labels;
            }
            $leads->save();

            return redirect()->back()->with('success', __('Labels successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function grid()
    {
        if (\Auth::user()->type == 'company' || \Auth::user()->type == 'employee') {
            $usr = \Auth::user();

            if ($usr->default_pipeline) {
                $pipeline = Pipeline::where('created_by', '=', $usr->creatorId())->where('id', '=', $usr->default_pipeline)->first();
                if (!$pipeline) {
                    $pipeline = Pipeline::where('created_by', '=', $usr->creatorId())->first();
                }
            } else {
                $pipeline = Pipeline::where('created_by', '=', $usr->creatorId())->first();
            }

            $pipelines = Pipeline::where('created_by', '=', $usr->creatorId())->get()->pluck('name', 'id');
            $leads     = Lead::select('leads.*')->join('user_leads', 'user_leads.lead_id', '=', 'leads.id')
                                ->where('user_leads.user_id', '=', $usr->id)
                                ->orderBy('leads.order')
                                ->with('stage')->with('files')->with('pipeline')->with('userEmp')->with('activities')
                                ->with('discussions')->with('calls')->with('emails')->with('users')
                                ->get();

            $defualtView         = new UserDefualtView();
            $defualtView->route  = \Request::route()->getName();
            $defualtView->module = 'lead';
            $defualtView->view   = 'list';
            User::userDefualtView($defualtView);
            return view('lead.grid', compact('pipelines', 'pipeline', 'leads'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function changePipeline(Request $request)
    {
        $user                   = \Auth::user();
        $user->default_pipeline = $request->pipeline_id;
        $user->save();

        return redirect()->back();
    }

    function clientNumber()
    {
        $latest = Client::where('created_by', '=', \Auth::user()->creatorId())->latest()->first();
        if (!$latest) {
            return 1;
        }

        return $latest->client_id + 1;
    }


    public function importFile()
    {
        return view('lead.import');
    }


    public function import(Request $request)
    {
        $rules = [
            'file' => 'required|mimes:csv,txt',
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        $leads          =    (new LeadImport())->toArray(request()->file('file'))[0];
        $totalCustomer      =    count($leads) - 1;
        $errorArray         =    [];


        for ($i = 1; $i <= count($leads) - 1; $i++) {
            $lead                           = $leads[$i];
            $leadByEmail                    = Lead::where('email', $lead[1])->first();
            if (empty($leadByEmail)) {
                $leadData                   = new lead();
                $leadData->name             =   $lead[0];
                $leadData->email            =   $lead[1];
                $leadData->phone_no        =    $lead[2];
                $leadData->user_id        =     $lead[3];
                $leadData->sources        =     $lead[4];
                $leadData->project_id        =  $lead[5];
                $leadData->created_by = auth()->user()->id;
                $leadData->notes = $lead[6];
                $leadData->save();

                if (!empty($leadData)) {
                    $leaduser                   =    new UserLead();
                    $leaduser->user_id          =    \Auth::user()->creatorId();
                    $leaduser->lead_id      =    $leadData->id;
                    $leaduser->save();
                }

            }
        }

        $errorRecord = [];
        if (empty($errorArray)) {
            $data['status'] = 'success';
            $data['msg']    = __('Record successfully imported');
        } else {
            $data['status'] = 'error';
            $data['msg']    = count($errorArray) . ' ' . __('Record imported fail out of' . ' ' . $totalCustomer . ' ' . 'record');

            foreach ($errorArray as $errorData) {
                $errorRecord[] = implode(',', $errorData);
            }

            \Session::put('errorArray', $errorRecord);
        }

        return redirect()->back()->with($data['status'], $data['msg']);
    }
 
public function updateLeadStatusInterested(Request $request, $id)
{
    try {
        // Validate the incoming request data
        $request->validate([
            'requirements' => 'nullable|string|max:255',
            'budget' => 'nullable|integer|exists:budgets,id',
            'property_type' => 'nullable|string|max:255',
            'property_stage' => 'nullable|string|max:255',
            'followup_type' => 'nullable|string|max:255',
            'followup_on' => 'nullable|date',
            'sources' => 'nullable|string|max:255',
        ]);

      
        // Find the lead by ID
        $lead = Lead::findOrFail($id);

        // Update the lead data with the request inputs
        $lead->status_id = '1';
        $lead->requirements = $request->input('requirements');
        $lead->budget_id = $request->input('budget_id');
        $lead->property_type = $request->input('property_type');
        $lead->property_stage = $request->input('property_stage');
        $lead->followup_type = $request->input('followup_type');
        $lead->followup_on = $request->input('followup_on');
        $lead->sources = $request->input('sources');
        $lead->alternative_no = $request->input('alternative_no');
        $lead->feedback = $request->input('notes');
        $lead->save();
        
        $data = new LeadStatusHistory();
        $data->lead_id = $id;
        $data->status_id = '1';
        $data->notes = $request->input('notes');
        $data->save();
        
        Log::info("Lead status updated successfully for Lead ID: {$id}");
        // Redirect or return a response
        return redirect()->back()->with('success', 'Lead status updated successfully.');
        
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        Log::error("Lead not found for ID: {$id}. Error: {$e->getMessage()}");
        return redirect()->back()->with('error', 'Lead not found.');
    } catch (\Exception $e) {
        // Log general exceptions
        Log::error("An error occurred while updating lead ID: {$id}. Error: {$e->getMessage()}");

        // Return with error response
        return redirect()->back()->with('error', 'An unexpected error occurred while updating the lead.');
    }
}


public function updateLeadStatusNotinterested(Request $request, $id)
{
    try {
        // Validate the input data
        $validated = $request->validate([
            'reason' => 'required|string|max:255',
            'feedback' => 'nullable|string|max:1000',
        ]);

        // Retrieve the lead by ID
        $lead = Lead::findOrFail($id);

        // Update the lead status and other fields
        $lead->status_id = '2';
        $lead->reason = $validated['reason'];
        $lead->feedback = $validated['feedback'];
        $lead->save();
        
        $data = new LeadStatusHistory();
        $data->lead_id = $id;
        $data->status_id = '2';
        $data->notes = $request->input('feedback');
        $data->save();

        // Log the feedback submission for debugging
        Log::info("Feedback submitted for Lead ID $id: Reason - {$validated['reason']}, Feedback - {$validated['feedback']}");

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Feedback submitted successfully.');
    } catch (\Exception $e) {
        // Log the exception error
        Log::error("Error submitting feedback for Lead ID $id: " . $e->getMessage());

        // Redirect back with an error message
        return redirect()->back()->with('error', 'An error occurred while submitting your feedback.');
    }
}

  public function callback(Request $request, $id)
{
    // Validate the incoming data
    $validated = $request->validate([
        'callbackReason' => 'required|string|max:255',
        'followupDateTime' => 'required|date',
        'notes' => 'nullable|string|max:1000'
    ]);

    try {
        // Find the lead by ID or fail if not found
        $lead = Lead::findOrFail($id);
        
        // Update the lead's information
        $lead->status_id = 3; // Assuming 3 is the ID for the "Callback Scheduled" status
        $lead->followup_on = $validated['followupDateTime'];
        $lead->notes = $validated['notes'];
        $lead->save();
        
        // Create a new record in the lead status history
        $data = new LeadStatusHistory();
        $data->lead_id = $id;
        $data->status_id = 3; // Assuming 3 represents the correct status
        $data->notes = $validated['notes'];
        $data->save();

        // Redirect with a success message
        return redirect()->back()->with('success', 'Callback scheduled successfully.');
    } catch (\Exception $e) {
        // Log the error message for debugging
        Log::error("Error saving callback: " . $e->getMessage());

        // Redirect back with an error message
        return redirect()->back()->with('error', 'An error occurred while scheduling the callback.');
    }
}


public function lostLead(Request $request, $id)
{
    // Validate the incoming request data
    $request->validate([
        'reason' => 'required|string|max:255',
        'notes' => 'nullable|string',
    ]);
    
    // Find the lead by ID
    $lead = Lead::findOrFail($id);
    $lead->substatus_id = '2'; // Assuming there is a 'status' field in the 'leads' table
    $lead->reason = $request->input('reason');
    $lead->notes = $request->input('notes'); // Assuming there is a 'notes' field
    $lead->save();
    
     // Create a new record in the lead status history
        $data = LeadStatusHistory::latest()->first();
        $data->lead_id = $id;
        $data->status_id = '1';
        $lead->substatus_id = '2';
        $data->notes = $request->input('reason');
        $data->save();
    // Redirect or return a response
    return redirect()->back()->with('success', 'Lead marked as lost successfully.');
}

public function taskCreate(Request $request, $id)
{
    try {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'followupDateTime' => 'nullable|date', // Validate follow-up date if provided
        ]);

        // Find the lead by ID or fail with a 404 response
        $lead = Lead::findOrFail($id);

        // Update the lead's fields
        $lead->update([
            'substatus_id' => 2, // Updated substatus ID as per the new value
            'followup_on' => $validatedData['followupDateTime'] ?? null,
            'reason' => $validatedData['reason'],
            'notes' => $validatedData['notes'] ?? null,
        ]);

        // Find the last record in LeadStatusHistory for this lead
        $leadStatusHistory = LeadStatusHistory::where('lead_id', $id)->latest()->first();

        if ($leadStatusHistory) {
            // Update the existing record
            $leadStatusHistory->update([
                'status_id' => 1, // Set status ID directly as an integer
                'substatus_id' => 2, // Match the updated substatus in the lead
                'notes' => $validatedData['reason'], // Log the reason in notes
            ]);
        } else {
            // Create a new lead status history record if no record exists
            $leadStatusHistory = LeadStatusHistory::create([
                'lead_id' => $id,
                'status_id' => 1,
                'substatus_id' => 4,
                'notes' => $validatedData['reason'],
            ]);
        }

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Lead updated and history recorded successfully.');

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Handle not found exception (e.g., lead not found)
        return redirect()->back()->withErrors('Lead not found.');
    } catch (\Exception $e) {
        // Handle any other exceptions
        return redirect()->back()->withErrors('An error occurred: ' . $e->getMessage());
    }
}


public function taskRescheduled(Request $request, $id)
{
    try {
        // Validate the incoming request data
        $validatedData = $request->validate([
            //'reason' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'followupDateTime' => 'nullable|date', // Validate follow-up date if provided
        ]);

        // Find the lead by ID or fail with a 404 response
        $lead = Lead::findOrFail($id);

        // Update the lead's fields
        $lead->update([
            'substatus_id' => 3, // Updated substatus ID as per the new value
            'followup_on' => $validatedData['followupDateTime'] ?? null,
           // 'reason' => $validatedData['reason'],
             'substatus_id' => 3, // Match the updated substatus in the lead
            'notes' => $validatedData['notes'] ?? null,
        ]);

        // Find the last record in LeadStatusHistory for this lead
        $leadStatusHistory = LeadStatusHistory::where('lead_id', $id)->latest()->first();

        if ($leadStatusHistory) {
            // Update the existing record
            $leadStatusHistory->update([
                'status_id' => 1, // Set status ID directly as an integer
                'substatus_id' => 3, // Match the updated substatus in the lead
                'notes' => $validatedData['notes'] ?? null, // Log the reason in notes
            ]);
        } else {
            // Create a new lead status history record if no record exists
            $leadStatusHistory = LeadStatusHistory::create([
                'lead_id' => $id,
                'status_id' => 1,
                'substatus_id' => 3,
                'notes' => $validatedData['notes'],
            ]);
        }

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Lead updated and history recorded successfully.');

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Handle not found exception (e.g., lead not found)
        return redirect()->back()->withErrors('Lead not found.');
    } catch (\Exception $e) {
        // Handle any other exceptions
        return redirect()->back()->withErrors('An error occurred: ' . $e->getMessage());
    }
}

public function wonLead(Request $request, $id)
{
    try {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'reason' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // Find the lead by ID or return a 404 if not found
        $lead = Lead::findOrFail($id);

        // Update the lead's main fields
        $lead->update([
            'status_id' => 1, // Set the status ID to 1 (assumption based on context)
            'substatus_id' => 1, // Set the updated substatus
            'reason' => $validatedData['reason'] ?? null,
            'notes' => $validatedData['notes'] ?? null,
        ]);

        // Update or create a record in LeadStatusHistory
        $leadStatusHistory = LeadStatusHistory::updateOrCreate(
            ['lead_id' => $id],
            [
                'status_id' => 1, // Ensure the correct status ID is set
                'substatus_id' => 1, // Ensure the correct substatus ID is set
                'notes' => $validatedData['notes'] ?? null, // Save notes
            ]
        );

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Lead updated and history recorded successfully.');

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Return with an error if the lead is not found
        return redirect()->back()->withErrors('Lead not found.');
    } catch (\Exception $e) {
        // Handle general exceptions with an error message
        return redirect()->back()->withErrors('An error occurred: ' . $e->getMessage());
    }
}


   public function createBooking($id)
    {
        // Example: Retrieve the lead details to display in the form if needed
        $lead_id = $id;
        $projects = Project::get();
     //   dd($projects);
        // Pass lead details to the view
       return view('bookings.create', compact('lead_id','projects'));
    }
    
   public function storeBooking(Request $request)
{
    try {
        // Validate incoming request data
    /*    $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'date_of_booking' => 'required|date',
            'project_id' => 'required|exists:projects,id',
            'developer_name' => 'required|string|max:255',
            'source_fund' => 'required|string',
            'unit_number' => 'required|string|max:50',
            'pan_number' => 'required|string|max:10',
            'area' => 'required|numeric',
            'measure' => 'required|string|max:50',
            'scheme' => 'required|string|max:255',
            'booking_docs' => 'nullable|file|mimes:pdf,jpg,png',
            'kyc_docs' => 'nullable|file|mimes:pdf,jpg,png',
        ]); */

        // Store uploaded files if present
        $bookingDocsPath = $request->file('booking_docs') ? $request->file('booking_docs')->store('booking_docs') : null;
        $kycDocsPath = $request->file('kyc_docs') ? $request->file('kyc_docs')->store('kyc_docs') : null;

        // Create a new booking entry
        $booking = new Booking();
        $booking->lead_id = $request->input('lead_id');
        $booking->date_of_booking = $request->input('date_of_booking');
        $booking->project_id = $request->input('project_id');
        $booking->developer_name = $request->input('developer_name');
        $booking->source_of_funds = $request->input('source_fund');
        $booking->unit_number = $request->input('unit_number');
        $booking->pan_number = $request->input('pan_number');
        $booking->area = $request->input('area');
        $booking->measure = $request->input('measure');
        $booking->scheme = $request->input('scheme');
        $booking->booking_docs = $bookingDocsPath;
        $booking->kyc_docs = $kycDocsPath;
        $booking->created_by = auth()->id();
        $booking->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Booking submitted successfully!');
    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Booking submission error: ' . $e->getMessage());

        // Redirect back with an error message
        return redirect()->back()->with('error', 'An error occurred while submitting the booking. Please try again later.');
    }
}

public function bookinglist()
{
    // Fetch all bookings created by the authenticated user with pagination (e.g., 10 per page)
    $bookings = Booking::where('created_by', auth()->id())->paginate(10);

    // Pass the bookings data to the 'bookings.index' view
    return view('bookings.index', compact('bookings'));
}

public function updateBooking(Request $request, $id)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'customer_name' => 'required|string|max:255',
        'booking_date' => 'required|date',
        'status' => 'required|string|in:confirmed,cancelled,pending',
        // Add more validation rules as needed
    ]);

    // Find the booking by ID
    $booking = Booking::find($id);
    
    dd($booking);

    // Check if the booking exists
    if (!$booking) {
        return response()->json(['message' => 'Booking not found'], 404);
    }

    // Update the booking with validated data
    $booking->update($validatedData);

    // Return a success response
    return response()->json([
        'message' => 'Booking updated successfully',
        'booking' => $booking
    ], 200);
}



}
