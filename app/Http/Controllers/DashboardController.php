<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Contract;
use App\Models\Deal;
use App\Models\DealStage;
use App\Models\Employee;
use App\Models\Estimate;
use App\Models\event;
use App\Models\Goal;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\Lead;
use App\Models\LeadStage;
use App\Models\Meeting;
use App\Models\Order;
use App\Models\Pipeline;
use App\Models\Plan;
use App\Models\Project;
use App\Models\Projects;
use App\Models\ProjectStage;
use App\Models\ProjectTask;
use App\Models\Budget;
use App\Models\Support;
use App\Models\User;
use App\Models\Utility;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // <-- Add this line
use Cookie;

class DashboardController extends Controller
{
    public function index()
    {
        // $getInvoiceProductsData        = Utility::getInvoiceProductsData();
       if (\Auth::user()->type == 'company') {
          return redirect('/analytics');
          }
          else
          {
          return redirect()->route('dashboard.useranalytics');
          }

        
        if(\Auth::check())
        {

            $data['estimateOverviewColor'] = Estimate::$statuesColor;
            $data['invoiceOverviewColor']  = Invoice::$statuesColor;
            $data['projectStatusColor']    = Project::$projectStatusColor;

            if(\Auth::user()->type == 'super admin')
            {
                $user                       = \Auth::user();
                $user['total_user']         = $user->countCompany();
                $user['total_paid_user']    = $user->countPaidCompany();
                $user['total_orders']       = Order::total_orders();
                $user['total_orders_price'] = Order::total_orders_price();
                $user['total_plan']         = Plan::total_plan();
                $user['most_purchese_plan'] = (!empty(Plan::most_purchese_plan()) ? Plan::most_purchese_plan()->name : '');
                $chartData                  = $this->getOrderChart(['duration' => 'week']);

                return view('dashboard.super_admin', compact('user', 'chartData'));
            }
            elseif(\Auth::user()->type == 'company')
            {
                $data['totalClient']     = User::where('created_by', \Auth::user()->creatorId())->where('type', 'client')->count();
                $data['totalEmployee']   = User::where('created_by', \Auth::user()->creatorId())->where('type', 'employee')->count();
                //dd($data['totalEmployee']);
                $data['totalProject']    = $totalProject = Project::where('created_by', \Auth::user()->creatorId())->count();
                

                $data['totalEstimation'] = $totalEstimation = Estimate::where('created_by', \Auth::user()->creatorId())->count();
                $data['totalInvoice']    = $totalInvoice = Invoice::where('created_by', \Auth::user()->creatorId())->count();
                $data['totalLead']       = Lead::where('created_by', \Auth::user()->creatorId())->count();
              // dd($data['totalLead']);
                $data['totalDeal']       = Deal::where('created_by', \Auth::user()->creatorId())->count();
                $data['totalItem']       = Item::where('created_by', \Auth::user()->creatorId())->count();
                
                $statusLabels = [
                                  0 => 'Pending',
                                  1 => 'Interested',
                                  2 => 'Not Interested'
                             ];

    // Get lead count by status_id
    $leadsCount = DB::table('leads')
                    ->select('status_id', DB::raw('count(*) as count'))
                    ->groupBy('status_id')
                    ->get();

    // Map the status_id to its respective label
    $data['leadsCount'] = $leadsCount->map(function($item) use ($statusLabels) {
        $item->status = $statusLabels[$item->status_id] ?? 'Unknown';
        unset($item->status_id); // Remove the status_id if not needed
        return $item;
    });
    
    $leadsCount = DB::table('leads')
                    ->select('user_id', DB::raw('count(*) as count'))
                    ->groupBy('user_id')
                    ->get();

    $data['leadsUserCount']  = DB::table('leads')
                    ->join('users', 'leads.user_id', '=', 'users.id')  // Join with the users table
                    ->select('leads.user_id', 'users.name', DB::raw('count(*) as count'))
                    ->groupBy('leads.user_id', 'users.name')  // Group by user_id and user name
                    ->get();
    
    $data['leadsSourceCount'] = DB::table('leads')
                    ->join('sources', 'leads.sources', '=', 'sources.id')  // Join with the sources table
                    ->select('sources.name', DB::raw('count(*) as count'))  // Select source name and lead count
                    ->groupBy('sources.name')  // Group by source name
                    ->get();
                    
    $data['leadsProjectCount'] = DB::table('leads')
                    ->join('projects', 'leads.project_id', '=', 'projects.id')  // Join with the projects table
                    ->select('projects.title', DB::raw('count(*) as count'))  // Select project name and lead count
                    ->groupBy('projects.title')  // Group by project name
                    ->get();
                    
            //        dd($data['leadsProjectCount']);
            

                    
                    

                $estimationStatus = Estimate::$statues;
                $estimations      = [];

                $statusColor = [
                    'success',
                    'info',
                    'warning',
                    'danger',
                ];

                foreach($estimationStatus as $k => $status)
                {
                    $estimation['status']     = $status;
                    $estimation['total']      = $total = Estimate::where('created_by', \Auth::user()->creatorId())->where('status', $k)->count();
                    $percentage               = ($totalEstimation != 0) ? ($total * 100) / $totalEstimation : '0';
                    $estimation['percentage'] = number_format($percentage, 2);
                    $estimations[]            = $estimation;
                }

                $invoiceStatus = Invoice::$statues;
                $invoices      = [];
                foreach($invoiceStatus as $k => $status)
                {
                    $invoice['status']     = $status;
                    $invoice['total']      = $total = Invoice::where('created_by', \Auth::user()->creatorId())->where('status', $k)->count();
                    $percentage            = ($totalInvoice != 0) ? ($total * 100) / $totalInvoice : '0';
                    $invoice['percentage'] = number_format($percentage, 2);
                    $invoices[]            = $invoice;
                }


                $projectStatus = Project::$projectStatus;
                $projects      = $projectLabel = $projectData = [];

                foreach($projectStatus as $k => $status)
                {
                    $project['status']     = $projectLabel[] = $status;
                    $project['total']      = $total = Project::where('created_by', \Auth::user()->creatorId())->where('status', $k)->count();
                    $percentage            = ($totalProject != 0) ? ($total * 100) / $totalProject : '0';
                    $project['percentage'] = $projectData[] = number_format($percentage, 2);
                    $projects[]            = $project;
                }

                $data['topDueInvoice']      = Invoice::where('created_by', \Auth::user()->creatorId())
                    ->where('due_date', '<', date('Y-m-d'))->with(['items', 'payments', 'creditNote','clients'])->limit(5)->get();
                $data['topDueProject']      = Project::where('created_by', \Auth::user()->creatorId())->where('due_date', '<', date('Y-m-d'))->limit(5)->get();
                $data['topDueTask']         = ProjectTask::select('project_tasks.*', 'projects.title as project_title')->leftjoin('projects', 'project_tasks.project_id', 'projects.id')->where('projects.created_by', \Auth::user()->creatorId())->where('project_tasks.due_date', '<', date('Y-m-d'))->limit(5)->with('taskUser')->get();
                $data['topMeeting']         = Meeting::where('created_by', \Auth::user()->creatorId())->where('date', '>', date('Y-m-d'))->limit(5)->get();
                $data['thisWeekEvent']      = Event::whereBetween(
                    'start_date', [
                                    Carbon::now()->startOfWeek(),
                                    Carbon::now()->endOfWeek(),
                                ]
                )->where('created_by', \Auth::user()->creatorId())->limit(5)->get();
                $data['contractExpirySoon'] = Contract::where('created_by', \Auth::user()->creatorId())->whereMonth('start_date', date('m'))->whereYear('start_date', date('Y'))->whereMonth('end_date', date('m'))->whereYear('end_date', date('Y'))->get();

                $date               = \Carbon\Carbon::today()->subDays(7);
                $data['newTickets'] = Support::where('created_by', \Auth::user()->creatorId())->where('created_at', '>', $date)->get();
                $data['newClients'] = User::where('created_by', \Auth::user()->creatorId())->where('type', 'client')->orderBy('id', 'desc')->limit(5)->get();

                $data['estimationOverview'] = $estimations;
                $data['invoiceOverview']    = $invoices;
                $data['projects']           = $projects;
                $data['projectLabel']       = $projectLabel;
                $data['projectData']        = $projectData;


                $data['goals'] = Goal::where('created_by', '=', \Auth::user()->creatorId())->where('display', 1)->get();

                $data['pipelines']     = Pipeline::where('created_by', '=', \Auth::user()->creatorId())->count();
                $data['leadStages']    = LeadStage::where('created_by', '=', \Auth::user()->creatorId())->count();
                $data['dealStages']    = DealStage::where('created_by', '=', \Auth::user()->creatorId())->count();
                $data['projectStages'] = ProjectStage::where('created_by', '=', \Auth::user()->creatorId())->count();

                $users = User::find(\Auth::user()->creatorId());
                $plan = Plan::find($users->plan);

                if($plan->storage_limit > 0)
                {
                $storage_limit = ($users->storage_limit / $plan->storage_limit) * 100;
                }
                else{
                    $storage_limit = 0;
                }
                return view('dashboard.index', compact('data','users','plan','storage_limit'));
            }
            elseif(\Auth::user()->type == 'client')
            {

                $data['totalProject']    = $totalProject = Project::where('client', \Auth::user()->id)->count();
                $data['totalEstimation'] = $totalEstimation = Estimate::where('client', \Auth::user()->id)->count();
                $data['totalInvoice']    = $totalInvoice = Invoice::where('client', \Auth::user()->id)->count();
                $data['totalDeal']       = Deal::leftjoin('client_deals', 'client_deals.deal_id', 'deals.id')->where('client_deals.client_id', \Auth::user()->id)->count();


                $estimationStatus = Estimate::$statues;
                $estimations      = [];
                foreach($estimationStatus as $k => $status)
                {
                    $estimation['status']     = $status;
                    $estimation['total']      = $total = Estimate::where('client', \Auth::user()->id)->where('status', $k)->count();
                    $percentage               = ($totalEstimation != 0) ? ($total * 100) / $totalEstimation : '0';
                    $estimation['percentage'] = number_format($percentage, 2);
                    $estimations[]            = $estimation;
                }


                $invoiceStatus = Invoice::$statues;
                $invoices      = [];
                foreach($invoiceStatus as $k => $status)
                {
                    $invoice['status']     = $status;
                    $invoice['total']      = $total = Invoice::where('client', \Auth::user()->id)->where('status', $k)->count();
                    $percentage            = ($totalInvoice != 0) ? ($total * 100) / $totalInvoice : '0';
                    $invoice['percentage'] = number_format($percentage, 2);
                    $invoices[]            = $invoice;
                }


                $projectStatus = Project::$projectStatus;
                $projects      = $projectLabel = $projectData = [];

                foreach($projectStatus as $k => $status)
                {
                    $project['status']     = $projectLabel[] = $status;
                    $project['total']      = $total = Project::where('client', \Auth::user()->id)->where('status', $k)->count();
                    $percentage            = ($totalProject != 0) ? ($total * 100) / $totalProject : '0';
                    $project['percentage'] = $projectData[] = number_format($percentage, 2);
                    $projects[]            = $project;
                }

                $data['topDueInvoice'] = Invoice::where('client', \Auth::user()->id)->where('due_date', '<', date('Y-m-d'))->limit(5)->with('clients')->get();
                $data['topDueProject'] = Project::where('client', \Auth::user()->id)->where('due_date', '<', date('Y-m-d'))->limit(5)->get();

                $data['contractExpirySoon'] = Contract::where('client', \Auth::user()->id)->whereMonth('start_date', date('m'))->whereYear('start_date', date('Y'))->whereMonth('end_date', date('m'))->whereYear('end_date', date('Y'))->get();

                $date = \Carbon\Carbon::today()->subDays(7);


                $data['estimationOverview'] = $estimations;
                $data['invoiceOverview']    = $invoices;
                $data['projects']           = $projects;
                $data['projectLabel']       = $projectLabel;
                $data['projectData']        = $projectData;

                $data['goals'] = Goal::where('created_by', '=', \Auth::user()->creatorId())->where('display', 1)->get();


                $users = User::find(\Auth::user()->creatorId());
                $plan = Plan::find($users->plan);

                if($plan->storage_limit > 0)
                {
                $storage_limit = ($users->storage_limit / $plan->storage_limit) * 100;
                }
                else{
                    $storage_limit = 0;
                }
                return view('dashboard.index', compact('data','users','plan','storage_limit'));

                // return view('dashboard.index', compact('data'));
            }
            elseif(\Auth::user()->type == 'employee')
            {

                $data['totalProject'] = $totalProject = Project::leftjoin('project_users', 'project_users.project_id', 'projects.id')->where('project_users.user_id', \Auth::user()->id)->count();
                $data['totalLead']    = Lead::where('user_id', \Auth::user()->id)->count();

                $data['totalDeal'] = Deal::leftjoin('user_deals', 'user_deals.deal_id', 'deals.id')->where('user_deals.user_id', \Auth::user()->id)->count();
                $data['totalItem'] = Item::where('created_by', \Auth::user()->creatorId())->count();


                $projectStatus = Project::$projectStatus;
                $projects      = $projectLabel = $projectData = [];

                foreach($projectStatus as $k => $status)
                {
                    $project['status']     = $projectLabel[] = $status;
                    $project['total']      = $total = Project::leftjoin('project_users', 'project_users.project_id', 'projects.id')->where('project_users.user_id', \Auth::user()->id)->where('status', $k)->count();
                    $percentage            = ($totalProject != 0) ? ($total * 100) / $totalProject : '0';
                    $project['percentage'] = $projectData[] = number_format($percentage, 2);
                    $projects[]            = $project;
                }


                $data['topDueProject'] = Project::leftjoin('project_users', 'project_users.project_id', 'projects.id')->where('project_users.user_id', \Auth::user()->id)->where('due_date', '<', date('Y-m-d'))->limit(5)->get();
                $data['topDueTask']    = ProjectTask::where('assign_to', \Auth::user()->id)->where('due_date', '<', date('Y-m-d'))->limit(5)->get();

                $employee           = Employee::where('user_id', \Auth::user()->id)->first();
                $data['topMeeting'] = Meeting::where('department', 0)->orWhereIn(
                    'designation', [
                                     0,
                                     $employee->designation,
                                 ]
                )->orWhereIn(
                    'department', [
                                    0,
                                    $employee->department,
                                ]
                )->where('date', '>', date('Y-m-d'))->limit(5)->get();

                $data['thisWeekEvent'] = Event::whereBetween(
                    'start_date', [
                                    Carbon::now()->startOfWeek(),
                                    Carbon::now()->endOfWeek(),
                                ]
                )->whereIn(
                    'department', [
                                    0,
                                    $employee->department,
                                ]
                )->orWhereIn(
                    'employee', [
                                  0,
                                  \Auth::user()->id,
                              ]
                )->limit(5)->get();



                $data['projects']     = $projects;
                $data['projectLabel'] = $projectLabel;
                $data['projectData']  = $projectData;

                $data['goals'] = Goal::where('created_by', '=', \Auth::user()->creatorId())->where('display', 1)->get();

                $date                       = date("Y-m-d");
                $data['employeeAttendance'] = Attendance::orderBy('id', 'desc')->where('employee_id', '=', \Auth::user()->id)->where('date', '=', $date)->first();

                $users = User::find(\Auth::user()->creatorId());
                $plan = Plan::find($users->plan);

                if($plan->storage_limit > 0)
                {
                $storage_limit = ($users->storage_limit / $plan->storage_limit) * 100;
                }
                else{
                    $storage_limit = 0;
                }
                return view('dashboard.index', compact('data','users','plan','storage_limit'));
                // return view('dashboard.index', compact('data'));
            }

        }
        else
        {

            if(!file_exists(storage_path() . "/installed"))
            {
                header('location:install');
                die;
            }
            else
            {
                $settings = Utility::settings();

                if ($settings['display_landing_page'] == 'on' && \Schema::hasTable('landing_page_settings')) {
                    return view('landingpage::layouts.landingpage');
                } else {
                    return redirect('login');
                }
            }


        }

    }


    
    
