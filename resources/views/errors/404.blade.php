@extends('layouts.app')

@section('body-class')
the-404
@endsection

@section('content')
    <div class="contain">
        <div class="content">
            <h2 style="margin-top: 10%; text-align: center">{{ $exception->getMessage() }}</h2>
        </div>
    </div>

@endsection