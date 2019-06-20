<div class="form-group">
    <label for="login" class="col-md-4 control-label">{{ __('Login') }}</label>
    <div class="col-md-6">
        <input class="form-control {{ $errors->has('login') ? ' is-invalid' : ''}}" name="login" type="text" id="login" value="{{ $cmsUser->login or old('login')}}" >
        @if ($errors->has('login'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('login') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group">
    <label for="name" class="col-md-4 control-label">{{ __('Name') }}</label>
    <div class="col-md-6">
        <input class="form-control {{ $errors->has('name') ? ' is-invalid' : ''}}" name="name" type="text" id="name" value="{{ $cmsUser->name or old('name')}}" >
        @if ($errors->has('name'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
</div>
<div class="form-group">
    <label for="email" class="col-md-4 control-label">{{ __('Email') }}</label>
    <div class="col-md-6">
        <input class="form-control {{ $errors->has('email') ? ' is-invalid' : ''}}" name="email" type="email" id="email" value="{{ $cmsUser->email or old('email')}}" >
        @if ($errors->has('email'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>
</div>
<div class="form-group">
    <label for="fb_group_id" class="col-md-4 control-label">{{ __('FB id') }}</label>
    <div class="col-md-6">
        <input type="number" class="form-control {{ $errors->has('fb_group_id') ? ' is-invalid' : ''}}" name="fb_group_id"
                id="fb_group_id" value="{{ $cmsUser->fb_group_id or old('fb_group_id')}}" >
        @if ($errors->has('fb_group_id'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('fb_group_id') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group">
    <label for="user_id" class="col-md-4 control-label">{{ __('User id') }}</label>
    <div class="col-md-6">
        <input type="number" class="form-control {{ $errors->has('user_id') ? ' is-invalid' : ''}}" name="user_id" id="user_id" value="{{ $cmsUser->user_id or old('user_id')}}" >
        @if ($errors->has('user_id'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('user_id') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group">
    <label for="tiara" class="col-md-4 control-label">{{ __('Tiara') }}</label>
    <div class="col-md-6">
        <input type="number" class="form-control {{ $errors->has('tiara') ? ' is-invalid' : ''}}" name="tiara" id="tiara" value="{{ $cmsUser->tiara or old('tiara')}}" >
        @if ($errors->has('tiara'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('tiara') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group">
    <label for="trophy" class="col-md-4 control-label">{{ __('Trophy') }}</label>
    <div class="col-md-6">
        <input type="number" class="form-control {{ $errors->has('trophy') ? ' is-invalid' : ''}}" name="trophy" id="trophy" value="{{ $cmsUser->trophy or old('trophy')}}" >
        @if ($errors->has('trophy'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('trophy') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group">
    <label for="roles" class="col-md-4 control-label">{{ __('Roles') }}</label>
    <div class="col-md-6">
        <select
                id="roles"
                name="roles[]"
                class="form-control here {{ $errors->has('roles') ? ' is-invalid' : '' }} multipleSelect "
                multiple="multiple"
        >
            @foreach($roles as $role)
                <option value="{{ $role->id }}" @if(!empty($cmsUser) && $cmsUser->cmsRoles->contains($role->id)) selected @endif> {{ $role->name }}</option>
            @endforeach
        </select>

        @if ($errors->has('roles'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('roles') }}</strong>
            </span>
        @endif
    </div>
</div>


@include('layouts.form-fields.checkbox', ['model' => $cmsUser, 'name' => 'is_super_admin'])

<div class="form-group">
    <label for="password" class="col-md-4 control-label">{{ __('Password') }}</label>
    <div class="col-md-6">
        <input class="form-control {{ $errors->has('password') ? ' is-invalid' : ''}}" name="password" type="password" id="password" >
        @if ($errors->has('password'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('password_confirmation') ? ' is-invalid' : ''}} ">
    <label for="password-confirm" class="col-md-4 control-label">{{ __('Confirm Password') }}</label>

    <div class="col-md-6">
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
        @if ($errors->has('password_confirmation'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
