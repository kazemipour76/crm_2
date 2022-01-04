@props([
    'targetId' => '',
    'description',
    'title',
    'yes'=>'بله',
    'no'=>'نخیر بازگشت ',
    ])

<div data-toggle="modal"
     data-target="#model"
     data-targetid="{{ $targetId }}"
     data-description="{{ $description }}"
     data-title="{{$title}}"
     data-btn-yes="{{$yes}}"
     data-btn-no="{{$no}}"
>
    {{$slot}}
</div>

