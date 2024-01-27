@extends('layouts.app')

@section('title', 'Welcome to Laravel Polls')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Welcome</div>

                <div class="card-body">
                    <p>This is a simple website for creating and sharing polls using Laravel 10.</p>
                    <p>To get started, please <a href="{{ route('login') }}">login</a> or <a href="{{ route('register') }}">register</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