    public function analytics()
    {
    // Get lead count by status_id
    $data['totalLeadCount'] = DB::table('leads')->count();
                    
     $data['pendingCount'] = DB::table('leads')
    ->where('status_id', 0)
    ->count();
    
    $data['interestedCount'] = DB::table('leads')
    ->where('status_id', 1)
    ->count();

     $data['NotinterestedCount'] = DB::table('leads')
    ->where('status_id', 2)
    ->count();
    
     $data['CallbackCount'] = DB::table('leads')
    ->where('status_id', 3)
    ->count();
    
    
     $data['WonCount'] = DB::table('leads')
    ->where('substatus_id', 1)
    ->count();
    
     $data['SitevisitCount'] = DB::table('leads')
    ->where('substatus_id', 7)
    ->count();
    
    
    $data['usersdata'] = DB::table('leads')
    ->join('users', 'leads.user_id', '=', 'users.id') // Joining leads with users table
    ->select(
        'users.name as userName',
        'leads.user_id',
        DB::raw('COUNT(*) as totalLeadCount'),
        DB::raw('SUM(CASE WHEN status_id = 0 THEN 1 ELSE 0 END) as pendingCount'),
        DB::raw('SUM(CASE WHEN status_id = 1 THEN 1 ELSE 0 END) as interestedCount'),
        DB::raw('SUM(CASE WHEN status_id = 2 THEN 1 ELSE 0 END) as notInterestedCount'),
        DB::raw('SUM(CASE WHEN status_id = 3 THEN 1 ELSE 0 END) as callbackCount'),
        DB::raw('SUM(CASE WHEN substatus_id = 1 THEN 1 ELSE 0 END) as wonCount'),
        DB::raw('SUM(CASE WHEN substatus_id = 4 THEN 1 ELSE 0 END) as siteVisitCount')
    )
    ->groupBy('leads.user_id', 'users.name') // Grouping by user ID and user name
    ->get();
    
    
  $data['userscallbackdata'] = DB::table('leads')
    ->join('users', 'leads.user_id', '=', 'users.id') // Joining leads with users table
    ->select(
        'users.name as userName',
        'leads.user_id',
        DB::raw('COUNT(*) as totalLeadCount'), // Total leads for the user
        DB::raw('SUM(CASE WHEN substatus_id = 8 THEN 1 ELSE 0 END) as notPicked'), // Substatus Not Picked
        DB::raw('SUM(CASE WHEN substatus_id = 10 THEN 1 ELSE 0 END) as onRequest'), // Substatus On Request
        DB::raw('SUM(CASE WHEN substatus_id = 9 THEN 1 ELSE 0 END) as notReachable'), // Substatus Not Reachable
        DB::raw('SUM(CASE WHEN substatus_id = 11 THEN 1 ELSE 0 END) as switchOff') // Substatus Switch Off
    )
    ->groupBy('leads.user_id', 'users.name') // Grouping by user ID and user name
    ->get();
    
   $data['callbackdata'] = DB::table('leads')
    ->select(
        DB::raw('COUNT(*) as totalLeadCount'), // Total leads for the status
        DB::raw('SUM(CASE WHEN substatus_id = 8 THEN 1 ELSE 0 END) as notPicked'), // Substatus Not Picked
        DB::raw('SUM(CASE WHEN substatus_id = 10 THEN 1 ELSE 0 END) as onRequest'), // Substatus On Request
        DB::raw('SUM(CASE WHEN substatus_id = 9 THEN 1 ELSE 0 END) as notReachable'), // Substatus Not Reachable
        DB::raw('SUM(CASE WHEN substatus_id = 11 THEN 1 ELSE 0 END) as switchOff') // Substatus Switch Off
    )
    ->get();

//dd($data['callbackleads']);

$data['budgetWiseData'] = DB::table('leads')
    ->join('budgets', 'leads.budget_id', '=', 'budgets.id') // Join with budgets table
    ->select(
        'budgets.name as budgetName', // Budget name
        DB::raw('COUNT(*) as totalLeads') // Count total leads for each budget
    )
    ->groupBy('leads.budget_id', 'budgets.name') // Group by budget ID and budget name
    ->get();

  

    $data['leadsUserCount']  = DB::table('leads')
                    ->join('users', 'leads.user_id', '=', 'users.id')  // Join with the users table
                    ->select('leads.user_id', 'users.name', DB::raw('count(*) as count'))
                    ->groupBy('leads.user_id', 'users.name')  // Group by user_id and user name
                    ->get();
    
    $data['leadsSourceCount'] = DB::table('leads')
                    ->join('sources', 'leads.sources', '=', 'sources.id')  // Join with the sources table
                    ->select('sources.name', DB::raw('count(*) as count'))  // Select source name and lead count
                    ->groupBy('sources.name')  // Group by source name
                    ->get();
                    
    $data['leadsProjectCount'] = DB::table('leads')
                    ->join('projects', 'leads.project_id', '=', 'projects.id')  // Join with the projects table
                    ->select('projects.title', DB::raw('count(*) as count'))  // Select project name and lead count
                    ->groupBy('projects.title')  // Group by project name
                    ->get();
                    
    $data['budgetWiseTeamData'] = User::select('users.name as userName', 'budgets.name as budgetsName', DB::raw('count(leads.id) as leadCount'))
    ->join('leads', 'users.id', '=', 'leads.user_id') // Join users with leads
    ->join('budgets', 'leads.budget_id', '=', 'budgets.id') // Join the budget table using budget_id
    ->groupBy('users.name', 'budgets.name') // Group by user and budget name
    ->orderBy('users.name') // Optional: To order by user name
    ->get();
    
    
$data['budgetWiseTeamData'] = User::select('users.name as userName', 'budgets.name as budgetsName', DB::raw('count(leads.id) as leadCount'))
    ->join('leads', 'users.id', '=', 'leads.user_id') // Join users with leads
    ->join('budgets', 'leads.budget_id', '=', 'budgets.id') // Join the budget table using budget_id
    ->groupBy('users.name', 'budgets.name') // Group by user and budget name
    ->orderBy('users.name') // Optional: To order by user name
    ->get();

$budgetNames = Budget::all()->pluck('name'); // Get all budget names

// Initialize an array to structure the data with user names as keys and budget names as inner keys
$structuredData = [];

foreach ($data['budgetWiseTeamData'] as $item) {
    $structuredData[$item->userName][$item->budgetsName] = $item->leadCount;
}

// Fill in the missing data with 0 count for users who don't have leads for all budgets
foreach ($structuredData as $userName => $budgets) {
    foreach ($budgetNames as $budgetName) {
        if (!isset($budgets[$budgetName])) {
            $structuredData[$userName][$budgetName] = 0; // If budget is missing, set the count to 0
        }
    }
}

$data['pivotData'] = $structuredData;
return view('dashboard.analytics', compact('data'));
 }
 
 
 
