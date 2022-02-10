@props([
    'title' => 'title',
    'name' ,
    'value' => null,
    'checked' => false
  ])

<div class="form-group  mb-0">
    <div class="radio-list p-1">
        <label class="radio radio-success ">
            <input type="radio" name="{{ $name }}" value="{{ $value }}"

                       {{$checked}}  />
            <span></span>
            {{ $title }}
        </label>
    </div>
</div>
