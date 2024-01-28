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
                    <p>نوع الإختيار: {{ $poll->type == "single" ? "واحد" : "متعدد" }}</p>
                    <p>تاريخ البداية: {{ $poll->start_date->format('Y-m-d') }}</p>
                    <p>تاريخ النهاية: {{ $poll->end_date->format('Y-m-d') }}</p>
                    <p>مجموع الأصوات: {{ $poll->options->sum('votes') }}</p>
                    <ul class="list-group">
                        @foreach ($poll->options as $option)
                            <li class="list-group-item">
                                <h5>{{ $option->text }}</h5>
                                <p>عدد الأصوات: {{ $option->votes }}</p>
                                <div class="progress">
                                    @if ($poll->options->sum('votes') > 0)
                                    <div class="progress-bar" role="progressbar" style="width: {{ $option->votes / $poll->options->sum('votes') * 100 }}%" aria-valuenow="{{ $option->votes }}" aria-valuemin="0" aria-valuemax="{{ $poll->options->sum('votes') }}"></div>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('index') }}" class="btn btn-secondary mt-3">عودة</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
