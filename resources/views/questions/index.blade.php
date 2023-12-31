@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h2>All Questions</h2>
                            <div class="ml-auto">
                                <a href="{{ route('questions.create') }}"
                                   class="btn btn-outline-secondary">Ask Question</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        @include('layouts._messages')

                        @foreach($questions as $question)
                            <div class="media d-flex flex-row">
                                <div class="flex-column counters">
                                    <div class="vote">
                                        <strong>{{ $question->votes_count }}</strong> {{ str_plural('vote', $question->votes_count ) }}
                                    </div>
                                    <div class="status {{ $question->status }}">
                                        <strong>{{ $question->answers_count }}</strong> {{ str_plural('answer', $question->answers_count ) }}
                                    </div>
                                    <div class="view">
                                        {{ $question->views . " " . str_plural('view', $question->views ) }}
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div class="d-flex justify-content-between">
                                        <h3 class="mt-0"><a href="{{ $question->url }}">{{ $question->title }}</a></h3>
                                        <div>
                                            @can('update', $question)
                                                <a href="{{ route('questions.edit', $question->id) }}"
                                                   class="btn btn-outline-info">Edit</a>
                                            @endcan
                                            @can('delete', $question)
                                                <form action="{{ route('questions.destroy', $question->id) }}"
                                                      method="post"
                                                      class="form-delete">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger"
                                                            onclick="return confirm('Are you sure ?')">Delete
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                    <p class="">
                                        <small>
                                            Asked by
                                            <a href="{{ $question->user->url }}">{{ $question->user->name }}</a>
                                            <span class="text-muted">{{ $question->created_date }}</span>
                                        </small>
                                    </p>
                                    <div class="excerpt">{{ $question->excerpt(350) }}</div>
                                </div>
                            </div>
                            <hr>
                        @endforeach

                        {{ $questions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
