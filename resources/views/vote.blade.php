@extends('layouts.app')

@section('title', 'Vote')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
       
                    <div class="card-header">{{ $poll->title }}</div>
                    <div class="card-body">
                        <p>{{ $poll->text }}</p>
                        {{-- <p>Type: {{ $poll->type }}</p>
                        <p>Start Date: {{ $poll->start_date->format('Y-m-d') }}</p>
                        <p>End Date: {{ $poll->end_date->format('Y-m-d') }}</p> --}}
                        <form action="{{ route('polls.vote', $poll) }}" method="POST">
                            @csrf
                            <ul class="list-group">
                                @foreach ($poll->options as $option)
                                    <li class="list-group-item">
                                        <label for="option-{{ $option->id }}">{{ $option->text }}</label>
                                        @if ($poll->isSingle())
                                            <input type="radio" name="option_id" id="option-{{ $option->id }}"
                                                value="{{ $option->id }}" required>
                                        @else
                                            <input type="checkbox" name="option_ids[]" id="option-{{ $option->id }}"
                                                value="{{ $option->id }}">
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                            <button type="submit" class="btn btn-success mt-3">تصويت</button>
                  
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function share() {
  var shareData = {
    text: 'قم بنسخ الرابط ومشاركته مع من تريد للإجابه على الاستبيان الخاص بك',
    url: document.location.href
  };
  // Check if navigator.canShare() is a function
  if (typeof navigator.canShare === "function" && navigator.canShare(shareData)) {
    navigator.share(shareData);
  } else {
    // Do something else, like copying the data to the clipboard
  }
}

    </script>
@endsection
