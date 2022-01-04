@php
    $cardId = \Illuminate\Support\Str::random(10);
@endphp

<div {{ $attributes->merge(['class' => 'card card-custom custom-shadow']) }}>
    <div class="card-header color{{ $color }}">
        <div class="card-title">
            {{--            <x-backend.icon class="{{$icon}}"/>--}}


            <h3 class="card-label ">
                <x-backend.icon class="{{$icon}}"/>
                {{ $title }}</h3>
        </div>


        <div class="card-toolbar">
            <a class="card-collapse btn btn-icon btn-sm btn-hover-light-primary mr-1" data-toggle="collapse" data-target="#{{$cardId}}">
                <i class="ki ki-arrow-down icon-nm" style="color: #FFFFFF"></i>
            </a>
        </div>
    </div>

    <div class="card-container collapse @if(!$isCollapse) show @endif"  id="{{$cardId}}">

        <div @class(["card-body", "p-0" => $noPadding])">
        @isset($nav)
            <div class="col-lg-12 py-2 bg-secondary">
                {{ $nav }}
            </div>
        @endisset

        {{ $slot  }}
    </div>

    @isset($footer)
        <div class="card-footer text-right bg-gray-100 border-top-0">
            {{ $footer  }}
        </div>
    @endisset
</div>

</div>

@push('style')
    <style>
        .custom-shadow {
            box-shadow: 1px 1px 5px gray !important;
        }

        .color0 {
            background-color: #f1aeae !important;
        }

        .color1 {
            background-color: #95e37b !important;
        }

        .color2 {
            background-color: #7be0e3 !important;
        }

        .color3 {
            background-color: #e3d57b !important;
        }

        .color4 {
            background-color: #7be3e0 !important;
        }

        .color5 {
            background-color: #95e37b !important;
        }

        .color6 {
            background-color: #7b9ee3
        }

        .color7 {
            background-color: #bb7be3
        }

        .color8 {
            background-color: #e37b7b
        }

        .color9 {
            background-color: #95e37b
        }

        .color10 {
            background-color: #95e37b
        }
    </style>
@endpush


@push('script')
{{--    <script>--}}
{{--        $(function(){--}}
{{--            $('.card-collapse').click(function (e){--}}
{{--                e.preventDefault();--}}
{{--                $(this).parents('.card').first().children('.card-container').slideUp();--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
@endpush
