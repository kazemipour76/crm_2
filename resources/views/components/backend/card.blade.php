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
            background-color: #6188fc !important;
        }

        .color1 {
            background-color: #9db5fc !important;
        }

        .color2 {
            background-color: #e1b0f5 !important;
        }

        .color3 {
            background-color: #c371ee !important;
        }

        .color4 {
            background-color: #f7f79c !important;
        }

        .color5 {
            background-color: #f1f166 !important;
        }

        .color6 {
            background-color: rgba(146, 248, 217, 0.94) !important;
        }

        .color7 {
            background-color: #34eea7 !important;
        }

        .color8 {
            background-color: #32d2b8!important;
        }

        .color9 {
            background-color: #82e6d6!important;
        }

        .color10 {
            background-color: #ffff6e!important;
        }
        .color11 {
            background-color: #ffff8c!important;
        }
        .color12 {
            background-color: rgba(168, 39, 149, 0.85) !important;
        }
        .color13 {
            background-color: rgba(3, 186, 239, 0.88) !important;
        }
        .color14 {
            background-color: #127296!important;
        }
        .color15 {
            background-color: rgba(151, 26, 107, 0.88) !important;
        }
        .color16 {
            background-color: #e7ce14!important;
        }
        .color17 {
            background-color: #61cf7c!important;
        }
        .color18 {
            background-color: #95e37b!important;
        }
        .color19 {
            background-color: #e3ee43 !important;
        }
        .color20 {
            background-color: #95e37b!important;
        }
        .color21 {
            background-color: #95e37b!important;
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
