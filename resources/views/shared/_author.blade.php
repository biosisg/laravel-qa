<div class="float-sm-end">
    <span class="text-muted">{{ $label . " " . $model->created_date }}</span>
    <div class="media mt-2 mb-1">
        <a href="{{ $model->user->url }}" class="pr-2">
            <img src="{{ $model->user->avatar }}" alt="">
        </a>
        <span class="mt-1">
            <a href="{{ $model->user->url }}">{{ $model->user->name }}</a>
        </span>
    </div>
</div>
