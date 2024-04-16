@section('title', $data ? $data->title : '' )
@extends('layouts.pages')

@section('content')
              <h2 class="mb-3">
                <strong>{!! $data ? $data->title : '' !!}</strong>
            </h2>
            <p>
                {!! $data ? $data->description : '' !!}
            </p>
@endsection
            