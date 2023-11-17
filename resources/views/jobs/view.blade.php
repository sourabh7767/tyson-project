@extends('layouts.admin')

@section('title') Job @endsection

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
                                    <li class="breadcrumb-item active">View
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
              </div>


        <div class="row">
          <div class="col-12">
            <div class="card">
  
              <!-- /.card-header -->
              <div class="card-body">

                     <table id="w0" class="table table-striped table-bordered detail-view">
                      <tbody>
                        <tr>
                          <th>Job ID</th>
                          <td colspan="1">{{$model->id}}</td>
                          <th>Status</th>
                          <td colspan="1">
                            
                              @if($model->jobForm->count())
                                @if($model->jobForm[0]->status == 1)
                                  Pending
                                @elseif($model->jobForm[0]->status == 2)
                                  Warm leads
                                @elseif($model->jobForm[0]->status == 3)
                                  No Sale
                                @elseif($model->jobForm[0]->status == 4)
                                  No Contact
                                @elseif($model->jobForm[0]->status == 5)
                                  Cancelled
                                @elseif($model->jobForm[0]->status == 6)
                                  Sold
                                @else
                                @endif 
                              @endif
                          </td>
                        </tr>
                                    <tr>
                                    <th>Customer Name</th>
                                    <td colspan="1">{{$model->customer_name}}</td>
                                      <th>Service Titan Number</th>
                                      <td colspan="1">{{ $model->service_titan_number }}</td>
                                      
                                    </tr>

                                    <tr>
                                      <th></th>
                                      <td ></td>
                                      
                                    </tr>
                                   
                                    
                                   <tr>
                                    <th>Dispatch Time</th>
                                      <td colspan="1">{{ $model->dispatch_time }}</td>
                                      <th>Total Hours</th>
                                      <td colspan="1">{{$model->total_hours}}</td>
                                      
                                     
                                    </tr>
                                    <tr>
                                    <th>Arrival Time</th>
                                      <td colspan="1">{{ $model->arrival_time }}</td>
                                    
                                      <th>Total Amount</th>
                                      <td colspan="1">
                                        
                                          @if($model->jobForm->count())
                                            {{$model->jobForm[0]->total_amount}}
                                          @endif
                                      </td>
                                      
                                     
                                    </tr>
                                    <tr>
                                    <th>Checkout Time</th>
                                      <td colspan="1">{{ $model->checkout_time }}</td>
                                      <th>Commision</th>
                                      <td colspan="1">
                                          @if($model->jobForm->count())
                                            {{$model->jobForm[0]->comission}} %
                                          @endif
                                      </td>
                                      
                                      
                                     
                                    </tr>
                                     

                          

                                    
                               </tbody>
                           </table>
                           <br>
                           <div class="row"> 
                            <div class="col-md-6">
                            <a id="tool-btn-manage"  class="btn btn-primary text-right" href="{{route('jobs.index')}}" title="Back">Back</a>
                            </div>
                </div>


              
              </div>
          
              <!-- /.card-body -->

            </div>



            <!-- /.card -->
        </div>
       </div>   




      
 
</section>



@endsection
