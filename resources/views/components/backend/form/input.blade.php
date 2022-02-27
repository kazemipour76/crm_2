@props([
    'name',
    'type'=>'text',
    'placeholder'=>'',
    'separate'=>false,
    'disable'=>false,
    'value'=>'',
    'isFarsi'=>true
])
<input {{ $attributes->class([ 'form-control' , ' form-control-solid', 'is-invalid' => $errors->has($name) ]) }}
       type="{{$type}}" name="{{$name}}"
       placeholder="{{$placeholder}}"
      @if($isFarsi) value="{{ \App\Utilities\HString::number2farsi ($value)}}" @else value="{{ \App\Utilities\HString::number2en($value)}}"  @endif
      {{$disable}}
       @if($separate)
       onkeyup="separateNum(this.value,this);"
       @endif/>
@error($name)
<div class="invalid-feedback">{{$message}}</div>
@enderror
