@section('pageTitle', 'Cms User Action Log')
@extends('layouts.app')

@section('main_container')
    <div class="right_col">
        <div>
            <div class="page-title">
                <div class="title_left">
                    <h3>@lang('Cms User Action Log')</h3>
                </div>

                <div class="title_right">
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">

                    <ul class="nav nav-tabs deploy-tabs" id="deployTab" role="tablist">
                        <li class="nav-item @if($activeDirection == 'dev') active @endif">
                            <a class="nav-link" id="dev-tab" data-toggle="tab" href="#dev" role="tab" aria-controls="dev"
                               aria-selected="true">Dev</a>
                        </li>
                        <li class="nav-item @if($activeDirection == 'stage') active @endif">
                            <a class="nav-link" id="stage-tab" data-toggle="tab" href="#stage" role="tab" aria-controls="stage"
                               aria-selected="false">Stage</a>
                        </li>
                        <li class="nav-item @if($activeDirection == 'live') active @endif">
                            <a class="nav-link" id="live-tab" data-toggle="tab" href="#live" role="tab" aria-controls="live"
                               aria-selected="false">Live</a>
                        </li>
                    </ul>

                    <div class="x_panel">
                        <div class="x_content">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>@lang('Id')</th>
                                            <th>@lang('User')</th>
                                            <th>@lang('Source')</th>
                                            <th>@lang('Action')</th>
                                            <th>@lang('Info')</th>
                                            <th>@lang('Date')</th>
                                        </tr>
                                        <tr>
                                            <th class="filter-actions">@include('layouts.filter-col', ['filterType' => 'actions'])</th>
                                            <th>@include('layouts.filter-col', ['filterType' => 'select', 'field' => 'cms_user_id', 'filterCollection' => $users])</th>
                                            <th>@include('layouts.filter-col', ['filterType' => 'string', 'field' => 'source'])</th>
                                            <th>@include('layouts.filter-col', ['filterType' => 'string', 'field' => 'action'])</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rows as $row)
                                        
                                        @switch($row->source)
                                            @case('app_settings')
                                                @include('user-actions.rows.app-settings')
                                                @break
                                            @case('deploy_configs')
                                                @include('user-actions.rows.deploy')
                                            @break
                                            
                                            @default
                                                @include('user-actions.rows.common')
                                        @endswitch
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="pagination-wrapper"> {!! $rows->appends($filter)->render() !!} </div>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset("js/filter-col.js") }}"></script>

<script type="text/javascript">
    $(document).ready(function(){
        init_filter_col("{{ route('cms-user-actions.index') }}");
    })
</script>
@endpush
