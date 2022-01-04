@props([
    'name',
    'placeholder'=>'',
])
<textarea {{ $attributes->class([ 'form-control' , ' form-control-solid', 'is-invalid' => $errors->has($name) ]) }}
          name="{{$name}}"
          placeholder="{{$placeholder}}">
    {{$slot}}
</textarea>
@error($name)
<div class="invalid-feedback">{{$message}}</div>
@enderror
