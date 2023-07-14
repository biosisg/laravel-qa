@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h2>Ask Question</h2>
                            <div class="ml-auto">
                                <a href="{{ route('questions.index') }}"
                                   class="btn btn-outline-secondary">Back to all Questions</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('questions.store') }}" method="post">
                            @csrf
                            <div class="form-group p-2">
                                <label for="question-title">Question Title</label>
                                <input type="text"
                                       id="question-title"
                                       name="title"
                                       class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                       value="">
                                @if ($errors->has('title'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('title') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group p-2">
                                <label for="question-body">Explain your question</label>
                                <textarea name="body"
                                          id="question-body"
                                          rows="10"
                                          class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}"></textarea>
                                @if ($errors->has('body'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('body') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group p-2">
                                <button type="submit" class="btn btn-outline-primary btn-lg">Ask this question</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
