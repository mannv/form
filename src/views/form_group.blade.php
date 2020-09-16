<div class="form-group {{$errors->has($name) ? 'has-error' : ''}}">
    {!! $label !!}
    {!! $element !!}
    @if ($errors->has($name))
        <span class="text-danger">{{$errors->first($name)}}</span>
    @endif
</div>
