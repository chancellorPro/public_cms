@section('pageTitle', 'Special Prizes')
@extends('layouts.pages.config', [
    'title' => 'Special Prizes',
])

@section('content')
    <div class="table-responsive">
        <template id="template">
            @include ('special-prize.row-template', ['templatePlaceholder' => '%id%'])
        </template>

        <table class="table table-hover" id="special-prize-users">
            <thead>
            <tr>
                <th>@lang('Name')</th>
                <th>@lang('Date from')</th>
                <th>@lang('Date to')</th>
                <th style="width: 400px;">@lang('Assets')</th>
                <th>@lang('Actions')</th>
            </tr>
            </thead>
            <tr>
                <th>@include('layouts.filter-col', ['filterType' => 'string', 'field' => 'name'])</th>
                <th>
                    <div class="form-group">
                        <input autocomplete="off" placeholder="Date from"
                               class="filter form-control datepicker"
                               value="{{ old("date_from") ?? '' }}" name="date_from" id="filter_date_from">
                    </div>
                </th>
                <th>
                    <div class="form-group">
                        <input autocomplete="off" placeholder="Date to"
                               class="filter form-control datepicker"
                               value="{{ old("date_to") ?? '' }}" name="date_to" id="filter_date_to">
                    </div>
                </th>
                <th></th>
                <th class="filter-actions">@include('layouts.filter-col', ['filterType' => 'actions'])</th>
            </tr>
            <tbody class="special-prize-save-container">
            @foreach($rows as $id => $row)
                @include ('special-prize.row-template', [
                'item' => $row,
                'templatePlaceholder' => $row['id'],
                'assets' => $assets
                ])
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset("js/filter-col.js") }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            init_filter_col("{{ route('special-prizes.index') }}");
        })
    </script>
@endpush
