@extends($layout)

@section($container)
    <div class="right_col menu-block" role="main">
        <div>
            <div class="input-group menu-search-block">
                <input autofocus  name="search" class="form-control menu-search" placeholder="@lang('common.search.placeholder')" type="text" value="{{ request('search') }}">
            </div>
        </div>
        <div id="common-menu">
            <form method="POST" action="{{ route('menu.update') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}
                @foreach($menu as $menuItem)
                    <div class="common-menu-section bookmark-menu">
                        <h3>{{ __($menuItem['name']) }}</h3>
                        <ul class="nav common-side-menu">
                            @if (isset($menuItem['child']))
                                @foreach($menuItem['child'] as $childItem)
                                    <li>
                                        <div class="form-horizontal">
                                        <a class="menu-item" href="{{ route($childItem['route'], (array)@$childItem['route_params']) }}">
                                            <i class="fa {{ $childItem['icon'] }}"></i>
                                            {{ $childItem['name'] }}
                                        </a>
                                        <br>
                                        @php
                                            $bookmarkRow = !isset($bookmarks[$childItem['route']]) ? $childItem : $bookmarks[$childItem['route']];
                                        @endphp
                                        @include('layouts.form-fields.checkbox', [ 'name' => "menu[{$childItem['route']}][top]", 'label' => __('Top'), 'value' => !empty($bookmarkRow['top']) ])
                                        @include('layouts.form-fields.checkbox', [ 'name' => "menu[{$childItem['route']}][left]", 'label' => __('Left'), 'value' => !empty($bookmarkRow['left']) ])
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                @endforeach
                <div class="form-group">
                    <div class="col-md-offset-4 col-md-4">
                        <input class="btn btn-primary" type="submit" value="{{ __('common.save') }}">
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if($container == 'lightbox_container')
        <script type="text/javascript">
            $(document).ready(function(){
                $('.ekko-lightbox-container .menu-search').focus();
            })
        </script>
    @endif
@endsection
