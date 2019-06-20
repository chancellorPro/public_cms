@php
    $dataSetResult = [
        'method' => 'DELETE',
        'header' => __('Delete'),
        'btn-name' => __('Delete'),
        'btn-class' => 'btn-danger btn-sm',
        'dismiss' => 1,
        'reload' => 1,
    ];

    if (!empty($dataset)) {
        $dataSetResult = array_merge($dataSetResult, $dataset);
    }
@endphp
@include('common.buttons.base', [
    'name' => $name ?? __('Delete'),
    'fa_class' => $fa_class ?? 'fa-trash-o',
    'btn_class' => $btn_class ?? 'btn-danger btn-sm',
    'class' => $class ?? 'ajax-confirm-action',
    'dataset' => $dataSetResult,
])
