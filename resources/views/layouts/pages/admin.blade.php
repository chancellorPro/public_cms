@extends('layouts.public')

@section('main_container')
    <div class="public right_col">
        <div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="" style="padding-right: 0">
                        <div class="">
                            @if (!empty($menu))
                                <ul class="menu">
                                    @foreach ($menu as $item)
                                        @if (isset($item['route']) && isset($item['name']))
                                            @php
                                                $routeParams = $item['route_params'] ?? [];
                                            @endphp
                                            <li{{ (Route::currentRouteName() == $item['route'] ? ' class=active' : '') }}>
                                                <a href="{{ route($item['route'], $routeParams) }}">@lang($item['name'])</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif

                            @yield('controls')
                            @if (isset($data) and isset($filter))
                                <div class="pagination-wrapper"> {!! $data->appends($filter)->render() !!} </div>
                            @endif

                            @yield('content')

                            @if (isset($data) and isset($filter))
                                <div class="pagination-wrapper"> {!! $data->appends($filter)->render() !!} </div>
                            @endif
                            @yield('controls')

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
