@extends('layouts.admin')

@section('title')Time Slots @endsection

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
                                    <li class="breadcrumb-item"><a href="{{route('users.index')}}">Time Slots</a>
                                    </li>
                                    <li class="breadcrumb-item active">Time Slot List
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
      </div>
       
      <div>

        <div class="row">
          <div class="col-12">
            <div class="card data-table">
               <div class="card-header">
                  <h4 class="m-0"><i class="fas fa-users mr-2"></i>&nbsp;{{ __('Time Slots') }}</h4>
                <a href="{{ route('time_slot.create') }}" class="dt-button create-new btn btn-primary"><i class="fas fa-plus"></i>&nbsp;&nbsp;Add Time Slot</a>
              </div>
            
              <!-- /.card-header -->
              <div class="card-body">
                <table id="usersTable" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Company Name</th>
                    <th>Slot</th>
                    <th>Date</th>
                    <th>No Of Slots</th>
                    <th>Remaining Slots</th>
                    
                    <!-- <th data-orderable="false">Action</th> -->
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

      <script src="{{ asset('js/pages/time_slots/index.js') }}"></script>

  @endpush

	     
@endsection