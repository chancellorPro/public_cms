<div class="form-container">
    <div class="x_panel user-debug-block">
        <div class="x_title">
            <h2>@lang('Placements')</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>

        <div class="x_content" style="width: auto">
            @foreach ($placements as $placement)
                @if($placement['assets_count'])
                    <h4>
                        [{{ $placement['id'] }}] {{ $placement['name'] }} ({{ $placement['assets_count'] }} items)
                        <div class="fa-hover">
                            <a href="javascript:void(0)" class="load-assets" data-placement="{{ $placement['id'] }}">
                                <i class="fa fa-arrow-down"></i>
                                @lang('Load')
                            </a>
                            <a href="javascript:void(0)" class="hide-assets hide" data-placement="{{ $placement['id'] }}">
                                <i class="fa fa-arrow-up"></i>
                                @lang('Hide')
                            </a>
                        </div>
                    </h4>
                    
                    <div class="col-md-12" id="asset-container-{{ $placement['id'] }}"></div>
                @endif
            @endforeach
        </div>
    </div>
</div>
