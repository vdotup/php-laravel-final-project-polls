@extends('layouts.app')

@section('title', 'Create Poll')

@section('content')
<div class="container" dir="rtl">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Poll</div>

                <div class="card-body">
                    <form action="{{ route('polls.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="text">Text (optional)</label>
                            <textarea name="text" id="text" class="form-control @error('text') is-invalid @enderror">{{ old('text') }}</textarea>
                            @error('text')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                <option value="{{ \App\Models\Poll::TYPE_SINGLE }}" {{ old('type') == \App\Models\Poll::TYPE_SINGLE ? 'selected' : '' }}>Single Choice</option>
                                <option value="{{ \App\Models\Poll::TYPE_MULTIPLE }}" {{ old('type') == \App\Models\Poll::TYPE_MULTIPLE ? 'selected' : '' }}>Multiple Choice</option>
                            </select>
                            @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required>
                            @error('start_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
                            @error('end_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="options">Options</label>
                            <input type="text" name="options[]" id="options" class="form-control @error('options.0') is-invalid @enderror" value="{{ old('options.0') }}" required>
                            @error('options.0')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <input type="text" name="options[]" id="options" class="form-control @error('options.1') is-invalid @enderror" value="{{ old('options.1') }}" required>
                            @error('options.1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <input type="text" name="options[]" id="options" class="form-control @error('options.2') is-invalid @enderror" value="{{ old('options.2') }}">
                            @error('options.2')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <input type="text" name="options[]" id="options" class="form-control @error('options.3') is-invalid @enderror" value="{{ old('options.3') }}">
                            @error('options.3')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success">Create Poll</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