  public function userAnalytics()
{
    // Get the authenticated user's ID
    $userId = auth()->user()->id;

    // Fetch lead counts based on status and substatus
    $data = [
        'totalLeadCount' => DB::table('leads')->where('user_id', $userId)->count(),
        'pendingCount' => DB::table('leads')
            ->where('user_id', $userId)
            ->where('status_id', 0)
            ->count(),
        'interestedCount' => DB::table('leads')
            ->where('user_id', $userId)
            ->where('status_id', 1)
            ->count(),
        'notInterestedCount' => DB::table('leads')
            ->where('user_id', $userId)
            ->where('status_id', 2)
            ->count(),
        'callbackCount' => DB::table('leads')
            ->where('user_id', $userId)
            ->where('status_id', 3)
            ->count(),
        'wonCount' => DB::table('leads')
            ->where('user_id', $userId)
            ->where('substatus_id', 1)
            ->count(),
        'siteVisitCount' => DB::table('leads')
            ->where('user_id', $userId)
            ->where('substatus_id', 7)
            ->count(),
    ];

    // Fetch budget-wise lead data
    $data['budgetWiseData'] = DB::table('leads')
        ->join('budgets', 'leads.budget_id', '=', 'budgets.id')
        ->select(
            'budgets.name as budgetName',
            DB::raw('COUNT(*) as totalLeads')
        )
        ->where('leads.user_id', $userId)
        ->groupBy('leads.budget_id', 'budgets.name')
        ->get();
        

    // Fetch lead counts by source
    $data['leadsSourceCount'] = DB::table('leads')
        ->join('sources', 'leads.sources', '=', 'sources.id')
        ->select('sources.name as sourceName', DB::raw('COUNT(*) as count'))
        ->where('leads.user_id', $userId)
        ->groupBy('sources.name')
        ->get();

      //  dd($data['leadsSourceCount']);

    // Fetch lead counts by project
    $data['leadsProjectCount'] = DB::table('leads')
        ->join('projects', 'leads.project_id', '=', 'projects.id')
        ->select('projects.title as projectName', DB::raw('COUNT(*) as count'))
        ->where('leads.user_id', $userId)
        ->groupBy('projects.title')
        ->get();

    // Return the analytics view with the data
    return view('dashboard.useranalytics', compact('data'));
}

 
public function allleads()
{
    try {
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
        // Ensure the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to access leads.');
        }
        // Fetch leads created by the authenticated user
        $leads = Lead::where('created_by', auth()->user()->id)->get();
        // Return the view with leads data
        return view('dashboard.allleads', compact('leads','ulist'));
    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Error fetching leads: ' . $e->getMessage());

        // Optionally, redirect the user with an error message
        return redirect()->back()->with('error', 'Unable to fetch leads. Please try again later.');
    }
}

