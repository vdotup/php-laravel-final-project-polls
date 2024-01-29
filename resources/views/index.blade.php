@extends('layouts.app')

@section('title', 'Home')

@section('content')
<style>
    .delete-poll-btn {
        position: absolute;
        bottom: 5px;
        left: 5px;
        font-size: 16pt;
        color: red;
        border: none;
        background-color: transparent;
    }

    .edit-poll-btn {
        position: absolute;
        bottom: 5px;
        left: 40px;
        font-size: 16pt;
        color: 007bff;
        border: none;
        background-color: transparent;
    }

    .copy-link-btn {
        position: absolute;
        bottom: 5px;
        right: 5px;
        font-size: 16pt;
        color: #007bff;
        border: none;
        background-color: transparent;
    }

    .list-group-item {
        position: relative;
        margin-bottom: 20px;
    }

    .votes-icon {
        margin-right: 5px;
    }

    .copy-votes-icon {
        margin-left: 5px;
    }

    .option-item {
        margin-bottom: 10px;
    }

    .progress {
        height: 5px;
    }

    .progress-bar {
        height: 100%;
    }

    .poll-card {
        position: relative;
    }

    .expired-card {
        background-color: #eaeaea;
    }

    .expiration-date {
        position: absolute;
        top: 5px;
        left: 5px;
        font-size: 12px;
        color: #999;
    }

    
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">
                    <a href="{{ route('polls.create') }}" class="btn btn-primary mb-3">تصويت جديد</a>
                    @foreach ($polls as $poll)
                    <div class="card mb-3 poll-card {{ $poll->isActive() ? '' : 'expired-card' }}">
                        @if ($poll->isActive())
                            <span class="expiration-date">ينتهي في: {{ date('d/m/Y', strtotime($poll->end_date)) }}</span>
                        @else
                            <span class="expiration-date">منتهي</span>
                        @endif
                        <div class="card-body" style="margin-bottom: 15px;">
                            <h5 class="card-title">{{ $poll->title }}</h5>
                            <p class="card-text">{{ $poll->text }}</p>
                            <p><i class="fas fa-vote-yea votes-icon"></i> مجموع الأصوات: {{ $poll->options->sum('votes') }}</p>
                            <ul class="list-group">
                                @foreach ($poll->options as $option)
                                    <li class="list-group-item option-item">
                                        <h5 style="font-size: 10pt">{{ $option->text }}</h5>
                                        <p style="font-size: 10pt">عدد الأصوات: {{ $option->votes }}</p>
                                        <div class="progress">
                                            @if ($poll->options->sum('votes') > 0)
                                                <div class="progress-bar" role="progressbar" style="width: {{ $option->votes / $poll->options->sum('votes') * 100 }}%" aria-valuenow="{{ $option->votes }}" aria-valuemin="0" aria-valuemax="{{ $poll->options->sum('votes') }}"></div>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <button class="btn delete-poll-btn" onclick="return confirm('هل أنت متأكد من حذف التصويت؟')">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        <button class="btn edit-poll-btn" onclick="window.location.href='{{ route('polls.edit', $poll) }}'">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn copy-link-btn" onclick="copyPublicLink('{{ route('polls.share', $poll->token) }}')">
                            <i class="fas fa-copy copy-votes-icon"></i>
                        </button>
                        
                    </div>
                    @endforeach
                </div>
                
            </div>
        </div>
    </div>
</div>

@endsection

<script>
    function copyPublicLink(link) {
        navigator.clipboard.writeText(link).then(function() {
            alert('تم نسخ الرابط!');
        }, function() {
            alert('Failed to copy public link!');
        });
    }
</script>
