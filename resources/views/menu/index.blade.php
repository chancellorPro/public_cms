@extends($layout)

@php
    $colLimit = $container == 'lightbox_container'? 5 : 10;
@endphp

@section($container)

    <div class="right_col menu-block" role="main">
        <div>
            <div class="input-group menu-search-block">
                <input autofocus  name="search" class="form-control menu-search" placeholder="@lang('common.search.placeholder')" type="text" value="{{ request('search') }}">
            </div>
        </div>
        @if($container == 'main_container')
            <div>
                @can('menu.edit')
                <a data-toggle="lightbox" href="{{ route('menu.edit') }}" class="btn btn-primary btn-sm wide-lightbox" title="@lang('Edit Bookmarks')" data-title="@lang('Edit Bookmarks')">
                    <i class="fa fa-pencil-square-o"></i> @lang('Edit Bookmarks')
                </a>
                @endcan
            </div>
        @endif
        <div id="common-menu">
            @foreach($menu as $menuItem)
                <div class="common-menu-section">
                    @if (isset($menuItem['child']) && count($menuItem['child']))
                        <h3>{{ __($menuItem['name']) }}</h3>
                        <ul class="nav common-side-menu">
                    @endif
                        @if (isset($menuItem['child']))
                            @php
                                $itemIndex = 1;
                            @endphp
                            @foreach($menuItem['child'] as $childItem)
                                @can($childItem['route'] . (isset($childItem['route_params']) ? '/' . implode('/', $childItem['route_params']) : ''))
                                <li>
                                    <a class="menu-item" href="{{ route($childItem['route'], (array)@$childItem['route_params']) }}">
                                        <i class="fa {{ $childItem['icon'] }}"></i>
                                        <span>{{ $childItem['name'] }}</span>
                                    </a>
                                </li>
                                    @php
                                        $itemIndex++;
                                    @endphp
                                @endcan
                                @if($itemIndex%$colLimit === 0)
                                        </ul>
                                    </div>
                                    <div class="common-menu-section">
                                        <h3>{{ __($menuItem['name']) }}</h3>
                                        <ul class="nav common-side-menu">
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
    @if($container == 'lightbox_container')
        <script type="text/javascript">
            $(document).ready(function(){
                $('.ekko-lightbox-container .menu-search').focus();
            })
        </script>
    @endif

    <style>
        .common-menu-section .nav > li > a.menu-item {
            position: relative;
            text-align: left;
            margin-bottom: 0;
        }
        .common-menu-section .nav > li > a.menu-item .fa {
            position: absolute;
        }
        .common-menu-section .nav > li > a.menu-item span {
            padding-left: 20px;
        }
    </style>
@endsection
