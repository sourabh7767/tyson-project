@extends('layouts.admin')

@section('title') Add Booking @endsection

@section('content')

@push('page_style')

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">

@endpush

    <!-- Basic multiple Column Form section start -->
                <section id="multiple-column-form">
                    <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('user.home')}}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('user.home')}}">Booking</a>
                                    </li>
                                    <li class="breadcrumb-item active">Add Booking
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
       
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Add Booking</h4>
                                </div>
                                <div class="card-body">
                                  <form method="POST" action="{{ route('booking.store') }}">
                                    <input type="hidden" name="company_id" value={{$id}} />
                                    @csrf
                                        <div class="row">
                                            <div class="col-md-6 col-12 first_div">
                                                <div class="mb-1">
                                                    <label class="form-label" for="day">Select Day <span class="text-danger asteric-sign">&#42;</span></label>
                                                      <select class="form-control" id="daySelect" name="day">
                                                        <option data-id="{{$id}}" value="<?php echo date("Y-m-d");?>">Today</option>
                                                        <option data-id="{{$id}}" value="<?php echo date("Y-m-d",strtotime("+1 day"));?>">Tommorow</option>
                                                      </select>
                                                        @if ($errors->has('day'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('day') }}</strong>
                                                            </span>
                                                        @endif
                                                   
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6 col-12 slotOptions <?php if($slotsData->isEmpty()){ echo "d-none";} ?>">
                                                <div class="mb-1" id="slotOptions">
                                                    <label class="form-label" for="slot">Slots <span class="text-danger asteric-sign">&#42;</span></label>
                                                    <br>
                                                    
                                                     @foreach($slotsData as $slotKey => $slotValue)       
                                                         <!-- <input id="slot" type="radio" class="form-control {{ $errors->has('slot') ? ' is-invalid' : '' }}" name="slot" value="{{ old('slot') }}" >  -->
                                                         <input type="radio"  data-id="{{$slotValue->id}}" name="slot" value="{{$slotValue->id}}">
                                                        <label for="html">{{$slotValue->slot}}</label><br>
                                                         
                                                    @endforeach
                                                    @if ($errors->has('slot'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('slot') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6 col-12 slotnumber d-none">
                                                <div class="mb-1" id="slotnumber">
                                                    <label class="form-label" for="no_of_slots">No Of Sloats <span class="text-danger asteric-sign">&#42;</span></label>
                                                    <select class="form-control" name="no_of_slots">
                                                        @for($i = 1;$i<=5;$i++)
                                                            <option value="{{$i}}">{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                    @if ($errors->has('no_of_slots'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('no_of_slots') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6 col-12 slotcsr d-none">
                                                <div class="mb-1" id="slotcsr">
                                                    <label class="form-label" for="csr_name">CSR Name<span class="text-danger asteric-sign">&#42;</span></label>
                                                    <input id="csr_name" type="text" class="form-control {{ $errors->has('csr_name') ? ' is-invalid' : '' }}" name="csr_name" placeholder="CSR Name">
                                                    @if ($errors->has('csr_name'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('csr_name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 slotjobnumber d-none">
                                                <div class="mb-1" id="slotjobnumber">
                                                    <label class="form-label" for="job_number">Service Titan Job Number<span class="text-danger asteric-sign">&#42;</span></label>
                                                    <input id="job_number" type="text" class="form-control {{ $errors->has('job_number') ? ' is-invalid' : '' }}" name="job_number" placeholder="CSR Name">
                                                    @if ($errors->has('job_number'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('job_number') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                          
                                            <div class="col-12 btn_sub d-none">
                                                <button type="Submit" class="btn btn-primary me-1">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Basic Floating Label Form section end -->



@push('page_script')    
   <script>
     $(document).ready(function () {
        $('#daySelect').change(function () {
            var selectedDay = $(this).val();
            var selectedOption = $(this).find(':selected');
            var dataId = selectedOption.data('id')
           // alert(dataId);
            $.get('/get-slots', { day: selectedDay,comapny_id: dataId }, function (data) {
               // $('#slotOptions').html(data);
                if (data.status === 'no_data') {
                    $('#slotOptions').hide();
                    $('#slotnumber').hide();
                    $('#slotjobnumber').hide();
                    $('#slotcsr').hide();
                    $('.slotOptions').addClass('d-none');
                    $('.slotnumber').addClass('d-none');
                    $('.slotjobnumber').addClass('d-none');
                    $('.slotcsr').addClass('d-none');
                    $('.btn_sub').addClass('d-none');
                    
                    alert("No slots available")
                } else {
                    $('.slotOptions').removeClass('d-none');
                    $('.slotnumber').addClass('d-none');
                    $('.slotjobnumber').addClass('d-none');
                    $('.slotcsr').addClass('d-none');
                    $('.btn_sub').addClass('d-none');
                   // var slotData = $(data);
                   // $('.first_div').after(slotData);
                    $('#slotOptions').html(data).show();
                }
            });
        });

        $(document).on('change', 'input[name="slot"]', function () {
            console.log("her----------------------------");
            var selectedId = $(this).data('id');
            $.get('/get-slots-number', { id: selectedId }, function (data) {
               // $('#slotOptions').html(data);
                if (data.status === 'no_data') {
                   // $('#slotOptions').hide();
                    $('#slotnumber').hide();
                    $('#slotjobnumber').hide();
                    $('#slotcsr').hide();   
                    $('.btn_sub').addClass('d-none');
                    alert("No slots available")
                } else {
                    $('.slotnumber').removeClass('d-none');
                    $('.slotjobnumber').removeClass('d-none');
                    $('.slotcsr').removeClass('d-none')
                    $('.btn_sub').removeClass('d-none');

                    $('#slotnumber').show();
                    $('#slotjobnumber').show();
                    $('#slotcsr').show();   

                    $('#slotnumber').html(data).show();
                }
            });
        });
    });
    </script>
@endpush

@endsection