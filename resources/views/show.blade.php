@extends('layouts.app')

@section('title', 'Show Poll')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $poll->title }}</div>
                <div class="card-body">
                    <p>{{ $poll->text }}</p>
                    <p>Type: {{ $poll->type }}</p>
                    <p>Start Date: {{ $poll->start_date->format('Y-m-d') }}</p>
                    <p>End Date: {{ $poll->end_date->format('Y-m-d') }}</p>
                    <p>Total Votes: {{ $poll->options->sum('votes') }}</p>
                    <ul class="list-group">
                        @foreach ($poll->options as $option)
                            <li class="list-group-item">
                                <h5>{{ $option->text }}</h5>
                                <p>Votes: {{ $option->votes }}</p>
                                <div class="progress">
                                    {{-- <div class="progress-bar" role="progressbar" style="width: {{ $option->votes / $poll->options->sum('votes') * 100 }}%" aria-valuenow="{{ $option->votes }}" aria-valuemin="0" aria-valuemax="{{ $poll->options->sum('votes') }}"></div> --}}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('index') }}" class="btn btn-secondary mt-3">Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
