@php
    $currentModel = isset($model) ? $model : null;
@endphp

<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    <div class="col-md-10 col-md-offset-1">
        <textarea class="form-control" name="description" cols="30" rows="10">{{ $currentModel->description }}</textarea>
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>