public function freshleads()
{
    try {
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
        // Ensure the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to access leads.');
        }
        // Fetch leads created by the authenticated user
        $leads = Lead::where('created_by', auth()->user()->id)
        ->where('status_id',0)
        ->get();
        // Return the view with leads data
        return view('dashboard.allleads', compact('leads','ulist'));
    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Error fetching leads: ' . $e->getMessage());

        // Optionally, redirect the user with an error message
        return redirect()->back()->with('error', 'Unable to fetch leads. Please try again later.');
    }
}

public function callback()
{
     try {
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
        // Ensure the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to access leads.');
        }
        // Fetch leads created by the authenticated user
        $leads = Lead::where('created_by', auth()->user()->id)
        ->where('status_id', 3)
        ->get();
        // Return the view with leads data
        return view('dashboard.allleads', compact('leads','ulist'));
    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Error fetching leads: ' . $e->getMessage());

        // Optionally, redirect the user with an error message
        return redirect()->back()->with('error', 'Unable to fetch leads. Please try again later.');
    }
}

public function interested()
{
       try {
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
        // Ensure the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to access leads.');
        }
        // Fetch leads created by the authenticated user
        $leads = Lead::where('created_by', auth()->user()->id)
        ->where('status_id', 1)
        ->get();
        // Return the view with leads data
        return view('dashboard.allleads', compact('leads','ulist'));
    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Error fetching leads: ' . $e->getMessage());

        // Optionally, redirect the user with an error message
        return redirect()->back()->with('error', 'Unable to fetch leads. Please try again later.');
    }
}

