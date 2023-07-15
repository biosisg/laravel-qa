@csrf
<div class="form-group p-2">
    <label for="question-title">Question Title</label>
    <input type="text"
           id="question-title"
           name="title"
           class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
           value="{{ old('title', $question->title) }}">
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
              class="form-control
              {{ $errors->has('body') ? 'is-invalid' : '' }}">{{ old('body', $question->body) }}</textarea>
    @if ($errors->has('body'))
        <div class="invalid-feedback">
            {{ $errors->first('body') }}
        </div>
    @endif
</div>
<div class="form-group p-2">
    <button type="submit" class="btn btn-outline-primary btn-lg">{{ $buttonText }}</button>
</div>
