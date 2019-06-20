@extends('layouts.app')

@section('main_container')
    <div class="right_col">
        <div>
            <div class="page-title">
                <div class="title_left">
                    <h3>@lang($formSettings['name'])</h3>
                </div>

                <div class="title_right">
                    
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    @include('config.app-setting.tabs')
                    <div class="x_panel">
                        <div class="x_content">
                            @if(!$formSettings['fixed_rows'])
                            @can('settings.create/' . Request::route('config'))
                            <a href="{{ route('settings.create', ['config' => $config]) }}" class="btn btn-success btn-sm" title="@lang('common.add') setting">
                                <i class="fa fa-plus" aria-hidden="true"></i> @lang('common.add')
                            </a>
                            @endcan
                            @endif

                            @can('settings.update/' . Request::route('config'))
                            <a id="update-all" href="javascript:void(0)" style="display: none" class="btn btn-success btn-sm" title="@lang('common.save_all') setting">
                                <i class="fa fa-save" aria-hidden="true"></i> @lang('common.save_all')
                            </a>
                            @endcan

                            <div class="table-responsive">
                                <div class="pagination-wrapper"> {{ $rows->appends($_GET)->links() }}
                                    <div class="page-limit-wrapper">
                                        @include('layouts.form-fields.select', [
                                            'label' => false,
                                            'name' => 'page_limit',
                                            'class' => 'page-limit',
                                            'collection' => arrayToCollection(config('presets.page_limit')),
                                            'id' => 'id',
                                            'value' => 'name',
                                            'selected' => request('page_limit', config('presets.default_page_limit'))
                                         ])
                                    </div>
                                </div>

                                {{--Award buttons templates--}}
                                @include('common.award.template', [
                                        'fieldName' => "%field_name%",
                                        'reload' => 0,
                                ])

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            @foreach($fields as $field => $fieldData)
                                            <th
                                                {!! $fieldData['table_head_attrs'] ?? '' !!}
                                                class="{!! $fieldData['table_head_class'] ?? '' !!}"
                                            >
                                                {{__("forms.$config.$field")}}
                                            </th>
                                            @endforeach
                                            <th class="col-md-2">@lang('Actions')</th>
                                        </tr>
                                        <tr id="filter">
                                            <th></th>
                                            @foreach($fields as $field => $fieldData)
                                            <th>
                                                @switch($fieldData['filter_type'])
                                                    @case('string')
                                                        @include('layouts.form-fields.input', ['name' => $field, 'value' => $filter[$field] ?? '', 'label' => FALSE, 'fieldId' => "filter_$field"])
                                                        @break
                                                    @case('int')
                                                        @include('layouts.form-fields.input', ['name' => $field, 'value' => $filter[$field] ?? '', 'inputType' => 'number', 'label' => FALSE, 'fieldId' => "filter_$field"])
                                                        @break
                                                    @case('select')
                                                        @include('layouts.form-fields.select2', [
                                                            'name' => $field,
                                                            'collection' => $presetsData[$field]['forSelect'] ?? [],
                                                            'selected' => $filter[$field] ?? '',
                                                            'id'=>'id',
                                                            'value'=>'name',
                                                            'label'=> FALSE,
                                                            'addempty'=>TRUE,
                                                            'fieldId' => "filter_$field"
                                                        ])
                                                        @break
                                                    @default
                                                        {{$row[$field] ?? ''}}
                                                @endswitch
                                            </th>
                                            @endforeach
                                            <th>
                                                <a href="javascript:void(0)" id="list-filter" class="btn btn-info btn-sm" title="@lang('common.filter')">
                                                    <i class="fa fa-filter" aria-hidden="true"></i> @lang('common.filter')
                                                </a>
                                                <a href="javascript:void(0)" id="clear-filter" class="btn btn-info btn-sm" title="@lang('common.clear_filter')">
                                                    <i class="fa fa-times" aria-hidden="true"></i> @lang('common.clear_filter')
                                                </a>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rows as $id => $row)
                                        <tr id="row{{$id}}" data-id="{{$id}}" data-action="{{ route('settings.update', ['config' => $config, 'id'=>$id]) }}">
                                            <td>
                                                @include('layouts.form-fields.checkbox', ['name' => 'selected', 'value' => '', 'label' => FALSE, 'fieldId' => 'check_' . $id, 'class' => 'for-update' ])
                                            </td>

                                            @include ('config.app-setting.list-fields', ['fields' => $fields, 'namePrefix' => ''])

                                            <td>
                                                @can('settings.update/' . Request::route('config'))
                                                <a href="javascript:void(0)" title="@lang('Save')" class="update-row"><button class="btn btn-success btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> @lang('Save')</button></a>
                                                @endcan
                                                @if(!$formSettings['fixed_rows'] && $formSettings['removable'] )
                                                @can('settings.destroy/' . Request::route('config'))
                                                <form method="POST" action="{{ route('settings.destroy', ['config' => $config, 'id' => $id]) }}" accept-charset="UTF-8" style="display:inline">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete setting" data-toggle="confirmation"><i class="fa fa-trash-o" aria-hidden="true"></i> @lang('Delete')</button>
                                                </form>
                                                @endcan
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="pagination-wrapper"> {{ $rows->appends($_GET)->links() }} </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        var chengedRowsCount = 0;
        var url = "{{ route('settings.index', ['config' => $config, 'page'=>Request::get('page')]) }}";
        $('#list-filter').click(function(){
            filter();
        })

        $('#filter').keypress(function(e) {
            if(e.which == 13) {
                filter();
            }
        });

        $('#clear-filter').click(function(){
            filter(true);
        });



        function enableSave() {
            if (chengedRowsCount > 0) {
                $('#update-all').removeClass('disabled');
            } else {
                $('#update-all').addClass('disabled');
            }
        }

        function filter(clear = false) {
            let filter = '';
            if (!clear) {
                filter = $('#filter').find("select, input").serialize();
            }
            window.location.href = url + (url.charAt(url.length - 1) == '?' ? '' : '&') + filter;
        }

        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
        });

        $('#update-all').click(function(e){
            e.preventDefault();
            $.each($(".for-update:checked"), function(){
                let rowToSave = $(this).parents('tr');
                saveRow(rowToSave);
            });
        });

        $('.update-row').click(function(e){
            let rowToSave = $(this).parents('tr');
            saveRow(rowToSave);
        });




        function saveRow (rowToSave) {
            let id = rowToSave.data('id');
            let action = rowToSave.data('action');
            var row = rowToSave.find(".editable select, .editable input").serializeArray();

            $.ajax({
                type: "PUT",
                dataType: 'json',
                url: action,
                data: row,
                success: function( resp ) {
                    $.notify({
                        message: resp.msg
                    },{
                        type: resp.type
                    });
                },
                error: function (jqXHR, exception) {
                    if (jqXHR.responseJSON.hasOwnProperty('errors')) {
                        $.each( jqXHR.responseJSON.errors, function(errorKey, error ) {
                            $.each( error, function(messageKey, message ) {
                                $.notify({
                                    message: message
                                },{
                                    type: 'danger'
                                });
                            });
                        });
                    }
                }
            });
        }
    })


</script>
@endpush
