<div class="form-group {{$errors->has($name) ? 'has-error' : ''}}">
    {!! $label !!}
    {!! $element !!}
    @if ($errors->has($name))
        <span class="help-block">{{$errors->first($name)}}</span>
    @endif
</div>