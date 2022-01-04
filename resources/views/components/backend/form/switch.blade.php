@props([
    'name' ,
    'label' => null,
    'value' => null,
  ])
{{--<x-backend.form.form-group :title="$item['name']" :inputGroup="true" :isInline="true">--}}

{{--<div class="form-group row">--}}
    <label class="col-3 col-form-label">{{$label}}</label>
    <div class="col-3">
   <span class="switch switch-outline switch-icon switch-success">
    <label>
     <input type="checkbox" checked="checked" name="{{$name}}"/>
     <span></span>
    </label>
   </span>
    </div>
{{--</div>--}}
{{--</x-backend.form.form-group>--}}
