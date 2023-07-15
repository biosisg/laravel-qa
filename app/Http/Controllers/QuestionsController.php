<?php

namespace App\Http\Controllers;

use App\Http\Requests\AskQuestionRequest;
use App\Models\Question;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class QuestionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::with('user')->latest()->paginate(5);

        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $question = new Question;

        return view('questions.create', compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     * @param AskQuestionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AskQuestionRequest $request)
    {
        $request->user()->questions()->create($request->only('title', 'body'));

        return redirect()->route('questions.index')->with('success', 'Your question has been submitted.');
    }

    /**
     * Display the specified resource.
     * @param Question $question
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function show(Question $question)
    {
        $question->increment('views');

        return view('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param Question $question
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function edit(Question $question)
    {
        $this->authorize("update", $question);
        return view('questions.edit', compact('question'));

    }

    /**
     * Update the specified resource in storage.
     * @param AskQuestionRequest $request
     * @param Question $question
     */
    public function update(AskQuestionRequest $request, Question $question)
    {
        $this->authorize("update", $question);

        $question->update($request->only('title', 'body'));

        return redirect()->route('questions.index')->with('success', 'Your question has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     * @param Question $question
     */
    public function destroy(Question $question)
    {
        $this->authorize("delete", $question);

        $question->delete();

        return redirect()->route('questions.index')->with('success', 'Your question has been deleted.');
    }
}
