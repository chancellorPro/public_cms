<div class="row form-group {{ $errors->has('files') ? 'has-error' : ''}}">
    <label class="col-md-4 control-label"> @formFieldLabel($name) </label>
    <div class="col-md-6">
        <div class="row">
            @if ((!empty($files) && !empty($mult)) || (!empty($file) && empty($mult)))

                @php
                    if (empty($mult)) {
                        $files[] = $file;
                    }
                @endphp

                @foreach($files as $file)
               
                <div class="col-md-3 {{$type}}-thumbnail file-box thumbnail">
                        <input type="hidden" name="uploaded_{{ $name }}[]" value="{{ $file->{$id} }}">
                        @if ($type == 'image')
                            <img class="img-responsive" src="{{ Storage::url($file->{$url}) }}" title="@formFieldLabel($name)">
                        @endif
                        @if ($type == 'file')
                            <span>
                                {{ $file->{$fileName} }}
                            </span>
                        @endif
                        <a class="fa fa-times-circle delete-file" href="javascript:void()"></a>
                        
                </div>
                <a 
                    @if(isset($fileName)) 
                        download="{{ $file->{$fileName} }}" 
                    @endif
                    class="btn btn-success btn-download"  
                    href="{{ Storage::url($file->{$url}) }}">
                        <i class="fa fa-download"></i>
                </a>
                @endforeach
            @endif
        </div>
        <div class="input-group">
            <label class="input-group-btn">
                <span class="btn btn-primary btn-file-upload">
                    @lang('common.file.browse')
                    <input 
                        type="file" 
                        @if(!empty($fileExt))accept="{{$fileExt}}"@endif
                        name="{{ $name }}@if(!empty($mult))[]@endif" 
                        style="display: none;" @if(!empty($mult)) multiple @endif>
                </span>
            </label>
            <input type="text" class="form-control" readonly />
        </div>
        <span class="help-block">
            @if(!empty($mult))
                @lang('common.file.mult')
            @else
                @lang('common.file.single')
            @endif
        </span>
        {!! $errors->first($name, '<p class="help-block">:message</p>') !!}
    </div>
</div>
