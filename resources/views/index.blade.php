@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">
                    <a href="{{ route('polls.create') }}" class="btn btn-primary mb-3">تصويت جديد</a>
                    <ul class="list-group">
                        @foreach ($polls as $poll)
                            <li class="list-group-item">
                                <h5>{{ $poll->title }}</h5>
                                <p>{{ $poll->text }}</p>
                                <p>{{ $poll->type == "single" ? "اختيار واحد" : "اختيار متعدد" }}</p>
                                <p>الأصوات: {{ $poll->options->sum('votes') }}</p>
                                <a href="{{ route('polls.share', $poll) }}" class="btn btn-primary">مشاركة</a>
                                <a href="{{ route('polls.show', $poll) }}" class="btn btn-primary">الاحصائيات</a>
                                <form action="{{ route('polls.destroy', $poll) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('هل أنت متأكد من حذف التصويت؟')">حذف</button>
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

