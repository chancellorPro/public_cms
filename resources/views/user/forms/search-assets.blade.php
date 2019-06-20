<div class="form-container">
    <div class="x_panel user-debug-block">
        <div class="x_title">
            <h2>@lang('Search Assets')</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            
            <form method="GET" action="{{ route('users.get_part', ['user' => $user->id, 'part' => 'searchAssets']) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}

                @include('layouts.form-fields.input', ['name' => 'asset_ids'])

                @include('common.buttons.base', [
                    'name' => __('Search Assets'),
                    'btn_class' => 'btn-primary',
                    'fa_class' => 'fa-search',
                    'class' => 'ajax-submit-action',
                    'route' => 'users.get_part',
                    'route_params' => ['user' => $user->id, 'part' => 'searchAssets'],
                    'dataset' => [
                        'event' => 'SEARCH_USER_ASSETS',
                        'reload' => 0,
                    ]
                ])
                
            </form>
            <div class="col-md-12" id="search-assets-container"></div>
        </div>
    </div>
</div>
