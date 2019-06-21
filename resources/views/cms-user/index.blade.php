@extends('layouts.app')

@section('main_container')
    <div class="right_col">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ url('/cms-users/create') }}" class="btn btn-success btn-sm"
                           title="Add New cms-user">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>@lang('ID')</th>
                    <th>@lang('Login')</th>
                    <th>@lang('Email')</th>
                    <th>@lang('Name')</th>
                    <th class="actions">@lang('Actions')</th>
                </tr>
                <tr>
                    <th>@include('layouts.filter-col', ['filterType' => 'string', 'field' => 'id'])</th>
                    <th>@include('layouts.filter-col', ['filterType' => 'string', 'field' => 'login'])</th>
                    <th>@include('layouts.filter-col', ['filterType' => 'string', 'field' => 'email'])</th>
                    <th>@include('layouts.filter-col', ['filterType' => 'string', 'field' => 'name'])</th>
                    <th class="filter-actions">@include('layouts.filter-col', ['filterType' => 'actions'])</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cmsUsers as $item)
                    <tr>
                        <td>{{ $loop->iteration or $item->id }}</td>
                        <td>{{ $item->login }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->name }}</td>
                        <td>
                            <a href="{{ url('/cms-users/' . $item->id) }}" title="View cms-user">
                                <button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>
                                    View
                                </button>
                            </a>
                            <a href="{{ url('/cms-users/' . $item->id . '/edit') }}" title="Edit cms-user">
                                <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"
                                                                          aria-hidden="true"></i> Edit
                                </button>
                            </a>

                            {{-- Delete User btn --}}
                            @include('common.buttons.delete', [
                                'route' => 'cms-users.destroy',
                                'route_params' => [
                                    'id' => $item->id,
                                ],
                                'dataset' => [
                                    'header' => __('Delete') . ' ' . $item->name,
                                ],
                                //'btn_class' => $btn_class ?? 'btn-danger btn-xs',
                            ])
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="pagination-wrapper"> {!! $cmsUsers->appends(['search' => Request::get('search')])->render() !!} </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset("js/filter-col.js") }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            init_filter_col("{{ route('cms-users.index') }}");
        })
    </script>
@endpush
