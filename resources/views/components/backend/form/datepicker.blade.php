@props(['name' => 'date', 'value' => '' , 'placeholder' => ''])

<input type="text" {{ $attributes->class([ 'form-control' , ' form-control-solid', 'is-invalid' => $errors->has($name) ]) }}
       placeholder="{{ $placeholder }}" name="{{ $name }}" value="{{ $value }}" data-jdp/>

@error($name)
<div class="invalid-feedback">{{$message}}</div>
@enderror
