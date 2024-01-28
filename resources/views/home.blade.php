@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">My Polls</div>

                <div class="card-body">
                    <a href="{{ route('polls.create') }}" class="btn btn-primary mb-3">Create New Poll</a>
                    <ul class="list-group">
                        @foreach ($polls as $poll)
                            <li class="list-group-item">
                                <h5>{{ $poll->title }}</h5>
                                <p>{{ $poll->text }}</p>
                                <p>Type: {{ $poll->type }}</p>
                                <p>Votes: {{ $poll->options->sum('votes') }}</p>
                                @if ($poll->isSingle())
                                    <a href="{{ route('polls.show', $poll) }}" class="btn btn-info">View Poll</a>
                                @else
                                    <a href="{{ route('polls.edit', $poll) }}" class="btn btn-warning">Edit Poll</a>
                                @endif
                                <form action="{{ route('polls.destroy', $poll) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this poll?')">Delete Poll</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
