@extends('layouts.app')

@section('title', 'Edit Poll')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">تعديل التصويت</div>

                <div class="card-body">
                    <form action="{{ route('polls.update', $poll) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="title">العنوان</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ $poll->title }}" required>
                        </div>

                        <div class="form-group mt-3">
                            <label for="text">الوصف (اختياري)</label>
                            <textarea class="form-control" id="text" name="text" rows="3">{{ $poll->text }}</textarea>
                        </div>

                        <div class="form-group mt-3">
                            <label for="type">نوع التصويت</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="single" {{ $poll->type == 'single' ? 'selected' : '' }}>اختيار واحد</option>
                                <option value="multiple" {{ $poll->type == 'multiple' ? 'selected' : '' }}>اختيار متعدد</option>
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <label for="start_date">تاريخ البداية</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $poll->start_date->format('Y-m-d') }}" required>
                        </div>

                        <div class="form-group mt-3">
                            <label for="end_date">تاريخ النهاية</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $poll->end_date->format('Y-m-d') }}" required>
                        </div>

                        <div class="form-group mt-3">
                            <label for="options">الاختيارات</label>
                            @foreach($poll->options as $option)
                                <input type="text" class="form-control mb-2 mt-1" name="options[]" value="{{ $option->text }}" required>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary">تحديث</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
