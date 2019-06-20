<div class="row form-group {{ $errors->has('files') ? 'has-error' : ''}}">
    <label class="col-md-4 control-label"> @formFieldLabel($name) </label>
    <div class="col-md-6">
        <div class="row">
            @if (!empty($file))
                <div class="col-md-3 {{$type}}-thumbnail file-box thumbnail">
                        <input type="hidden" name="uploaded_{{ $name }}" value="{{ $file }}">
                        @if ($type == 'image')
                            <img class="img-responsive" src="{{ Storage::url($file) }}" title="@formFieldLabel($name)">
                            <a class="fa fa-times-circle delete-file" href="javascript:void()"></a>
                        @endif
                        @if ($type == 'file')
                            <span>
                                {{ $file }}
                            </span>
                            <a class="fa fa-times-circle delete-file" href="javascript:void()"></a>
                        @endif
                </div>
            <a class="btn btn-success btn-download" href="{{ Storage::url($file) }}"><i class="fa fa-download"></i></a>
            @endif
        </div>
        <div class="input-group">
            <label class="input-group-btn">
                <span class="btn btn-primary btn-file-upload">
                    @lang('common.file.browse')<input type="file" name="{{ $name }}" style="display: none;">
                </span>
            </label>
            <input type="text" class="form-control" readonly>
        </div>
        <span class="help-block">
            @lang('common.file.single')
        </span>
        {!! $errors->first($name, '<p class="help-block">:message</p>') !!}
    </div>
</div>
