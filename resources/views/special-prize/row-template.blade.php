<tr>
    <td>
        <div class="row form-group">
            <div class=" col-md-12 "><br>
                <input type="text" class="form-control"
                       name="ge[{{$templatePlaceholder}}][name]"
                       value="{{ $item['name'] ?? '' }}">
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
                        'create_type' => 'int',
                        'list_type'   => 'asset_preview',
                        'validator'   => [
                            'required',
                            'exists:assets,id',
                        ],
                    ],
                    'limit'        => [
                        'create_type' => 'int',
                        'list_type'   => 'int',
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
        @if(isset($item) && count($item['embed_box']) > 0)
            @include('common.buttons.base', [
                    'name' => __('Send'),
                    'route' => 'special-prizes.form',
                    'route_params' => [
                        'id' => $item['id'] ?? '',
                    ],
                    'btn_class' => 'btn-primary btn-sm history',
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
