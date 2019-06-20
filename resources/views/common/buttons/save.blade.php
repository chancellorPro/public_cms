@php
    $dataSetResult = [
        'method' => 'POST',
        'dismiss' => 1,
        'reload' => 1,
    ];

    if (!empty($dataset)) {
        $dataSetResult = array_merge($dataSetResult, $dataset);
    }
@endphp
@include('common.buttons.base', [
    'name' => $name ?? __('Save'),
    'fa_class' => $fa_class ?? '',
    'btn_class' => $btn_class ?? 'btn-primary btn-sm',
    'class' => $class ?? 'ajax-submit-action',
    'dataset' => $dataSetResult,
])
