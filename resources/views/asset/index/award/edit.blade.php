@php
    $dataSetResult = [
        'header' => __('Edit award'),
        'reload' => 0,
    ];

    if (!empty($dataset)) {
        $dataSetResult = array_merge($dataSetResult, $dataset);
    }
@endphp
@include('common.buttons.edit', [
    'route' => 'award.edit',
    'route_params' => [
        'id' => $id,
    ],
    'name' => 'Award',
    'dataset' => $dataSetResult,
])
