@props([
    'name',
    'type'=>'text',
    'placeholder'=>'',
    'separate'=>false,
    'disable'=>false,
    'value'=>''
])
<input {{ $attributes->class([ 'form-control' , ' form-control-solid', 'is-invalid' => $errors->has($name) ]) }}
       type="{{$type}}" name="{{$name}}"
       placeholder="{{$placeholder}}"
       value="{{ \App\Utilities\HString::number2farsi ($value)}}"
      {{$disable}}
       @if($separate)
       onkeyup="separateNum(this.value,this);"
       @endif/>
@error($name)
<div class="invalid-feedback">{{$message}}</div>
@enderror
