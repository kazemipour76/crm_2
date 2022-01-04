@props([
    'title',
    'isInline' => false,
    'inputGroup' => true
 ])

<div @class(['form-group',  'mb-2' , 'form-inline' => $isInline]) >
    <label>{{ $title }}</label>
    <div @class(['input-group' => $inputGroup])>
        {{ $slot }}
    </div>
</div>
