@if ($model instanceof \App\Models\Question)
    @php
        $name = 'question';
        $url = "/questions/" . $model->id . "/vote";
    @endphp
@elseif ($model instanceof \App\Models\Answer)
    @php
        $name = 'answer';
        $url = "/answers/" . $model->id . "/vote";
    @endphp

@endif

@php
    $formId = $name . "-" . $model->id;
@endphp

<div class="flex-column vote-controls">
    <a title="This {{ $name }} is useful"
       class="vote-up {{ Auth::guest() ? 'off': '' }}"
       onclick="event.preventDefault(); document.getElementById('up-vote-{{ $formId }}').submit();"
    >
        <i class="fas fa-caret-up fa-2x"></i>
    </a>
    <form id="up-vote-{{ $formId }}"
          action="{{ $url }}"
          method="post"
          style="display: none">
        @csrf
        <input type="hidden" name="vote" value="1">
    </form>

    <span class="votes-count">{{ $model->votes_count }}</span>
    <a title="This {{ $name }} is not useful" class="vote-down  {{ Auth::guest() ? 'off': '' }}"
       onclick="event.preventDefault(); document.getElementById('down-vote-{{ $formId }}').submit();"
    >
        <i class="fas fa-caret-down fa-2x"></i>
    </a>
    <form id="down-vote-{{ $formId }}"
          action="{{ $url }}"
          method="post"
          style="display: none">
        @csrf
        <input type="hidden" name="vote" value="-1">
    </form>

    @if ($model instanceof \App\Models\Question)
        @include('shared._favorite', ['model' => $model])
    @elseif ($model instanceof \App\Models\Answer)
        @include('shared._accept', ['model' => $model])
    @endif
</div>
