<!--begin::Main-->
@include('backend.layout.partials._header-mobile')

<div class="d-flex flex-column flex-root">

    <!--begin::Page-->
    <div class="d-flex flex-row flex-column-fluid page">

    @include('backend.layout.partials._aside')


    <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

        @include('backend.layout.partials._header')


        <!--begin::Content-->
            <div class="content d-flex flex-column flex-column-fluid p-5" id="kt_content">

                @if(\App\Utilities\MessageBag::get()->count() > 0)
                    @foreach(\App\Utilities\MessageBag::pull() as $error)
                        <div class="alert alert-{{ $error['type'] }}">{{ $error['message'] }}</div>
                    @endforeach
                @endif

                @yield('body')
            </div>

            <!--end::Content-->
        </div>

        <!--end::Wrapper-->
    </div>

    <!--end::Page-->
</div>

<!--end::Main-->
