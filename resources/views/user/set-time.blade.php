@extends('layouts.admin')

@section('title')
    Reminder Settings
@endsection

@section('content')
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Reminder Settings
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><b>Reminder Settings</b></h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('user.setTime.submit') }}">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="exampleInputPassword1" class="float-right">Login time</label>
                                </div>
                                <div class="col-md-6">
                                    <input name="start_time" type="time"
                                        class="form-control {{ $errors->has('start_time') ? ' is-invalid' : '' }}"
                                        id="exampleInputPassword1" placeholder="Start time"
                                        value="{{ @$time->start_time }}">
                                    @if ($errors->has('start_time'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('start_time') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="exampleInputPassword2" class="float-right"
                                        value="{{ @$time->end_time }}">Logout Time</label>
                                </div>
                                <div class="col-md-6">
                                    <input name="end_time" type="time"
                                        class="form-control {{ $errors->has('end_time') ? ' is-invalid' : '' }}"
                                        id="exampleInputPassword2" placeholder="Enter End" value="{{ @$time->end_time }}">
                                    @if ($errors->has('end_time'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('end_time') }}</strong>
                                        </span>
                                    @endif
                                </div>

                            </div>
                        </div><br>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="exampleInputPassword2" class="float-right">Login Message</label>
                                </div>
                                <div class="col-md-6">
                                    <input name="start_message" type="text"
                                        class="form-control {{ $errors->has('start_message') ? ' is-invalid' : '' }}"
                                        id="exampleInputPassword2" value="{{ @$time->start_message }}"
                                        placeholder="Enter End">
                                    @if ($errors->has('start_message'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('start_message') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="exampleInputPassword2" class="float-right">Logout Message</label>
                                </div>
                                <div class="col-md-6">
                                    <input name="end_message" type="text"
                                        class="form-control {{ $errors->has('end_message') ? ' is-invalid' : '' }}"
                                        id="exampleInputPassword2" value="{{ @$time->end_message }}"
                                        placeholder="Enter End">
                                    @if ($errors->has('end_message'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('end_message') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div><br>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="float-right" for="flexRadioDefault1">
                                        Cron Status  ( {{@$time->is_cron_on == 1 ? "Working" : "Off"}} )
                                      </label>
                                </div>
                                <div class="col-md-6">
                                        <input class="form-check-input" type="radio" name="is_cron_on" id="flexRadioDefault1" value="1" {{@$time->is_cron_on == 1 ? "checked" : ""}}>&nbsp;&nbsp;Yes&nbsp;</input>
                                        <input class="form-check-input" type="radio" name="is_cron_on" id="flexRadioDefault1" value="2" {{@$time->is_cron_on == 2 ? "checked" : ""}}>&nbsp;&nbsp;No</input>
                                </div>
                                   
                            </div>
                        </div>
                        <br>
                        {{-- <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="float-right" for="flexRadioDefault1">
                                        Default radio
                                      </label>
                                </div>
                               
                            </div>
                        </div>
                        <br> --}}
                        <div class="form-group row">
                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn btn-primary my-4">Submit</button>
                            </div>
                        </div>






                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