public function notinterested()
{
        try {
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
        // Ensure the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to access leads.');
        }
        // Fetch leads created by the authenticated user
        $leads = Lead::where('created_by', auth()->user()->id)
        ->where('status_id', 2)
        ->get();
        // Return the view with leads data
        return view('dashboard.allleads', compact('leads','ulist'));
        } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Error fetching leads: ' . $e->getMessage());

        // Optionally, redirect the user with an error message
        return redirect()->back()->with('error', 'Unable to fetch leads. Please try again later.');
    }
}

  public function sitevisit()
  {
         try {
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
        // Ensure the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to access leads.');
        }
        // Fetch leads created by the authenticated user
        $leads = Lead::where('created_by', auth()->user()->id)
        ->where('substatus_id', 7)
        ->get();
        // Return the view with leads data
        return view('dashboard.allleads', compact('leads','ulist'));
        } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Error fetching leads: ' . $e->getMessage());

        // Optionally, redirect the user with an error message
        return redirect()->back()->with('error', 'Unable to fetch leads. Please try again later.');
    }  
  }

  public function wonleads()
  {
         try {
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
        // Ensure the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to access leads.');
        }
        // Fetch leads created by the authenticated user
        $leads = Lead::where('created_by', auth()->user()->id)
        ->where('substatus_id', 1)
        ->get();
        // Return the view with leads data
        return view('dashboard.allleads', compact('leads','ulist'));
        } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Error fetching leads: ' . $e->getMessage());

        // Optionally, redirect the user with an error message
        return redirect()->back()->with('error', 'Unable to fetch leads. Please try again later.');
    }  
  }

     public function userleads($id, $status)
     {
        try {
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
        // Ensure the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to access leads.');
        }
        // Fetch leads created by the authenticated user
        $leads = Lead::where('created_by', auth()->user()->id)
        ->where('status_id', $status)
        ->where('user_id',$id)
        ->get();
        // Return the view with leads data
        return view('dashboard.allleads', compact('leads','ulist'));
        } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Error fetching leads: ' . $e->getMessage());

        // Optionally, redirect the user with an error message
        return redirect()->back()->with('error', 'Unable to fetch leads. Please try again later.');
     }  
     }
     
     
     public function substatusLeads($id, $substatus)
     {
        try {
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
        // Ensure the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to access leads.');
        }
        // Fetch leads created by the authenticated user
        $leads = Lead::where('created_by', auth()->user()->id)
        ->where('substatus_id', $substatus)
        ->where('user_id',$id)
        ->get();
        // Return the view with leads data
        return view('dashboard.allleads', compact('leads','ulist'));
        } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Error fetching leads: ' . $e->getMessage());

        // Optionally, redirect the user with an error message
        return redirect()->back()->with('error', 'Unable to fetch leads. Please try again later.');
     }    
     }
     
     public function statusleads($id)
     {
        try {
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
        // Ensure the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to access leads.');
        }
        // Fetch leads created by the authenticated user
        $leads = Lead::where('created_by', auth()->user()->id)
        ->where('status_id', $id)
        //->where('user_id',$id)
        ->get();
        //dd($leads);
        // Return the view with leads data
        return view('dashboard.allleads', compact('leads','ulist'));
        } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Error fetching leads: ' . $e->getMessage());
        // Optionally, redirect the user with an error message
        return redirect()->back()->with('error', 'Unable to fetch leads. Please try again later.');
     }  
     }
   
   public function substatusgraphleads($substatusid)
   {
    try {
        // Ensure the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to access leads.');
        }

        $user = auth()->user();

        // Fetch the user list based on user type
        if ($user->type === 'company') {
            $ulist = Employee::where('created_by', $user->id)->get();
        } else {
            $emp = Employee::where('user_id', $user->id)->first();
            if (!$emp) {
                return redirect()->back()->with('error', 'Employee details not found.');
            }
            $ulist = Employee::where('team_owner', $emp->id)->get();
        }

        // Fetch leads based on the authenticated user's ID and substatus ID
        $leads = Lead::where('created_by', $user->id)
            ->where('substatus_id', $substatusid)
            ->get();

        // Return the view with leads and user list data
        return view('dashboard.allleads', compact('leads', 'ulist'));
    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Error fetching leads: ' . $e->getMessage());

        // Redirect the user with an error message
        return redirect()->back()->with('error', 'Unable to fetch leads. Please try again later.');
    }
}


