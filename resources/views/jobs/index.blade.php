@extends('layouts.admin')

@section('title')Jobs @endsection

@section('content')
 
           

    <!-- Main content -->
    <section>

      <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('user.home')}}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('users.index')}}">Jobs</a>
                                    </li>
                                    <li class="breadcrumb-item active">Jobs List
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
      </div>
       
      <div>

      <div class="modal" id="editRecordModal" tabindex="-1" aria-labelledby="editRecordModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="editRecordModalLabel">Edit Status</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      <!-- Form for editing event details -->
                      <form id="editEventForm">
                          <inpput type="text" value="" id="event_id" />
                          
                          <div class="mb-2">
                              <label for="editCustomerName" class="form-label">Status</label>
                              <select class="form-control" id="editStatus" name="editStatus">
                                <option value="1">Pending</option>
                                <option value="2">Warm Lead</option>
                                <option value="3">No Sale</option>
                                <option value="4">No Contact</option>
                                <option value="5">Cancelled</option>
                                <option value="6">Sold</option>
                              </select>
                          </div>
                      </form>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                      <button type="button" class="btn btn-primary" id="saveChanges">Save Changes</button>
                  </div>
              </div>
          </div>
      </div>

        <div class="row">
          <div class="col-12">
            <div class="card data-table">
               <div class="card-header">
                  <h4 class="m-0"><i class="fas fa-users mr-2"></i>&nbsp;{{ __('Jobs') }}</h4>
                  <div>
                    <label>Status </label>
                    <select id="job_status">
                      <option value="">All</option>
                      <option value=1>Pending</option>
                      <option value=2>Warm Lead</option>
                      <option value=3>No Sale</option>
                      <option value=4>No Content</option>
                      <option value=5>Cancelled</option>
                      <option value=6>Sold</option>
                    </select>
                  </div>  
              </div>
            
              <!-- /.card-header -->
              <div class="card-body">
                <table id="usersTable" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                  <th>S.No</th>
                    <th>Customer Name</th>
                    <th>Service Titan No.</th>
                    <th>Job Total</th>
                    <th>Dispatch Time</th>
                    <th>Clock Out Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                     
                  </tr>
                  </thead>
              
                </table>
              </div>
          
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
		</div>
       </div>    
      </div>
      <!-- /.container-fluid -->
    </section>
   
  

  @push('page_script')

      @include('include.dataTableScripts')   

      <script src="{{ asset('js/pages/jobs/index.js') }}"></script>

  @endpush

	     
@endsection