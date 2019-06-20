@section('pageTitle', 'Nla asset')
@extends('layouts.pages.config', [
    'title' => 'Nla asset',
])

@section('content')
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
    </ul><br>

    <ul class="nav nav-tabs deploy-tabs" id="assets" role="tablist">
        <li class="asset-tab @if($activeTab == 'list') active @endif">
            <a class="asset-link" id="stage-tab" data-toggle="tab" href="#list" role="tab" aria-controls="list"
               aria-selected="false">All assets</a>
        </li>
        <li class="asset-tab @if($activeTab == 'import') active @endif">
            <a class="asset-link" id="dev-tab" data-toggle="tab" href="#import" role="tab" aria-controls="import"
               aria-selected="true">Asset import & multi-assign</a>
        </li>
        <li class="asset-tab @if($activeTab == 'uncategorized') active @endif">
            <a class="asset-link" id="live-tab" data-toggle="tab" href="#uncategorized" role="tab" aria-controls="uncategorized"
               aria-selected="false">Uncategorized assets</a>
        </li>
    </ul>

    @switch($activeTab)
        @case('import')
            @include ('nla-asset.import')
        @break
        @default
            @include ('nla-asset.list')
    @endswitch

@endsection

@push('scripts')
    <script src="{{ asset("js/filter-col.js") }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            init_filter_col("{{ route('nla-asset.index') }}");
        })
    </script>
@endpush
