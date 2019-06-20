@if($formSettings['add_mult_rows'])
    @include('layouts.form-fields.input', ['name' => 'count', 'inputType' => 'number', 'value' => 1, 'label'=> __("forms.settings.count")])
    <br><br>
@endif

@include ('config.app-setting.form-fields', ['fields' => $fields, 'namePrefix' => ''])

<div class="form-group">
    @can('settings.store/' . Request::route('config'))
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or __('common.create') }}">
    </div>
    @endcan
</div>
