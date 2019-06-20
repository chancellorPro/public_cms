<tr id="row<?=$templatePlaceholder?>"
    data-id="<?=$templatePlaceholder?>">
    <td>
        <div class="row form-group">
            <div class=" col-md-12 "><br>
                <input type="text" class="form-control"
                       name="ge[{{$templatePlaceholder}}][name]"
                       value="{{ $item['name'] ?? '' }}">
                <input type="hidden" name="ge[{{$templatePlaceholder}}][id]" class="id" value="{{ $templatePlaceholder }}">
            </div>
        </div>
    </td>
    <td>
        <div class="row form-group">
            <div class=" col-md-12 "><br>
                <input class="form-control date-field"
                       name="ge[{{$templatePlaceholder}}][date_from]"
                       value="{{ $item['date_from'] ?? '' }}">
            </div>
        </div>
    </td>
    <td>
        <div class="row form-group">
            <div class=" col-md-12 "><br>
                <input class="form-control date-field"
                       name="ge[{{$templatePlaceholder}}][date_to]"
                       value="{{ $item['date_to'] ?? '' }}">
            </div>
        </div>
    </td>
    @include ('config.app-setting.list-fields', [
        'fields' => [
            'embed_box' => [
                'table_head_attrs' => 'style="width: 400px;float: right"',
                'create_type'      => 'embed',
                'list_type'        => 'embed',
                'filter_type'      => 'embed',
                'embed'            => [
                    'asset_id' => [
                        'alias'       => 'aid',
                        'create_type' => 'int',
                        'list_type'   => 'asset_preview',
                        'filter_type' => 'int',
                        'validator'   => [
                            'required',
                            'exists:assets,id',
                        ],
                    ],
                    'limit'        => [
                        'alias'       => 'l',
                        'create_type' => 'int',
                        'list_type'   => 'int',
                        'filter_type' => 'int',
                        'validator'   => [
                            'required',
                            'int',
                        ],
                    ],
                ]
            ],
        ],
        'config' => 'group-event',
        'rowPrefix' => 'ge',
        'rowIndex' => $templatePlaceholder
    ])
    <td>
        <br>
        @if(!empty($item['id']))
            {{-- Remove Item --}}
            @include('common.buttons.base', [
                'route' => 'group-event.destroy',
                'route_params' => [
                    'id' => $item['id'] ?? '',
                ],
                'btn_body' => __('Delete'),
                'btn_class' => 'btn-danger',
                'class' => 'ajax-confirm-action',
                'dataset' => [
                    'method' => 'DELETE',
                    'header' => __('Delete dye?'),
                    'btn-name' => __('Delete'),
                    'btn-class' => 'btn-danger',
                    'dismiss' => 1,
                    'reload' => 1,
                ],
            ])
        @else
            @include('common.buttons.base', [
                'name' => __('Delete'),
                'btn_class' => 'btn-danger btn-sm delete-row',
            ])
        @endif
        @include('common.buttons.base', [
                'name' => __('History'),
                'route' => 'special-prizes-history.index',
                'route_params' => [
                    'id' => $item['id'] ?? '',
                ],
                'btn_class' => 'btn-warning btn-sm history',
            ])
    </td>
</tr>
