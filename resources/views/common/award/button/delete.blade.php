@include('common.buttons.delete', [
    'route' => 'award.destroy',
    'route_params' => [
        'id' => $id,
    ],
    'name' => '',
    'class' => 'award-delete-button ajax-confirm-action',
    'dataset' => [
        'header' => __('Delete award'),
        'event' => 'AWARD_DELETE',
        'reload' => 0,
        'template-id' => $templateId,
    ],
])
