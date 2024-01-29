@extends('layouts.app')

@section('title', 'Create Poll')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">إنشاء تصويت</div>

                <div class="card-body">
                    <form action="{{ route('polls.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">العنوان</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="text">الوصف (اختياري)</label>
                            <textarea name="text" id="text" class="form-control @error('text') is-invalid @enderror">{{ old('text') }}</textarea>
                            @error('text')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="type">نوع التصويت</label>
                            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                <option value="{{ \App\Models\Poll::TYPE_SINGLE }}" {{ old('type') == \App\Models\Poll::TYPE_SINGLE ? 'selected' : '' }}>اختيار واحد</option>
                                <option value="{{ \App\Models\Poll::TYPE_MULTIPLE }}" {{ old('type') == \App\Models\Poll::TYPE_MULTIPLE ? 'selected' : '' }}>اختيار متعدد</option>
                            </select>
                            @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="start_date">تاريخ البداية</label>
                            <input type="date" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror"  value="{{ old('start_date', date('Y-m-d')) }}" required>
                            @error('start_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="end_date">تاريخ النهاية</label>
                            <input type="date" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
                            @error('end_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="options">الاختيارات</label>
                            <input type="text" name="options[]" id="options" class="form-control mt-1 @error('options.0') is-invalid @enderror" value="{{ old('options.0') }}" required>
                            @error('options.0')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <input type="text" name="options[]" id="options" class="form-control mt-3 @error('options.1') is-invalid @enderror" value="{{ old('options.1') }}" required>
                            @error('options.1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <input type="text" name="options[]" id="options" class="form-control mt-3 @error('options.2') is-invalid @enderror" value="{{ old('options.2') }}">
                            @error('options.2')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <input type="text" name="options[]" id="options" class="form-control mt-3 @error('options.3') is-invalid @enderror" value="{{ old('options.3') }}">
                            @error('options.3')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success mt-3">إنشاء</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Get references to the start_date and end_date input fields
        var startDateInput = document.getElementById("start_date");
        var endDateInput = document.getElementById("end_date");

        // Add an event listener to the end_date input field
        endDateInput.addEventListener("change", function () {
            // Parse the selected dates
            var startDate = new Date(startDateInput.value);
            var endDate = new Date(endDateInput.value);

            // Check if the end date is before the start date
            if (endDate < startDate) {
                alert("تاريخ النهاية يجب أن يكون بعد تاريخ البداية");
                endDateInput.value = startDateInput.value;
            }
        });
    });
</script>
@endsection
