@extends('layouts.admin')

@section('title') Job @endsection
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

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
                                    <th>Dispatch Address</th>
                                      <td colspan="1">{{ $model->dispatch_address }}</td>
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
                                    <th>Arrival Address</th>
                                      <td colspan="1">{{ $model->arrival_address }}</td>
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
                                     <tr>
                                    <th>Checkout Address</th>
                                      <td colspan="1">{{ $model->checkout_address }}</td>
                                    </tr>
                                    <tr>
                                      <th colspan="4" style="text-align: center;">
                                        Old Data
                                      </th>
                                    </tr>
                                    <tr>
                                      <th>
                                        Total Amount
                                      </th>
                                      @php
                                          $oldDataJson = json_decode(!empty($model->editJobs[0]) ? $model->editJobs[0]->old_data : $model, true);
                                      @endphp
                                      <td>
                                        {{$oldDataJson['total_amount']}}
                                      </td>
                                      <th>
                                        Comission
                                      </th>
                                      <td>
                                        {{$oldDataJson['comission']}}
                                      </td>
                                    </tr>
                                    <tr>
                                      <th>
                                        Comission Amount
                                      </th>
                                      <td>
                                        {{$oldDataJson['comission_amount']}}
                                      </td>
                                    </tr>
                                    <tr>
                                      <th colspan="4" style="text-align: center;">
                                        New Data
                                      </th>
                                    </tr>
                                    <tr>
                                      <th>
                                        Total Amount
                                      </th>
                                      @php
                                          $newDataJson = json_decode(!empty($model->editJobs[0]) ? $model->editJobs[0]->new_data : $model, true);
                                      @endphp
                                      <td>
                                        {{$newDataJson['total_amount']}}
                                      </td>
                                      <th>
                                        Comission
                                      </th>
                                      <td>
                                        {{$newDataJson['comission_per']}}
                                      </td>
                                    </tr>
                                    <tr>
                                      <th>
                                        Comission Amount
                                      </th>
                                      <td>
                                        {{$newDataJson['comission_amount']}}
                                      </td>
                                    </tr>
                                    <tr>
                                      <tr>
                                        <th colspan="4" style="text-align: center;">
                                          Comment
                                        </th>
                                      </tr>
                                      <tr>
                                        <td colspan="4" style="text-align: center;">
                                          {{!empty($model->editJobs[0]) ? $model->editJobs[0]->comment : "N/A"}}
                                        </td>
                                      </tr>

                          

                                    
                               </tbody>
                           </table>
                           <br>
                           <div class="row"> 
                            <div class="col-md-6">
                            <a id="tool-btn-manage"  class="btn btn-primary text-right" href="{{route('jobs.index')}}" title="Back">Back</a>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                              Edit
                            </button>
                            </div>
                            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Edit job</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <form action="" method="post" id="comissionFrom">
                                      @csrf
                                      <input type="hidden" name="job_id" value="{{$model->id}}">
                                      <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
                                      <div class="form-group">
                                        <label for="total-amount" class="col-form-label">Total Amount:</label>
                                        <input type="text" class="form-control" name="total_amount" id="total-amount" value="{{!empty($model->jobForm[0]) ? $model->jobForm[0]->total_amount : "N/A"}}">
                                      </div>
                                      <strong class="total_amountError strong" style="color: red;"></strong>
                                      {{-- <input type="text" name="commision_amount" value="" id=""> --}}
                                      <div class="form-group">
                                        <label for="comission-perecentage" class="col-form-label">Comission Perecentage:</label>
                                        @php
                                            $comissionArr = getCommission(2);
                                        @endphp
                                        <select name="comission_per" class="form-control" id="commission-percentage">
                                          @foreach ($comissionArr as $item)
                                          <option value="{{$item}}">{{$item}} %</option>
                                          @endforeach
                                        </select>
                                      </div>
                                      <div class="form-group">
                                        <label for="comission-amount" class="col-form-label">Comission Amount:</label>
                                        <input type="text" class="form-control" name="comission_amount" id="comission_amount" value="">
                                      </div>
                                      <strong class="comission_perError strong" style="color: red;"></strong>
                                      <div class="form-group">
                                        <label for="comment" class="col-form-label">Comment:</label>
                                        <input class="form-control" type="text" name="comment" id="">
                                      </div>
                                      <strong class="commentError strong" style="color: red;"></strong>
                                  </form>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="updateJobs">Update</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                </div>


              
              </div>
          
              <!-- /.card-body -->

            </div>



            <!-- /.card -->
        </div>
       </div>   
 
</section>

@push('page_script')

<script>
        // $('#comissionFrom').submit(function(event) {
          $(document).on("click","#updateJobs",function(){
            // Prevent default form submission
            event.preventDefault();
            $(".strong").text("");

            // Serialize form data
            var formData = $("#comissionFrom").serialize();

            // Send AJAX request
            $.ajax({
                url: site_url + '/jobs/update', // Replace with your Laravel route
                type: 'POST',
                data: formData,
                success: function(response) {
                  window.location.reload()
                    // Handle success response
                    // console.log(response);
                    // You can update UI or perform any action here
                },
                error: function(response) {
                    // Handle error response
                    let errors = response.responseJSON.errors;
                Object.keys(errors).forEach(function (key,value) {
                 console.log(key);
                   // $("#" + key + "Input").addClass("is-invalid");
                    $("." + key + "Error").text(errors[key][0]);
                });
                }
            });
        });

        
</script>
<script>
  $(document).ready(function() {
    $('#commission-percentage').on('change', function(e) {
        var totalAmount = parseFloat($('#total-amount').val());
        var commissionPercentage = parseFloat($(this).val());
        if (!isNaN(totalAmount) && !isNaN(commissionPercentage)) {
            var commissionAmount = (totalAmount * commissionPercentage) / 100;
            $('#comission_amount').val(commissionAmount.toFixed(2));
        }
    });
  })
</script>
  
@endpush

@endsection
