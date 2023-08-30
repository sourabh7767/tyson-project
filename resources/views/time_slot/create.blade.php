@extends('layouts.admin')

@section('title') Create Time Slot @endsection

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
                                    <li class="breadcrumb-item"><a href="{{route('time_slot.index')}}">Time Slot</a>
                                    </li>
                                    <li class="breadcrumb-item active">Create Time Slot
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
                                    <h4 class="card-title">Create Time Slot</h4>
                                </div>
                                <div class="card-body">
                                  <form method="POST" action="{{ route('time_slot.store') }}">
                                    @csrf
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="full_name">Select Company <span class="text-danger asteric-sign">&#42;</span></label>
                                                    <select class="form-control" required name="company_id">
                                                        <option value=1>HVAC Demand Board</option>
                                                        <option value=2>Parts Warranty Board</option>
                                                    </select>
                                                      
                                                        @if ($errors->has('company_id'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('company_id') }}</strong>
                                                            </span>
                                                        @endif
                                                   
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="role">Date <span class="text-danger asteric-sign">&#42;</span></label>
                                                    <input class="form-control" required type="date" name="date" placeholder="Slot Date" />
                                                    @if ($errors->has('date'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('date') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="email">Select Slot <span class="text-danger asteric-sign">&#42;</span></label>
                                                    <select class="form-control" required name="slot">
                                                        <option value="9AM - 11PM">9AM - 11PM</option>
                                                        <option value="9AM - 12PM">9AM - 12PM</option>
                                                        <option value="12PM - 3PM">12PM - 3PM</option>
                                                        <option value="3PM - 6PM">3PM - 6PM</option>
                                                    </select>
                                                    @if ($errors->has('slot'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('slot') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="phone_number">No of Slots <span class="text-danger asteric-sign">&#42;</span></label>
                                                    <input id="no_of_slots" required type="text" class="form-control {{ $errors->has('no_of_slots') ? ' is-invalid' : '' }}" name="no_of_slots" placeholder="No of slots">
                                                    @if ($errors->has('no_of_slots'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('no_of_slots') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="password">Password <span class="text-danger asteric-sign">&#42;</span></label>
                                                     <input id="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password">
                                                    @if ($errors->has('password'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('password') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="confirm_password">Confirm Password <span class="text-danger asteric-sign">&#42;</span></label>
                                                    <input id="confirm_password" type="password" class="form-control {{ $errors->has('confirm_password') ? ' is-invalid' : '' }}" name="confirm_password" placeholder="Confirm Password">
                                                    @if ($errors->has('confirm_password'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('confirm_password') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div> -->
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
    

    
   <script>

       

        
    </script>
@endpush

@endsection