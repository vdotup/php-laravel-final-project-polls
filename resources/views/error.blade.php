@extends('layouts.app')

@section('title', 'خطأ')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">خطأ</div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-exclamation-triangle fa-5x text-danger"></i>
                    </div>
                    <p class="text-center">{{ $errorMessage }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection