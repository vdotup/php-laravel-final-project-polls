<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\Option;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PollController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $polls = Poll::where("user_id", $user_id)->get();
        return view('index', compact('polls'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'nullable|string',
            'type' => 'required|in:single,multiple',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|max:255',
        ]);

        $poll = new Poll($request->all());

        $poll->user()->associate(auth()->user());

        $poll->save();

        foreach ($request->options as $option) {
            $option = new Option(['text' => $option, 'votes' => 0]);
            $option->poll()->associate($poll);
            $option->save();
        }

        return redirect()->route('index')->with('success', 'Poll created successfully.');
    }

    public function show(Poll $poll)
    {
        return view('show', compact('poll'));
    }

    public function edit(Poll $poll)
    {
        return view('edit', compact('poll'));
    }

    public function update(Request $request, Poll $poll)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'nullable|string',
            'type' => 'required|in:single,multiple',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|max:255',
        ]);

        $poll->update($request->all());

        foreach ($request->options as $key => $optionText) {
            if (isset($poll->options[$key])) {
                $poll->options[$key]->update(['text' => $optionText]);
            } else {
                $option = new Option(['text' => $optionText, 'votes' => 0]);
                $option->poll()->associate($poll);
                $option->save();
            }
        }

        $poll->options()->whereNotIn('id', collect($request->options)->pluck('id'))->delete();

        return redirect()->route('index')->with('success', 'Poll updated successfully.');
    }

    public function destroy(Poll $poll)
    {
        $poll->options()->delete();
        $poll->delete();
        return redirect()->route('index')->with('success', 'Poll deleted successfully.');
    }

    public function share($token)
    {
        $poll = Poll::where('token', $token)->firstOrFail();

        if (!$poll) {
            return view('error', ['errorMessage' => 'التصويت غير موجود']);
        }

        if (!$poll->isActive()) {
            return view('error', ['errorMessage' => 'التصويت غير مفعل']);
        }

        if ($poll->userHasVoted(request())) {
            return view('error', ['errorMessage' => 'لقد قمت بالتصويت بالفعل']);
        }

        return view('vote', compact('poll'));
    }

    public function vote(Request $request, $token)
    {
        $poll = Poll::where('token', $token)->firstOrFail();

        if (!$poll) {
            return view('error', ['errorMessage' => 'التصويت غير موجود']);
        }

        $request->validate([
            'option_id' => 'required_if:type,single|exists:options,id',
            'option_ids' => 'required_if:type,multiple|array',
            'option_ids.*' => 'exists:options,id',
        ]);

        if (!$poll->isActive()) {
            return view('error', ['errorMessage' => 'التصويت غير مفعل']);
        }

        if ($poll->userHasVoted($request)) {
            return view('error', ['errorMessage' => 'لقد قمت بالتصويت بالفعل']);
        }

        if ($poll->isSingle()) {
            $option = $poll->options->find($request->option_id);
            $option->vote();
        } else {
            foreach ($request->option_ids as $option_id) {
                $option = $poll->options->find($option_id);
                $option->vote();
            }
        }

        $poll->markAsVoted($request);

        echo ' <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script><script>
            window.addEventListener("load", (event) => {
                swal("شكرا لك ", "! تم تسجيل ردك ", "success", {
                    button: "تم"
                });
            });
        </script>';
    }
}
