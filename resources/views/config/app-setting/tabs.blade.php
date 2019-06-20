@if (!empty($formSettings['tabs']))
    <ul class="nav nav-tabs"  role="tablist">
        @php
            $currentRouteName = Route::currentRouteName();
        @endphp
        @foreach($formSettings['tabs'] as $tab)
            @php
                $routeParams = $tab['route_params'] ?? [];
                $isActiveLink = true;
                if($tab['route'] != $currentRouteName) {
                    $isActiveLink = false;
                } else {
                    foreach ($routeParams as $routeParamName => $routeParamValue) {
                        if (Request::route($routeParamName) != $routeParamValue) {
                            $isActiveLink = false;
                        }
                    }
                }
            @endphp
            <li class="nav-item @if($isActiveLink) active @endif">
                <a class="nav-link" href="{{ route($tab['route'], $routeParams) }}">
                     @lang($tab['name'])
                </a>
            </li>
        @endForeach
    </ul>
@endif