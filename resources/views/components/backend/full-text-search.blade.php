@props([
    'formId',
    'name',
    'value'
    ])

<div class="input-group mb-3">
    <input type="text" {{$attributes->class([ 'form-control' , 'is-invalid' => $errors->has($name) ])}} name="{{ $name }}"  value="{{ $value }}" form="{{ $formId }}" placeholder="جستجو در لیست"
           aria-describedby="basic-addon2"  style="border-radius: 0 !important">
    <div class="input-group-append">
        <button class="btn btn-primary" type="submit" form="{{ $formId }}" style="border-radius: 0 !important"> <x-backend.icon class="fa-search"/></button>
    </div>

@error($name)
<div class="invalid-feedback">{{$message}}</div>
@enderror
</div>
