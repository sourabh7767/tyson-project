@extends('layouts.admin')

@section('title')Export Time Slot Sheet @endsection

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
                            <li class="breadcrumb-item"><a href="{{route('users.index')}}">Export</a>
                            </li>
                            <li class="breadcrumb-item active">Export Time Slot
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
                        <h4 class="card-title">Export Time Slot</h4>
                    </div>
                    <div class="card-body">
                      <form method="POST" action="{{ route('exportSheet') }}">
                        @csrf
                            <div class="row form-container">
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="role">Date <span class="text-danger asteric-sign">&#42;</span></label>
                                        <input class="form-control" required type="date" name="date" placeholder="Slot Date" value="{{ old('date') }}" />
                                        @if ($errors->has('date'))
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $errors->first('date') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="Submit" class="btn btn-primary me-1">Export</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



    </section>

@endsection