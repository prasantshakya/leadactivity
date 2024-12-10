@extends('layouts.admin') <style>
  .title-heading,
  .btn-close {
    color: #fff !important;
  }
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> @section('content') <div class="row">
  <div class="col-12 mb-3">
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#general" role="tab" aria-controls="pills-home" aria-selected="true">General</a>
      </li>
     <!-- <li class="nav-item">
        <a class="nav-link" id="pills-files-tab" data-bs-toggle="pill" href="#files" role="tab" aria-controls="files" aria-selected="false">Files</a>
      </li> -->
      <li class="nav-item">
        <a class="nav-link" id="pills-discussion-tab" data-bs-toggle="pill" href="#leadactivity" role="tab" aria-controls="discussion" aria-selected="false">Lead Activities</a>
      </li>
   <!--   <li class="nav-item">
        <a class="nav-link" id="pills-notes-tab" data-bs-toggle="pill" href="#notes" role="tab" aria-controls="notes" aria-selected="false">Notes</a>
      </li> -->
      <li class="nav-item">
        <a class="nav-link" id="pills-calls-tab" data-bs-toggle="pill" href="#calls" role="tab" aria-controls="calls" aria-selected="false">Calls</a>
      </li>
    </ul>
  </div>
  <div class="col-12">
    <div class="tab-content tab-bordered">
      <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="pills-general-tab">
        <div class="row">
          <div class="col-xxl-7">
            <div class="row">
                
                @if($leaddata->followup_type=='1') 
              <!-- Interested Button -->
                <div class="col-sm-3 col-12">
                <div class="card report_card">
                  <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#wonModal"> Won </button>
                </div>
              </div> 
              <!-- Not Interested Button -->
              <div class="col-sm-3 col-12">
                <div class="card report_card">
                  <button class="btn btn-info w-100" data-bs-toggle="modal" data-bs-target="#lostModal"> Lost </button>
                </div>
              </div>
              <!-- Call Back Button -->
              <div class="col-sm-3 col-12">
                <div class="card report_card">
                  <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#rescheduleModal"> Reschedule </button>
                </div>
              </div>
              
               <!-- Call Back Button -->
              <div class="col-sm-3 col-12">
                <div class="card report_card">
                  <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#createModal"> Create </button>
                </div>
              </div>
           
              @else
              <div class="col-sm-4 col-12">
                <div class="card report_card">
                  <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#interestedModal"> Interested </button>
                </div>
              </div> 
              <!-- Not Interested Button -->
              <div class="col-sm-4 col-12">
                <div class="card report_card">
                  <button class="btn btn-info w-100" data-bs-toggle="modal" data-bs-target="#notInterestedModal"> Not Interested </button>
                </div>
              </div>
              <!-- Call Back Button -->
              <div class="col-sm-4 col-12">
                <div class="card report_card">
                  <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#callbackModal"> Call Back </button>
                </div>
              </div>
              @endif
              
            </div>
          </div>
          <!-- Modal for Interested Button -->
          <!-- Modal for Interested Button -->
          <div class="modal fade" id="interestedModal" tabindex="-1" aria-labelledby="interestedModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                  <h5 class="modal-title title-heading" id="interestedModalLabel">Interested Form</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="{{ route('leads.status.interested', ['id' => $leaddata->id]) }}" method="POST"> @csrf <div class="row">
                      
                       <div class="col-md-6 mb-3">
                        <label for="propertyType" class="form-label">Property Type</label>
                         <select name="property_type" id="property_type" class="form-control">
                        <option value="">Select Property Type</option>
                        <option value="residential" {{ old('property_type', $leaddata->property_type) == 'residential' ? 'selected' : '' }}>Residential</option>
                        <option value="commercial" {{ old('property_type', $leaddata->property_type) == 'commercial' ? 'selected' : '' }}>Commercial</option>
                        <option value="industrial" {{ old('property_type', $leaddata->property_type) == 'industrial' ? 'selected' : '' }}>Industrial</option>
                    </select>
                      </div>
                      
                        <div class="col-md-6 mb-3">
                        <label for="propertyType" class="form-label">Property Sub Type</label>
                        <select name="property_sub_type" id="property_sub_type" class="form-control">
                        <option value="">Select Property Sub Type</option>
                    </select>
                      </div>
                      
                      
                      
                      
                      <div class="col-md-6 mb-3">
                        <label for="requirementType" class="form-label">Requirement Type</label>
                        <select name="requirements" class="form-control">
                          <option value="1BHK">1BHK</option>
                          <option value="2BHK">1BHK</option>
                          <option value="3BHK">3BHK</option>
                        </select>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label for="budget" class="form-label">Budget</label>
                        <select name="budget_id" class="form-control"> @foreach($budget as $data) <option value="{{ $data->id }}">{{ $data->name }}</option> @endforeach </select>
                      </div>
                     
                      <div class="col-md-6 mb-3">
                        <label for="propertyStage" class="form-label">Property Stage</label>
                        <select name="property_stage" id="property_stage" class="form-control">
                          <option value="">Select Property Stage</option>
                          <option value="1">Under Contruction</option>
                          <option value="2">Ready to move</option>
                          <option value="3">Pre Launch</option>
                        </select>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label for="followupType" class="form-label">Next Follow-Up Type</label>
                        <select name="followup_type" id="followupType" class="form-control">
                          <option value="5">Followup</option>
                          <option value="6">Meeting</option>
                          <option value="7">Site Visit</option>
                        </select>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label for="followupOn" class="form-label">Next Follow-Up On</label>
                        <input type="datetime-local" name="followup_on" class="form-control" id="followupOn">
                      </div>
                      <div class="col-md-6 mb-3">
                        <label for="leadSource" class="form-label">Lead Source</label>
                      <select name="sources" class="form-control">
                      @foreach($source as $data)
                      <option value="{{ $data->id }}">{{ $data->name }}</option>
                      @endforeach
                      </select>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label for="alternativeNo" class="form-label">Alternative No</label>
                        <input type="tel" class="form-control" name="alternative_no" id="alternative_no" placeholder="Enter alternative number">
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal for Call Back Button -->
          <div class="modal fade" id="callbackModal" tabindex="-1" aria-labelledby="callbackModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                  <h5 class="modal-title title-heading" id="callbackModalLabel">Schedule a Call Back</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form id="callbackForm" action="{{ route('leads.status.callback', ['id' => $leaddata->id]) }}" method="POST"> 
                  @csrf
                    <!-- Include CSRF token for protection -->
                    <!-- Callback Reason -->
                    <div class="mb-3">
                      <label for="callbackReason" class="form-label">Call Back Reason</label>
                      <select name="callbackReason" class="form-control" required>
                        @foreach($callbackStatus as $data)
                          <option value="{{$data->id}}">{{$data->name}}</option>
                          @endforeach
                      </select>
                    </div>
                    <!-- Next Follow-Up Date and Time -->
                    <div class="mb-3">
                      <label for="followupDateTime" class="form-label">Next Follow-Up (Date & Time)</label>
                      <input type="datetime-local" name="followupDateTime" class="form-control" id="followupDateTime" required>
                    </div>
                    <!-- Notes -->
                    <div class="mb-3">
                      <label for="notes" class="form-label">Notes</label>
                      <textarea class="form-control" name="notes" id="notes" rows="3" placeholder="Add any additional notes"></textarea>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" form="callbackForm" class="btn btn-primary">Save</button>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal for Not Interested Button -->
          <!-- Modal for Not Interested Button -->
          <div class="modal fade" id="notInterestedModal" tabindex="-1" aria-labelledby="notInterestedModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                  <h5 class="modal-title title-heading" id="notInterestedModalLabel">Not Interested Form</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form method="POST" action="{{ route('leads.status.notinterested', $leaddata->id) }}"> 
                  @csrf 
                  @method('POST')
                    <!-- This ensures the correct HTTP method -->
                    <div class="row">
                      <div class="col-md-12 mb-3">
                        <label for="reason" class="form-label">Reason for Not Interested <span class="text-danger">*</span>
                        </label>
                        <select name="reason" class="form-control">
                         @foreach($notInterestedStatus as $data)
                          <option value="{{$data->id}}">{{$data->name}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-12 mb-3">
                        <label for="feedback" class="form-label">Additional Feedback</label>
                        <textarea class="form-control" id="feedback" name="feedback" rows="3" placeholder="Any additional feedback (optional)"></textarea>
                      </div>
                    </div>
                    <div class="d-flex justify-content-end">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!--- Modal for Lost Reason ---->
          <div class="modal fade" id="lostModal" tabindex="-1" aria-labelledby="notInterestedModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                  <h5 class="modal-title title-heading" id="notInterestedModalLabel">Lost Details</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form method="POST" action="{{ route('leads.status.lostLead', $leaddata->id) }}">
                       @csrf @method('POST')
                    <!-- This ensures the correct HTTP method -->
                    <div class="row">
                      <div class="col-md-12 mb-3">
                        <label for="reason" class="form-label">Reason for Lost<span class="text-danger">*</span>
                        </label>
                        <select name="reason" class="form-control">
                          <option value="Better Deal/Already Purchased">Better Deal/Already Purchased</option>
                          <option value="Loan Issue">Loan Issue</option>
                          <option value="Financial Concern">Finacial Concern</option>
                          <option value="Plan Postponed">Plan Postponed</option>
                          <option value="Other">Other</option>
                          <option value="Invalid Number">Invalid Number</option>
                          <option value="Other">Other</option>
                        </select>
                      </div>
                      <div class="col-md-12 mb-3">
                        <label for="feedback" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Write Notes here (optional)"></textarea>
                      </div>
                    </div>
                    <div class="d-flex justify-content-end">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
  <!--- end of lost reason ---->
 
         <!--- Modal for Reschedule Reason ---->
          <div class="modal fade" id="rescheduleModal" tabindex="-1" aria-labelledby="notInterestedModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                  <h5 class="modal-title title-heading" id="notInterestedModalLabel">Reschedule Task</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  
                </div>
                <div class="modal-body">
                  <form method="POST" action="{{ route('leads.status.taskRescheduled', $leaddata->id) }}">
                       @csrf 
                       @method('POST')
                    <!-- This ensures the correct HTTP method -->
                    <div class="row">
                      <div class="col-md-12 mb-3">
                      <label for="followupDateTime" class="form-label">Next Follow-Up (Date & Time)</label>
                      <input type="datetime-local" name="followupDateTime" class="form-control" id="followupDateTime" required>
                      </div>
                      <div class="col-md-12 mb-3">
                        <label for="feedback" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Write Notes here (optional)"></textarea>
                      </div>
                    </div>
                    <div class="d-flex justify-content-end">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
  <!--- end of Reschedule reason ---->
          
          
          <!--- Modal for Create Modal Reason ---->
             <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="notInterestedModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                  <h5 class="modal-title title-heading" id="notInterestedModalLabel">Create New Task</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form method="POST" action="{{ route('leads.status.taskCreate', $leaddata->id) }}">
                       @csrf
                       @method('POST')
                    <!-- This ensures the correct HTTP method -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                        <label for="reason" class="form-label">Next Follow Up Type<span class="text-danger">*</span>
                        </label>
                        <select name="reason" class="form-control">
                          <option value="5">Followup</option>
                          <option value="6">Meeting</option>
                          <option value="7">Site Visit</option>
                        </select>
                      </div>
                      
                      <div class="col-md-12 mb-3">
                      <label for="followupDateTime" class="form-label">Next Follow-Up (Date & Time)</label>
                      <input type="datetime-local" name="followupDateTime" class="form-control" id="followupDateTime" required>
                      </div>
                      <div class="col-md-12 mb-3">
                        <label for="feedback" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Write Notes here (optional)"></textarea>
                      </div>
                    </div>
                    <div class="d-flex justify-content-end">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          
          
          <!--- end of Create Modal reason -->
          
          
          
           <!--- Modal for Lost Reason ---->
          <div class="modal fade" id="wonModal" tabindex="-1" aria-labelledby="notInterestedModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                  <h5 class="modal-title title-heading" id="notInterestedModalLabel">Won Details</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form method="POST" action="{{ route('leads.status.wonLead', $leaddata->id) }}">
                       @csrf @method('POST')
                    <!-- This ensures the correct HTTP method -->
                    <div class="row">
                      <div class="col-md-12 mb-3">
                        <label for="reason" class="form-label">Won Details<span class="text-danger">*</span>
                        </label>
                        <select name="reason" class="form-control">
                          <option value="Cheque collected">Cheque collected</option>
                          <option value="Application form collected">Application form collected</option>
                          <option value="All Done">All Done</option>
                        </select>
                      </div>
                      <div class="col-md-12 mb-3">
                        <label for="feedback" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Write Notes here (optional)"></textarea>
                      </div>
                    </div>
                    <div class="d-flex justify-content-end">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
  <!--- end of lost reason ---->
    
          <div class="col-xxl-5">
            <div class="card report_card total_amount_card"></div>
          </div>
        </div>
        <div class="row">
          <!-- Left Column: Personal and Property Information -->
          <div class="col-sm-6 col-12">
            <div class="card shadow-sm border-0">
              <div class="card-header bg-primary text-white">
                <h5 class="mb-0 title-heading">Lead Overview</h5>
              </div>
              <div class="card-body">
                <!-- Personal Information -->
                <h6 class="mb-3 border-bottom pb-2">Personal Information</h6>
                <ul class="list-group mb-4">
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Name:</strong>
                    <span>{{ $leaddata->name ?? 'N/A' }}</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Email:</strong>
                    <span>{{ $leaddata->email ?? 'N/A' }}</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Phone No:</strong>
                    <span>{{ $leaddata->phone_no ?? 'N/A' }}</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Alternative No:</strong>
                    <span>{{ $leaddata->alternative_no ?? 'N/A' }}</span>
                  </li>
                </ul>
                <!-- Property Details -->
                <h6 class="mb-3 border-bottom pb-2">Property Details</h6>
                <ul class="list-group">
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Unit No:</strong>
                    <span>{{ $leaddata->unit_no ?? 'N/A' }}</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Project ID:</strong>
                    <span>{{ $leaddata->project->name ?? 'N/A' }}</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Property Type:</strong>
                    <span>{{ $leaddata->property_type ?? 'N/A' }}</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Property Sub Type:</strong>
                    <span>{{ $leaddata->property_subtype ?? 'N/A' }}</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Requirements:</strong>
                    <span>{{ $leaddata->requirements ?? 'N/A' }}</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Budget ID:</strong>
                    <span>{{ $leaddata->budget->name ?? 'N/A' }}</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <!-- Right Column: Lead and Date Information -->
          <div class="col-sm-6 col-12">
            <div class="card shadow-sm border-0">
              <div class="card-header bg-primary text-white">
                <h5 class="mb-0 title-heading">Lead Details</h5>
              </div>
              <div class="card-body">
                <!-- Lead Details -->
                <h6 class="mb-3 border-bottom pb-2">Lead Details</h6>
                <ul class="list-group mb-4">
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Lead Type:</strong>
                    <span>{{ $leaddata->lead_type ?? 'N/A' }}</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Sources:</strong>
                    <span>{{ $leaddata->source->name ?? 'N/A' }}</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Created By:</strong>
                    <span>{{ $leaddata->created_by ?? 'N/A' }}</span>
                  </li>
                </ul>
                <!-- Date Information -->
                <h6 class="mb-3 border-bottom pb-2">Date Information</h6>
                <ul class="list-group">
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Date:</strong>
                    <span>{{ $leaddata->date ?? 'N/A' }}</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Created At:</strong>
                    <span>{{ $leaddata->created_at ?? 'N/A' }}</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Updated At:</strong>
                    <span>{{ $leaddata->updated_at ?? 'N/A' }}</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 col-12">
            <div class="card">
              <div class="card-header">
                <h5>Notes</h5>
              </div>
              <div class="card-body">
                <div class="height-450">
                  <form action="#" method="POST">
                    <!-- CSRF token for security -->
                    <input type="hidden" name="_token" value="2gUWCXP2pgKdIQrSrsdqaez1i9Pjma7txW2NYb9G" autocomplete="off">
                    <!-- Textarea for notes -->
                    <div class="form-group">
                      <textarea class="summernote form-control" id="pc_demo1" name="notes">mn op</textarea>
                    </div>
                    <!-- Submit button -->
                    <div class="text-end mt-3">
                      <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-12">
            <div class="card">
              <div class="card-header">
                <h5>Activity</h5>
              </div>
              <div class="card-body height-450">
                <div class="row" style="height:490px !important; overflow-y: scroll;">
                  <ul class="event-cards list-group list-group-flush mt-3 w-100"> <?php if (!empty($leadhistory)): ?> <?php foreach ($leadhistory as $followup): ?> <li class="list-group-item card mb-3">
                      <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                          <div class="d-flex align-items-center">
                            <div class="theme-avtar bg-primary">
                              <i class="fas fa-file-alt"></i>
                              <!-- Icon representing a lead update -->
                            </div>
                            <div class="ms-3">
                              <h6 class="m-0"> Lead Status: <?php 
                                                        if ($followup['status_id'] == 1) {
                                                            echo "Interested";
                                                        } elseif ($followup['status_id'] == 2) {
                                                            echo "Not Interested";
                                                        } elseif ($followup['status_id'] == 3) {
                                                            echo "Call Back";
                                                        } else {
                                                            echo "Unknown Status";
                                                        }
                                                    ?> </h6>
                              <p class="m-0">
                                <strong>Notes:</strong> <?= $followup['notes'] ? htmlspecialchars($followup['notes']) : 'N/A' ?>
                              </p>
                              <small class="text-muted">Created At: <?= htmlspecialchars($followup['created_at']) ?> </small>
                            </div>
                          </div>
                        </div>
                        <div class="col-auto">
                          <!-- Additional actions or icons can go here if needed -->
                        </div>
                      </div>
                    </li> <?php endforeach; ?> <?php else: ?> <p class="text-center w-100">No follow-up data available.</p> <?php endif; ?> </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="sources" role="tabpanel" aria-labelledby="pills-sources-tab">
        <div class="row pt-2">
          <div class="col-12">
            <div class="card table-card">
              <div class="card-header">
                <h5>Sources <a href="#" class="btn btn-sm btn-primary float-end " data-bs-toggle="tooltip" data-bs-placement="top" title="" data-url="https://demo.workdo.io/leadgo-saas/leads/4/sources" data-ajax-popup="true" data-title="Edit Sources" data-bs-original-title="Edit Sources">
                    <i class="ti ti-plus text-white"></i>
                  </a>
                </h5>
              </div>
              <div class="card-body pt-0 table-border-style bg-none height-450">
                <div class="">
                  <table class="table align-items-center mb-0">
                    <tbody class="list">
                      <tr>
                        <td>
                          <span class="text-dark">Website</span>
                        </td>
                        <td class="text-end">
                          <div class="action-btn bg-danger ms-2">
                            <form method="POST" action="https://demo.workdo.io/leadgo-saas/leads/4/sources/1" accept-charset="UTF-8" id="delete-form-4">
                              <input name="_method" type="hidden" value="DELETE">
                              <input name="_token" type="hidden" value="2gUWCXP2pgKdIQrSrsdqaez1i9Pjma7txW2NYb9G">
                              <a href="#!" class="mx-3 btn btn-sm d-inline-flex align-items-center show_confirm" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete Sources">
                                <span class="text-white">
                                  <i class="ti ti-trash"></i>
                                </span>
                              </a>
                            </form>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <span class="text-dark">Organic</span>
                        </td>
                        <td class="text-end">
                          <div class="action-btn bg-danger ms-2">
                            <form method="POST" action="https://demo.workdo.io/leadgo-saas/leads/4/sources/2" accept-charset="UTF-8" id="delete-form-4">
                              <input name="_method" type="hidden" value="DELETE">
                              <input name="_token" type="hidden" value="2gUWCXP2pgKdIQrSrsdqaez1i9Pjma7txW2NYb9G">
                              <a href="#!" class="mx-3 btn btn-sm d-inline-flex align-items-center show_confirm" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete Sources">
                                <span class="text-white">
                                  <i class="ti ti-trash"></i>
                                </span>
                              </a>
                            </form>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <span class="text-dark">Email Campaign</span>
                        </td>
                        <td class="text-end">
                          <div class="action-btn bg-danger ms-2">
                            <form method="POST" action="https://demo.workdo.io/leadgo-saas/leads/4/sources/5" accept-charset="UTF-8" id="delete-form-4">
                              <input name="_method" type="hidden" value="DELETE">
                              <input name="_token" type="hidden" value="2gUWCXP2pgKdIQrSrsdqaez1i9Pjma7txW2NYb9G">
                              <a href="#!" class="mx-3 btn btn-sm d-inline-flex align-items-center show_confirm" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete Sources">
                                <span class="text-white">
                                  <i class="ti ti-trash"></i>
                                </span>
                              </a>
                            </form>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="pills-files-tab">
        <div class="row pt-2">
          <div class="col-12">
            <div class="card table-card">
              <div class="card-header">
                <h5>Files</h5>
              </div>
              <div class="card-body">
                <div class=" height-450">
                  <div class="card-body bg-none">
                    <div class="col-md-12 dropzone browse-file dz-clickable" id="dropzonewidget2">
                      <div class="dz-default dz-message">
                        <button class="dz-button" type="button">Drop files here to upload</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="leadactivity" role="tabpanel" aria-labelledby="pills-discussion-tab">
        <div class="row pt-2">
          <div class="col-12">
            <div class="card table-card">
              <div class="card-header">
                <h5>Activity List </h5>
              </div>
              <div class="card-body table-border-style bg-none height-450"> <?php if (!empty($leadhistory)): ?> <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Created At</th>
                      </tr>
                    </thead>
                    <tbody> <?php foreach ($leadhistory as $followup): ?> <tr>
                        <td> <?php if ($followup['status_id'] == 1) {
                                                        echo "Interested";
                                                    } elseif ($followup['status_id'] == 2) {
                                                        echo "Not Interested";
                                                    } elseif ($followup['status_id'] == 3) {
                                                        echo "Call Back";
                                                    } else {
                                                        echo "Unknown Status";
                                                    }
                                                ?> </td>
                        <td> <?= $followup['notes'] ? htmlspecialchars($followup['notes']) : 'N/A' ?> </td>
                        <td> <?= htmlspecialchars($followup['created_at']) ?> </td>
                      </tr> <?php endforeach; ?> </tbody>
                  </table>
                </div> <?php else: ?> <p>No follow-up data available.</p> <?php endif; ?> </div>
            </div>
          </div>
        </div>
      </div>
   </div>
  </div>
</div> 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    $(document).ready(function() {
        $('#property_type').on('change', function() {
            var propertyType = $(this).val();
            var subTypeOptions = {
                'residential': [
                    { value: 'apartment', text: 'Apartment' },
                    { value: 'flats', text: 'Flats' },
                    { value: 'villa', text: 'Villa' }
                ],
                'commercial': [
                    { value: 'shop', text: 'Shop' },
                    { value: 'office', text: 'Office' },
                    { value: 'food_court', text: 'Food Court' }
                ],
                'industrial': [] // Add subtypes if needed for industrial
            };

            // Clear current sub type options
            $('#property_sub_type').empty();
            $('#property_sub_type').append('<option value="">Select Property Sub Type</option>');

            // Populate sub type options based on the selected property type
            if (subTypeOptions[propertyType]) {
                subTypeOptions[propertyType].forEach(function(subType) {
                    $('#property_sub_type').append(
                        $('<option></option>').val(subType.value).text(subType.text)
                    );
                });
            }
        });
    });
</script>


@endsection