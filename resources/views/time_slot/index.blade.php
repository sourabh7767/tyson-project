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
                                    <li class="breadcrumb-item"><a href="{{route('time_slot.index')}}">Time Slots</a>
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
                        <div class="col-md-12 d-flex justify-content-end">
                            <form class="mb-2" action="{{ route('time_slot.index') }}" method="get">
                                <div class="form-group">
                                    <label for="week">Select Company:</label>
                                    <select class="form-select"  style="width: 200px;" name="company_id" id="company_id" onchange="this.form.submit()">
                                      @foreach($company as $cKey => $cValue)
                                          <option @if($company_id == $cKey) selected @endif  value="{{$cKey}}">{{$cValue}}</option>
                                      @endforeach    
                                    </select>
                                </div>
                            </form>
                        </div>    
                        @foreach($dateStrings as $key => $dateString)
                        <div class="col-3">
                            <div class="card bg-info">
                            <div class="card-body text-white">
                                    <h5 class="card-title">{{$dateString}} @if($week == "current") ({{$key}}) @endif</h5>
                                    @foreach($allSlots as $allSlotKey => $allSlotValue)
                                        @php $hasValue = 0; @endphp
                                        @foreach($slotsDataArr[$key] as $sKey => $sVal)
                                            @if($allSlotValue == $sVal->slot)
                                                @php $hasValue = 1; @endphp
                                                <p class="card-text"><span>{{$sVal->slot}} ({{$sVal->remaining_slots}} slots available)</span></p>
                                            @endif
                                        @endforeach
                                        @if($hasValue == 0)
                                            <p class="card-text"><span>{{$allSlotValue}} (No slots)</span></p>
                                        @endif
                                    @endforeach
                                    
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <!-- <div class="col-3">
                            <div class="card bg-info">
                            <div class="card-body text-white">
                                    <h5 class="card-title">jkdfhdkfhd</h5>
                                    <p class="card-text"><span>5 slots available</span></p>
                                    <p class="card-text"><span>5 (No slots)</span></p>
                                </div>
                            </div>
                        </div> -->
                        
                    </div>

        <div class="row">
          <div class="col-12">
            <div class="card data-table">
               <div class="card-header">
                  <h4 class="m-0"><i class="fas fa-users mr-2"></i>&nbsp;{{ __('Time Slots') }}</h4>
                  <div>
                    <form class="d-flex justify-content-between align-items-center" action="{{ route('importSheet') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                      <label for="file" style="margin-right: 10px">Choose Excel File:</label>
                      <input type="file" name="file" id="file" class="form-control import-sheet" style="width: 258px;margin-right: 14px;" required>
                      <button type="submit" class="btn btn-primary" style="margin-left: 10px">Import</button>   
                  </form>
                </div>
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
                    
                    <th data-orderable="false">Action</th>
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