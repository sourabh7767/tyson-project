@extends('layouts.admin')

@section('title')
    Term & Conditions
@endsection

@section('content')
    @push('page_style')
        <link rel="stylesheet" type="text/css"
            href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    @endpush

    <!-- Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="">Pages</a>
                            </li>
                            <li class="breadcrumb-item active">Term & Conditions
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
                        <h4 class="card-title">Term & Conditions</h4>
                    </div>
                    <div class="card-body">
                        <form class="form" method="post" action="{{ route('admin.term.store') }}">
                            @csrf
                            <div class="card-body innerFormbody">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" name="title"
                                        value="{{ $termData ? $termData->title : '' }}" placeholder="Title" />
                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {{-- <label for="exampleTextarea">Description</label>
														<textarea class="form-control tinymce-editor" name="description"  rows="4">{{ ($termData)?$termData->description:'' }}</textarea>
														 @if ($errors->has('description'))
																<span class="invalid-feedback" role="alert">
																	<strong>{{ $errors->first('description') }}</strong>
																</span>
															@endif --}}

                                    <label for="exampleTextarea">Description</label>
                                    <textarea id="description" name="description" rows="4"
                                        class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="Page Content">{{ ($termData)?$termData->description:'' }}</textarea>
                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                <a href="" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Basic Floating Label Form section end -->
@endsection

@push('page_script')
    <script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
    <!-- <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script> -->

    <script>
        CKEDITOR.replace('description', {
            filebrowserUploadUrl: "{{ route('upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endpush
