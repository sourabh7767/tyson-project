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
                                    <li class="breadcrumb-item"><a href="{{route('users.index')}}">Booking</a>
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
                                  <form method="POST" action="{{ route('users.store') }}">
                                    @csrf
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="day">Select Day <span class="text-danger asteric-sign">&#42;</span></label>
                                                      <select class="form-control" name="day">
                                                        <option value="<?php echo date("Y-m-d");?>">Today</option>
                                                        <option value="<?php echo date("Y-m-d",strtotime("+1 day"));?>">Tommorow</option>
                                                      </select>
                                                        @if ($errors->has('day'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('day') }}</strong>
                                                            </span>
                                                        @endif
                                                   
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="slot">Slots <span class="text-danger asteric-sign">&#42;</span></label>
                                                    <br>
                                                    
                                                     @foreach($slotsData as $slotKey => $slotValue)       
                                                         <!-- <input id="slot" type="radio" class="form-control {{ $errors->has('slot') ? ' is-invalid' : '' }}" name="slot" value="{{ old('slot') }}" >  -->
                                                         <input type="radio" id="html" name="fav_language" value="HTML">
                                                        <label for="html">{{$slotValue->slot}}</label><br>
                                                         
                                                    @endforeach
                                                    @if ($errors->has('slot'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('slot') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="no_of_slots">No Of Sloats <span class="text-danger asteric-sign">&#42;</span></label>
                                                    <select class="form-control" name="no_of_slots">
                                                        @for($i = 0;$i<=5;$i++)
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
                                            
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="csr_name">CSR Name<span class="text-danger asteric-sign">&#42;</span></label>
                                                    <input id="csr_name" type="text" class="form-control {{ $errors->has('csr_name') ? ' is-invalid' : '' }}" name="csr_name" placeholder="CSR Name">
                                                    @if ($errors->has('csr_name'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('csr_name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="job_number">Service Titan Job Number<span class="text-danger asteric-sign">&#42;</span></label>
                                                    <input id="job_number" type="text" class="form-control {{ $errors->has('job_number') ? ' is-invalid' : '' }}" name="job_number" placeholder="CSR Name">
                                                    @if ($errors->has('job_number'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('job_number') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-12">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    
   <script>

        var isoCode = ($("#iso_code").val()) ? ($("#iso_code").val()) : ('US');
        //  phone 1 input
        var phoneInput = document.querySelector("#phone_number");
        var phoneInstance = window.intlTelInput(phoneInput, {
            autoPlaceholder: "off",
            separateDialCode: true,
            initialCountry: isoCode
            // utilsScript: '{{URL::asset("frontend/build/js/utils.js")}}',
        });


        $("#phone_code").val(phoneInstance.getSelectedCountryData().dialCode);
        $("#iso_code").val(phoneInstance.getSelectedCountryData().iso2);
        phoneInput.addEventListener("countrychange",function() {
            $("#phone_code").val(phoneInstance.getSelectedCountryData().dialCode);
            $("#iso_code").val(phoneInstance.getSelectedCountryData().iso2);
        });


        
    </script>
@endpush

@endsection