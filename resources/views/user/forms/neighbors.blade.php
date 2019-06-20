<div id="neighbors-block" class="form-container">
    <div class="x_panel user-debug-block">
        <div class="x_title">
            <h2>@lang('Neighbors')</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <form method="PUT" class="ajax-form form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}

                @include('layouts.form-fields.input', ['name' => 'neighbor_ids'])
                @if(environment() == 'dev')
                    @include('layouts.form-fields.checkbox', [
                        'fieldId' => 'is-random-neighbors',
                        'name' => "is_random"])

                    @include('layouts.form-fields.input', [
                        'disabled' => true,
                        'name' => 'neighbors_count',
                        'fieldId' => 'neighbors-count',
                        'inputType' => 'number'])
                @endif
            
                <div class="form-group">
                    <div class="col-md-offset-4 col-md-4">
                        @include('common.buttons.base', [
                            'name' => __('Add Neighbors'),
                            'btn_class' => 'btn-primary',
                            'class' => 'ajax-submit-action',
                            'route' => 'users.update',
                            'route_params' => ['id'=>$user->id, 'part'=>'addNeighbors'],
                            'dataset' => [
                                'method' => 'PUT',
                                'event' => 'SUBMIT_USER_PART_FORM',
                                'reload' => 0,
                            ]
                        ])
                    </div>
                </div>
            </form>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            @lang("Id")
                        </th>
                        <th>
                            @lang("Name")
                        </th>
                        <th>
                            @lang("Status")
                        </th>
                        <th>
                            @lang("Actions")
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($neighbors as $neighbor)
                    <tr>
                        <td>
                            <a target="_blank" href="{{ route('users.edit', ['id'=>$neighbor->neighbor_id]) }}" title="@lang('User')">
                                {{ $neighbor->neighbor_id}}
                            </a>
                        </td>
                        <td>
                            <a target="_blank" href="{{ route('users.edit', ['id'=>$neighbor->neighbor_id]) }}" title="@lang('User')">
                                {{ $neighbor->neighbor->name}}
                            </a>
                        </td>
                        <td id="neighbor-status-{{ $neighbor->neighbor_id }}">
                            {{ $statuses[$neighbor->status] ?? ''}}
                        </td>
                        <td>
                            @php
                                $delNeigborClass = $neighbor->status == modelConst('User\UserNeighbor', 'NEIGHBOR_STATUS_ACTIVE') ? '' : 'hidden';
                            @endphp
                                @include('common.buttons.delete', [
                                    'name'         => __('Delete from neighbors'),
                                    'route'        => 'users.update',
                                    'id'           => 'delete-neighbor-' . $neighbor->neighbor_id,
                                    'route_params' => [
                                        'id' => $neighbor->neighbor_id,
                                    ],
                                    'route_params' => [
                                        'id'          =>$user->id,
                                        'part'        =>'deleteNeighbor',
                                        'neighbor_id' => $neighbor->neighbor_id,
                                    ],
                                    'class'        => 'ajax-submit-action ' . $delNeigborClass,
                                    'btn_class'    => 'btn-danger btn-sm',
                                    'fa_class'     => 'fa-thumbs-down',
                                    'dataset'      => [
                                        'method'   => 'PUT',
                                        'event'    => 'DELETE_NEIGHBOR',
                                        'header'   => __('Delete?'),
                                        'btn-name' => __('Delete'),
                                        'reload'   => 0,
                                    ],
                                ])

                                @php
                                    $addNeigborClass = $neighbor->status == modelConst('User\UserNeighbor', 'NEIGHBOR_STATUS_DELETED') ? '' : 'hidden';
                                @endphp
                                @include('common.buttons.delete', [
                                    'name'         => __('Add neighbor'),
                                    'route'        => 'users.update',
                                    'id'           => 'add-neighbor-' . $neighbor->neighbor_id,
                                    'route_params' => [
                                        'id'          =>$user->id,
                                        'part'        =>'addNeighbor',
                                        'neighbor_id' => $neighbor->neighbor_id,
                                    ],
                                    'class'        => 'ajax-submit-action ' . $addNeigborClass,
                                    'btn_class'    => 'btn-success btn-sm',
                                    'fa_class'     => 'fa-thumbs-up',
                                    'dataset'      => [
                                        'method'   => 'PUT',
                                        'event'    => 'ADD_NEIGHBOR',
                                        'header'   => __('Add neighbor?'),
                                        'btn-name' => __('Add neighbor'),
                                        'reload'   => 0,
                                    ],
                                ])
                            {{--@endif    --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            
            </table>
            <div class="pagination-wrapper ajax-pagination" data-container="neighbors-block"> {!! $neighbors->render() !!} </div>
        </div>
    </div>
</div>
