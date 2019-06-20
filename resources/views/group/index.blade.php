@section('pageTitle', 'Master List Of Group Admins')
@extends('layouts.pages.config', [
    'title' => 'Master List Of Group Admins',
])

@section('content')
<style>
    .ids_container{
        margin: 0 auto; width: 900px
    }
    .ids_container div{
        display: inline-block;
    }
    .ids_container div textarea, .ids_container div button{
        width: 400px;
    }
</style>

    <div class="ids_container">
        <div>
            <textarea id="main_ids">{{ implode(',', $main_ids) ?? '' }}</textarea><br>
            <button class="copy" data-target="main_ids">Copy main IDs</button>
        </div>
        <div>
            <textarea id="all_ids">{{ implode(',', $all_ids) ?? '' }}</textarea><br>
            <button class="copy" data-target="all_ids">Copy all IDs</button>
        </div>
    </div><br><br>

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

    <div class="table-responsive">
        <template id="user_template">
            @include ('group.row-template', ['templatePlaceholder' => '%id%'])
        </template>

        <table class="table table-hover" id="group-cup-users">
            <thead>
            <tr>
                <th class="id">@lang('Is Main')</th>
                <th>@lang('User ID')</th>
                <th>@lang('Name')</th>
                <th>@lang('Group')</th>
            </tr>
            </thead>
            <tbody class="group-save-container">
            @foreach($rows as $id => $row)
                @include ('group.row-template', ['item' => $row, 'templatePlaceholder' => $row->id])
            @endforeach
            </tbody>
        </table>
    </div>
@endsection


@push('scripts')
    <script src="{{ asset("js/filter-col.js") }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            init_filter_col("{{ route('group.index') }}");
        })
    </script>
@endpush
