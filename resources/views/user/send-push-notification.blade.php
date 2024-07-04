@extends('layouts.admin')

@section('title')
    Send Push Notification
@endsection
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@section('content')
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Send Push Notification
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
                    <h5><b>Send Push Notification</b></h5>
                </div>
                <div class="card-body">
                    {{-- <form method="POST" action="{{ route('User.Send.Push.Notification') }}">
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
                        <div class="form-group row">
                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn btn-primary my-4">Submit</button>
                            </div>
                        </div>
                    </form> --}}
                    <form action="{{ route('User.Send.Push.Notification') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="float-right" for="users">Select Users</label>
                                </div>
                                <div class="col-md-6">
                                        <select name="users[]" id="users" class="form-control {{ $errors->has('users') ? ' is-invalid' : '' }}" multiple="multiple">
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('users'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('users') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div><br>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="float-right" for="send_to_all">Send to All Users</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="checkbox" class="form-check-input {{ $errors->has('send_to_all') ? ' is-invalid' : '' }}" id="send_to_all" name="send_to_all" value="1">&nbsp;&nbsp;Yes</input>
                                    @if ($errors->has('send_to_all'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('send_to_all') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="float-right" for="send_to_all">Title</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="title" id="title" placeholder="Enter the title" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}">
                                    @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="float-right" for="send_to_all">Message</label>
                                </div>
                                <div class="col-md-6">
                                    <textarea name="message" id="message" placeholder="Enter the message" class="form-control {{ $errors->has('message') ? ' is-invalid' : '' }}"></textarea>
                                    @if ($errors->has('message'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                                @endif
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="float-right" for="send_to_all">URL (Optional)</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="url" name="url" id="url" placeholder="Enter the url" class="form-control {{ $errors->has('url') ? ' is-invalid' : '' }}">
                                    @if ($errors->has('url'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('url') }}</strong>
                                    </span>
                                @endif
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Notifications</button>
                    </form>
                
                </div>
            </div>
        </div>
    </div>
@push('page_script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#users').select2({
                placeholder: "Select users",
                allowClear: true
            });

            $('#send_to_all').change(function() {
                if(this.checked) {
                    $('#users').prop('disabled', true);
                } else {
                    $('#users').prop('disabled', false);
                }
            });
        });
    </script>

@endpush
@endsection
