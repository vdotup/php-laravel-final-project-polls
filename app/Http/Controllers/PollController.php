<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\Option;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PollController extends Controller
{
    /**
     * Display a listing of the polls.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // // Get the polls created by the authenticated user
        // $polls = auth()->user()->polls;

        // // Return the home view with the polls data
        // return view('home', compact('polls'));
        $user_id = Auth::user()->id;
        $polls = Poll::where("user_id", $user_id)->get();
        // $polls = Poll::all();
        return view('index', compact('polls'));
    }

    /**
     * Show the form for creating a new poll.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view
        return view('create');
    }

    /**
     * Store a newly created poll in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified poll.
     *
     * @param  \App\Models\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function show(Poll $poll)
    {
        // Check if the poll is of single type
        if ($poll->isSingle()) {
            // Return the show view with the poll data
            return view('show', compact('poll'));
        } else {
            // Redirect to the edit route with an error message
            return redirect()->route('polls.edit', $poll)->with('error', 'This poll is of multiple type. You need to edit it to see the results.');
        }
    }

    /**
     * Show the form for editing the specified poll.
     *
     * @param  \App\Models\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function edit(Poll $poll)
    {
        // Return the edit view with the poll data
        return view('edit', compact('poll'));
    }

    /**
     * Update the specified poll in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Poll $poll)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'nullable|string',
            'type' => 'required|in:single,multiple',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|max:255',
        ]);

        // Update the poll with the request data
        $poll->update($request->all());

        // Loop through the request options
        foreach ($request->options as $key => $option) {
            // Get the option by the key
            $option = $poll->options[$key];

            // Update the option with the text
            $option->update(['text' => $option]);

            // Save the option to the database
            $option->save();
        }

        // Redirect to the home route with a success message
        return redirect()->route('home')->with('success', 'Poll updated successfully.');
    }

    /**
     * Remove the specified poll from storage.
     *
     * @param  \App\Models\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function destroy(Poll $poll)
    {
        // Delete the poll from the database
        $poll->delete();

        // Redirect to the home route with a success message
        return redirect()->route('index')->with('success', 'Poll deleted successfully.');
    }

    public function share(Poll $poll) {
        return view('vote' , compact('poll'));
    }


    public function vote(Request $request, Poll $poll)
{
    // Validate the request data
    $request->validate([
        'option_id' => 'required_if:type,single|exists:options,id',
        'option_ids' => 'required_if:type,multiple|array',
        'option_ids.*' => 'exists:options,id',
    ]);

    // Check if the poll is active
    if ($poll->isActive()) {
        // Check the type of the poll
        if ($poll->isSingle()) {
            // Get the option by the request input
            $option = $poll->options->find($request->option_id);
            $option->vote();
        } else {
            // Loop through the request input
            foreach ($request->option_ids as $option_id) {
                // Get the option by the id
                $option = $poll->options->find($option_id);

                // Increment the votes attribute by one
                $option->vote();
            }
        }

        // Redirect to the home route with a success message
    //    return redirect()->route('home')->with('success', 'You have voted successfully.');
    
    echo ' <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script><script>
            window.addEventListener("load", (event) => {
                swal("شكرا لك ", "! تم تسجيل ردك ", "success", {
                    button: "تم"
                });
            });
        </script>';
    } else {
        // Redirect to the home route with an error message
    //    return redirect()->route('home')->with('error', 'This poll is not active.');
    echo ' <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script><script>
            window.addEventListener("load", (event) => {
                swal("شكرا لك ", "! تم تسجيل ردك ", "success", {
                    button: "تم"
                });
            });
        </script>';
    }
}

}
