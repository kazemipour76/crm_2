<div class="col-xl-4">
    <!--begin::لیست Widget 6-->
    <div class="card card-xl-stretch mb-xl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5 text-center">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder text-dark text-center">گزارشات فاکتورها</span>
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
                        <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase"> تعداد فاکتورها</div>
                    </div>
                    <!--end::Heading-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3 ">

                        <a class="menu-link px-3 text-center font-size-h1" id="invoiceCount">
                            {{$invoiceCount}}</a>
                    </div>
                    <div class="menu-item px-3">
                        <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase"> مبلغ فاکتورهای صادر شده
                        </div>
                        <span class="badge badge-light fw-bolder my-2 font-size-h4">{{\App\Utilities\HString::number2farsi(\App\Utilities\HString::dividePrice(str_replace(",","",$totalSumPriceInvoice)/10))}} تومان </span>
                    </div>


                </div>
                <!--end::Menu 3-->
                <!--end::Menu-->
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body pt-0">
            <!--begin::item-->
            <div class="d-flex align-items-center bg-light-warning rounded p-5 mb-7">
                <!--begin::Icon-->
                <span class="svg-icon svg-icon-warning me-5">
														<!--begin::Svg Icon | path: icons/duotone/خانه/Library.svg-->

                    <!--end::Svg Icon-->
													</span>
                <!--end::Icon-->
                <!--begin::Title-->
                <div class="flex-grow-1 me-2">
                    <a href="#" class="fw-bolder text-gray-800 text-hover-primary fs-6"> رسمی و حقوقی</a>
                    <span class="text-muted fw-bold d-block">  تعداد  {{$invoiceOfficialLegalCount}}</span>
                </div>
                <!--end::Title-->
                <!--begin::Lable-->
                <span class="fw-bolder text-warning py-1">{{\App\Utilities\HString::number2farsi(\App\Utilities\HString::dividePrice(str_replace(",","",$invoiceOfficialLegalPrice)/10))}} تومان </span>
                <!--end::Lable-->
            </div>
            <!--end::item-->
            <!--begin::item-->
            <div class="d-flex align-items-center bg-light-success rounded p-5 mb-7">
                <!--begin::Icon-->
                <span class="svg-icon svg-icon-success me-5">
														<!--begin::Svg Icon | path: icons/duotone/خانه/Library.svg-->

                    <!--end::Svg Icon-->
													</span>
                <!--end::Icon-->
                <!--begin::Title-->
                <div class="flex-grow-1 me-2">
                    <a href="#" class="fw-bolder text-gray-800 text-hover-primary fs-6"> رسمی و حقیقی</a>
                    <span class="text-muted fw-bold d-block"> تعداد  {{$invoiceOfficialNaturalCount}}</span>
                </div>
                <!--end::Title-->
                <!--begin::Lable-->
                <span class="fw-bolder text-success py-1">
                    {{\App\Utilities\HString::
number2farsi(\App\Utilities\HString
::dividePrice(str_replace(",","",$invoiceOfficialNaturalPrice)/10))}} تومان </span>
                <!--end::Lable-->
            </div>
            <!--end::item-->
            <!--begin::item-->
            <div class="d-flex align-items-center bg-light-danger rounded p-5 mb-7">
                <!--begin::Icon-->
                <span class="svg-icon svg-icon-danger me-5">
														<!--begin::Svg Icon | path: icons/duotone/خانه/Library.svg-->

                    <!--end::Svg Icon-->

													</span>
                <!--end::Icon-->
                <!--begin::Title-->
                <div class="flex-grow-1 me-2">
                    <a href="#" class="fw-bolder text-gray-800 text-hover-primary fs-6">غیررسمی و حقوقی</a>
                    <span class="text-muted fw-bold d-block">تعداد  {{$invoiceUnOfficialLegalCount}}</span>
                </div>
                <!--end::Title-->
                <!--begin::Lable-->
                <span class="fw-bolder text-danger py-1">    {{\App\Utilities\HString::
number2farsi(\App\Utilities\HString
::dividePrice(str_replace(",","",$invoiceUnOfficialLegalPrice)/10))}} تومان</span>
                <!--end::Lable-->
            </div>
            <!--end::item-->
            <!--begin::item-->
            <div class="d-flex align-items-center bg-light-info rounded p-5">
                <!--begin::Icon-->
                <span class="svg-icon svg-icon-info me-5">
														<!--begin::Svg Icon | path: icons/duotone/خانه/Library.svg-->

														</span>
                <!--end::Svg Icon-->
                </span>
                <!--end::Icon-->
                <!--begin::Title-->
                <div class="flex-grow-1 me-2">
                    <a href="#" class="fw-bolder text-gray-800 text-hover-primary fs-6">غیررسمی و حقیقی</a>
                    <span class="text-muted fw-bold d-block">تعداد  {{$invoiceUnOfficialNaturalCount}}</span>
                </div>
                <!--end::Title-->
                <!--begin::Lable-->
                <span class="fw-bolder text-info py-1"> {{\App\Utilities\HString::
number2farsi(\App\Utilities\HString
::dividePrice(str_replace(",","",$invoiceUnOfficialNaturalPrice)/10))}} تومان</span>
                <!--end::Lable-->
            </div>
            <!--end::item-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::لیست Widget 6-->
</div>