public function callbackleads($userid, $substatusid)
{
      try {
        // Ensure the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to access leads.');
        }

        $user = auth()->user();

        // Fetch the user list based on user type
        if ($user->type === 'company') {
            $ulist = Employee::where('created_by', $user->id)->get();
        } else {
            $emp = Employee::where('user_id', $user->id)->first();
            if (!$emp) {
                return redirect()->back()->with('error', 'Employee details not found.');
            }
            $ulist = Employee::where('team_owner', $emp->id)->get();
        }

        // Fetch leads based on the authenticated user's ID and substatus ID
        $leads = Lead::where('created_by', $user->id)
            ->where('substatus_id', $substatusid)
            ->where('user_id', $userid)
            ->get();

        // Return the view with leads and user list data
        return view('dashboard.allleads', compact('leads', 'ulist'));
    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Error fetching leads: ' . $e->getMessage());

        // Redirect the user with an error message
        return redirect()->back()->with('error', 'Unable to fetch leads. Please try again later.');
    }
}    
public function budgetuserwise($userid, $budgetid)
{
    try {
        // Ensure the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to access leads.');
        }

        $user = auth()->user();

        // Fetch the user list based on user type
        if ($user->type === 'company') {
            $ulist = Employee::where('created_by', $user->id)->get();
        } else {
            $emp = Employee::where('user_id', $user->id)->first();
            if (!$emp) {
                return redirect()->back()->with('error', 'Employee details not found.');
            }
            $ulist = Employee::where('team_owner', $emp->id)->get();
        }

        // Fetch leads based on the authenticated user's ID and substatus ID
        $leads = Lead::where('created_by', $user->id)
            ->where('budget_id', $budgetid)
            ->where('user_id', $userid)
            ->get();

        // Return the view with leads and user list data
        return view('dashboard.allleads', compact('leads', 'ulist'));
    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Error fetching leads: ' . $e->getMessage());

        // Redirect the user with an error message
        return redirect()->back()->with('error', 'Unable to fetch leads. Please try again later.');
    }

}

}

