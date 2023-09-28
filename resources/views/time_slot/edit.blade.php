@extends('layouts.admin')

@section('title') Edit Time Slot @endsection

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
                                    <li class="breadcrumb-item active">Edit Time Slot
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
       
                    <div class="row"  >
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Edit Time Slot</h4>
                                </div>
                                <div class="card-body">
                                  <form method="POST" action="{{ route('time_slot.update') }}">
                                    <input type="hidden" name="id" value="{{$timeSlot->id}}" />
                                    @csrf
                                        <div class="row form-container">
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="full_name">Select Company <span class="text-danger asteric-sign">&#42;</span></label>
                                                    <select disabled class="form-control" required >
                                                        @foreach($company as $key => $val)
                                                        <option @if($timeSlot->company_id == $key) selected @endif value={{$key}}>{{$val}}</option>
                                                        @endforeach
                                                        
                                                    </select>
                                                    <input type="hidden" name="company_id" value="{{$timeSlot->company_id}}" />
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
                                                    <input readonly class="form-control" required value="{{date('Y-m-d',strtotime($timeSlot->start_date_time))}}" type="date" name="date" placeholder="Slot Date" />
                                                    @if ($errors->has('date'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('date') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row clone_row" id="templateRow">
                                                <div class="col-md-6 col-12">
                                                    <div class="mb-1">
                                                        <label class="form-label" for="email">Select Slot <span class="text-danger asteric-sign">&#42;</span></label>
                                                        <select disabled class="form-select" required >
                                                            <option @if($timeSlot->slot == "8AM - 9AM") Selected @endif value="8AM - 9AM">8AM - 9AM</option>
                                                            <option @if($timeSlot->slot == "10AM - 1PM") Selected @endif value="10AM - 1PM">10AM - 1PM</option>
                                                            <option @if($timeSlot->slot == "12PM - 3PM") Selected @endif  value="12PM - 3PM">12PM - 3PM</option>
                                                            <option @if($timeSlot->slot == "2PM - 5PM") Selected @endif value="2PM - 5PM">2PM - 5PM</option>
                                                        </select>
                                                        <input type="hidden" name="slot[]" value="{{$timeSlot->slot}}" />
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
                                                        <input id="no_of_slots" required type="text" class="form-control {{ $errors->has('no_of_slots') ? ' is-invalid' : '' }}" value="{{$timeSlot->no_of_slots}}" name="no_of_slots[]" placeholder="No of slots">
                                                        @if ($errors->has('no_of_slots'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('no_of_slots') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <!-- <div class="col-md-2 col-12">
                                                    <div class="mt-2">
                                                        <button type="button" class=" form-control btn btn-primary me-1 waves-effect waves-float waves-light" id="addRow">+</button>
                                                    </div>
                                                </div> -->
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


@endpush

@endsection