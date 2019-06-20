@extends('layouts.app')

@section('main_container')
    <div class="right_col">
        <div>
            <div class="page-title">
                <div class="title_left">
                    <h3>@lang('Players')</h3>
                </div>

                <div class="title_right">
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  
                    <div class="x_panel">
                        <div class="x_content">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>@lang('Id')</th>
                                            <th>@lang('Fb Id')</th>
                                            <th>@lang('User Info')</th>
                                            <th>@lang('Geo Info')</th>
                                            {{--<th>@lang('Email')</th>--}}
                                            {{--<th>@lang('Country')</th>--}}
                                            {{--<th>@lang('Gender')</th>--}}
                                            {{--<th>@lang('Activity')</th>--}}
                                            <th>@lang('XP')</th>
                                            <th>@lang('Currency')</th>
                                            {{--<th>@lang('Cash')</th>--}}
                                            {{--<th>@lang('Coins')</th>--}}
                                            <th>@lang('Actions')</th>
                                        </tr>
                                        <tr>
                                            <th>@include('layouts.filter-col', ['filterType' => 'string', 'field' => 'id'])</th>
                                            <th>@include('layouts.filter-col', ['filterType' => 'string', 'field' => 'fb_id'])</th>
                                            <th>
                                                @include('layouts.filter-col', ['filterType' => 'string', 'field' => 'name', 'label' => 'Name'])
                                                @include('layouts.filter-col', ['filterType' => 'string', 'field' => 'email', 'label' => 'Email'])
                                                @include('layouts.filter-col', ['filterType' => 'string', 'field' => 'gender', 'label' => 'Gender'])
                                            </th>
                                            <th>
                                                @include('layouts.filter-col', ['filterType' => 'string', 'field' => 'ip', 'label' => 'IP'])
                                                @include('layouts.filter-col', ['filterType' => 'string', 'field' => 'country', 'label' => 'Country'])
                                            </th>
                                            {{--<th>@include('layouts.filter-col', ['filterType' => 'string', 'field' => 'email'])</th>--}}
                                            {{--<th>@include('layouts.filter-col', ['filterType' => 'string', 'field' => 'country'])</th>--}}
                                            {{--<th>@include('layouts.filter-col', ['filterType' => 'string', 'field' => 'gender'])</th>--}}

                                            {{--<th></th>--}}

                                            <th>@include('layouts.filter-col', ['filterType' => 'int', 'field' => 'xp'])</th>
                                            <th>
                                                @include('layouts.filter-col', ['filterType' => 'int', 'field' => 'cash', 'label' => 'Cash'])
                                                @include('layouts.filter-col', ['filterType' => 'int', 'field' => 'coins', 'label' =>'Coins'])
                                            </th>

                                            <th class="filter-actions">@include('layouts.filter-col', ['filterType' => 'actions'])</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $item)
                                        @php
                                            $userName = trim($item->first_name . ' ' . $item->last_name);
                                        @endphp
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->fb_id }}</td>
                                            <td>
                                                <div><label>@lang('Name'):</label> {{ $userName }}</div>
                                                <div><label>@lang('Email'):</label> {{ $item->email }}</div>
                                                <div><label>@lang('Gender'):</label> {{ $item->gender }}</div>
                                                <div><label>@lang('Created'):</label> {{ $item->created_at }}</div>
                                                <div><label>@lang('Visited'):</label> {{ $item->visited_at }}</div>
                                                <div><label>@lang('Paid'):</label> {{ $item->paid_at ?? '-' }}</div>
                                                @if(!empty($usersSpent[$item->id]))
                                                    <div><label>@lang('Spent'):</label> {{ $usersSpent[$item->id] }}</div>
                                                @endif

                                            </td>
                                            <td>
                                                <div><label>@lang('IP'):</label> {{ $item->ip }}</div>
                                                <div><label>@lang('Country'):</label> {{ $item->country }}</div>
                                            </td>
                                            {{--<td>{{ $item->email }}</td>--}}
                                            {{--<td>{{ $item->country }}</td>--}}
                                            {{--<td>{{ $item->gender }}</td>--}}
                                            {{--<td>--}}
                                                {{--<div><label>@lang('Created'):</label> {{ $item->created_at }}</div>--}}
                                                {{--<div><label>@lang('Visited'):</label> {{ $item->visited_at }}</div>--}}
                                                {{--<div><label>@lang('Paid'):</label> {{ $item->paid_at ?? '-' }}</div>--}}
                                            {{--</td>--}}

                                            <td>{{ $item->xp }}</td>
                                            <td>
                                                @include('user.list-forms.currency', ['user' => $item])
                                            </td>
                                            {{--<td>{{ $item->coins }}</td>--}}
                                            <td>
                                                {{-- Edit --}}
                                                <a href="{{ route('users.edit', ['id'=>$item->id]) }}" title="@lang('Edit')">
                                                    <button class="btn btn-primary btn-sm">
                                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                        @lang('Edit')
                                                    </button>
                                                </a>

                                                {{-- Delete --}}
                                                @include('common.buttons.delete', [
                                                    'route'        => 'users.destroy',
                                                    'route_params' => [
                                                        'id' => $item->id,
                                                    ],
                                                    'btn_class'     => 'btn-danger btn-sm',
                                                    'dataset' => [
                                                        'header' => __('Delete ') . (!empty($userName) ? $userName : __('User')),
                                                    ],
                                                ])

                                                {{-- Clear Cache --}}
                                                @include('common.buttons.delete', [
                                                    'name'         => __('Clear Cache'),
                                                    'route'        => 'users.clear.cache',
                                                    'route_params' => [
                                                        'id' => $item->id,
                                                    ],
                                                    'btn_class'     => 'btn-warning btn-sm',
                                                    'fa_class'     => 'fa-recycle',
                                                    'dataset' => [
                                                        'method' => 'PATCH',
                                                        'header' => __('Clear Cache'),
                                                        'btn-name' => __('Clear'),
                                                        'reload' => 0,
                                                    ],
                                                ])

                                                {{-- Reset FCD --}}
                                                @include('common.buttons.delete', [
                                                    'name'         => __('Reset FCD'),
                                                    'route'        => 'users.reset.fcd',
                                                    'route_params' => [
                                                        'id' => $item->id,
                                                    ],
                                                    'btn_class'     => 'btn-warning btn-sm',
                                                    'fa_class'     => 'fa-recycle',
                                                    'dataset' => [
                                                        'method' => 'PATCH',
                                                        'header' => __('Reset FCD'),
                                                        'btn-name' => __('Reset'),
                                                        'reload' => 0,
                                                    ],
                                                ])
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="pagination-wrapper"> {!! $users->appends($filter)->render() !!} </div>
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
    $(document).ready(function () {
        init_filter_col("{{ route('users.index') }}");
    })
</script>
@endpush
