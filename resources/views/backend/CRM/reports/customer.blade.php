<div class="col-xl-4">
    <!--begin::لیست Widget 4-->
    <div class="card card-xl-stretch mb-5 mb-xl-8 ">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5 text-center">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder text-dark text-center">گزارشات مشتریان</span>
                {{--                <span class="text-muted mt-1 fw-bold fs-7">تت</span>--}}
            </h3>
            <div class="card-toolbar text-center">
                <!--begin::Menu-->

                <!--begin::Menu 3-->
                <div
                    class="menu menu-sub "
                    data-kt-menu="true">
                    <!--begin::Heading-->
                    <div class="menu-item px-3">
                        <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase"> تعداد مشتریان</div>
                    </div>
                    <!--end::Heading-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">

                        <a  class="menu-link px-3 text-center font-size-h1"id="customerCount">
                            {{$customerCount}}</a>
                    </div>

                </div>
                <!--end::Menu 3-->
                <!--end::Menu-->
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body pt-5">
            <!--begin::item-->
            <div class="d-flex align-items-sm-center mb-7">
                <!--begin::Symbol-->
                <div class="symbol symbol-50px me-5">

                </div>
                <!--end::Symbol-->
                <!--begin::بخش-->
                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                    <div class="flex-grow-1 me-2">
                        <a href="http://127.0.0.1:8000/sadmin/crm/customer?date_type=updated_at&entity=natural&date_from=&date_to=&term=&perPage=5" class="text-gray-800 text-hover-primary fs-6 fw-bolder"> تعداد مشتریان حقیقی</a>
                    </div>
                    <span class="badge badge-light fw-bolder my-2">{{$entityNatural}} مشتری </span>
                </div>
                <!--end::بخش-->
            </div>
            <!--end::item-->
            <!--begin::item-->
            <div class="d-flex align-items-sm-center mb-7">
                <!--begin::Symbol-->
                <div class="symbol symbol-50px me-5">

                </div>
                <!--end::Symbol-->
                <!--begin::بخش-->
                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                    <div class="flex-grow-1 me-2">
                        <a href="http://127.0.0.1:8000/sadmin/crm/customer?date_type=updated_at&entity=legal&date_from=&date_to=&term=&perPage=5" class="text-gray-800 text-hover-primary fs-6 fw-bolder">تعداد مشتریان حقوقی</a>
                    </div>
                    <span class="badge badge-light fw-bolder my-2">{{$entityLegal}} مشتری </span>
                </div>
                <!--end::بخش-->
            </div>
            <!--end::item-->
            <!--begin::item-->
            <div class="d-flex align-items-sm-center mb-7">
                <!--begin::Symbol-->
                <div class="symbol symbol-50px me-5">

                </div>
                <!--end::Symbol-->
                <!--begin::بخش-->
                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                    <div class="flex-grow-1 me-2">
                        <a  class="text-gray-800 text-hover-primary fs-6 fw-bolder">فروش کل مشتریان حقیقی</a>
                        <span class="text-muted fw-bold d-block fs-7">رسمی و غیر رسمی</span>
                    </div>
                    <span class="badge badge-light fw-bolder my-2">{{\App\Utilities\HString::number2farsi(\App\Utilities\HString::dividePrice(str_replace(",","",$totalSumNatural)/10))}} تومان </span>
                </div>
                <!--end::بخش-->
            </div>
            <!--end::item-->
            <!--begin::item-->
            <div class="d-flex align-items-sm-center mb-7">
                <!--begin::Symbol-->
                <div class="symbol symbol-50px me-5">

                </div>
                <!--end::Symbol-->
                <!--begin::بخش-->
                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                    <div class="flex-grow-1 me-2">
                        <a class="text-gray-800 text-hover-primary fs-6 fw-bolder">فروش کل مشتریان حقوقی</a>
                        <span class="text-muted fw-bold d-block fs-7">رسمی و غیر رسمی</span>
                    </div>
                    <span class="badge badge-light fw-bolder my-2">{{\App\Utilities\HString::number2farsi(\App\Utilities\HString::dividePrice(str_replace(",","",$totalSumLegal)/10))}} تومان  </span>
                </div>
                <!--end::بخش-->
            </div>
            <!--end::item-->
            <!--begin::item-->

            <!--end::item-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::لیست Widget 4-->
</div>
