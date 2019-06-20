@extends('layouts.app')

@section('main_container')
<div class="right_col">
    <div>
        <div class="page-title">
            <div class="title_left">
                <h3>@lang('Edit User') #{{ $user->id }}</h3>
            </div>
            <div class="title_right"></div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <a href="{{ route('users.index') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> @lang('common.back')</button></a>
            <br />
            <br />

            <div class="col-md-12 col-sm-12">
                @include ('user.forms.common')
                @include ('user.forms.pets')
                @include ('user.forms.add-placement')
                @include ('user.forms.add-asset')

                @include ('user.forms.search-assets')
                @include ('user.forms.placements')
                @include ('user.forms.neighbors')
            </div>
            
        </div>
    </div>
</div>
@endsection

@push('globals')
<script type="text/javascript">
    
    /**
     * Global PLACEMENT_ASSETS_ROUTE for loadPlacementAssets.js
     */
    const PLACEMENT_ASSETS_ROUTE = '{{ route('users.get_part', ['user' => $user->id, 'part' => 'placementAssets']) }}';
        
</script>
@endpush