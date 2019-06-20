@include('common.buttons.delete', [
    'route' => 'award.destroy',
    'route_params' => [
        'id' => $id,
    ],
    'class' => 'award-delete ajax-confirm-action',
    'name' => '',
    'dataset' => [
        'header' => __('Delete award'),
        'event' => 'AWARD_DELETE',
        'reload' => 0,
        'template-id' => $templateId,
    ],
])
