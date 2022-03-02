@extends('backend.layout.main')
@section('body')
    <script src="https://unpkg.com/chart.js@^2.9.3/dist/Chart.min.js"></script>
    <script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>
    <x-backend.form.form action="{{ \App\Utilities\Url::admin('auth/user/create') }}" method="post">
        @csrf
        <x-backend.card title="جزئیات در رابطه با {{$modelUser->name}}" color="25">

            <div class="row">
                <div class="col-xl-4">
                    <!--begin::لیست Widget 4-->
                    <div class="card card-xl-stretch mb-5 mb-xl-8 ">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5 text-center">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder text-dark text-center">جزئیات در رابطه با کاربر</span>
                                {{--                <span class="text-muted mt-1 fw-bold fs-7">تت</span>--}}

                            </h3>
                            <div class="card-toolbar text-center">
                                <!--begin::Menu-->

                                <!--begin::Menu 3-->
                                <div
                                    class="menu menu-sub "
                                    data-kt-menu="true">
                                    <!--begin::Heading-->
                                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                        <span class="text-muted fw-bold d-block fs-6">نام :</span>
                                        <a class="text-gray-800 text-hover-primary fs-6 fw-bolder">{{$modelUser->name}}</a>
                                    </div>
                                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                        <span class="text-muted fw-bold d-block fs-6">ایمیل :</span>
                                        <a class="text-gray-800 text-hover-primary fs-6 fw-bolder">{{$modelUser->email}}</a>
                                    </div>
                                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                        <span class="text-muted fw-bold d-block fs-6">شناسه /کد ملی :</span>
                                        <a class="text-gray-800 text-hover-primary fs-6 fw-bolder">{{$modelUser->nationalID}}</a>
                                    </div>

                                </div>
                                <!--end::Menu 3-->
                                <!--end::Menu-->
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body pt-5">
                            <div class="d-flex align-items-sm-center mb-7">
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a class="text-gray-800 text-hover-primary fs-6 fw-bolder">    تعداد  مشتریان :</a>
                                        <span class="fw-bolder text-warning py-1">  {{$customerCount}} عدد  </span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-sm-center mb-7">
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a class="text-gray-800 text-hover-primary fs-6 fw-bolder">    تعداد  فاکتورها :</a>
                                        <span class="fw-bolder text-warning py-1">  {{$invoiceCount}} عدد  </span>
                                    </div>
                                </div>
                            </div>
                            <!--end::item-->
                            <!--begin::item-->
                            <div class="d-flex align-items-sm-center mb-7">
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a class="text-gray-800 text-hover-primary fs-6 fw-bolder">   تعداد پیش فاکتورها  :</a>
                                        <span class="fw-bolder text-warning py-1">  {{$preInvoiceCount}} عدد  </span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-sm-center mb-7">
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a class="text-gray-800 text-hover-primary fs-6 fw-bolder">  جمع کل  فاکتورها: </a>
                                        <span class="fw-bolder text-warning py-1">   {{ $totalSumPriceInvoice }} تومان  </span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-sm-center mb-7">
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a class="text-gray-800 text-hover-primary fs-6 fw-bolder">  جمع کل  فاکتورها: </a>
                                        <span class="fw-bolder text-warning py-1">   {{ $totalSumPricePreInvoice }} تومان  </span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-sm-center mb-7">
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a class="text-gray-800 text-hover-primary fs-6 fw-bolder"> نرخ تبدیل پیش فاکتور به فاکتور: </a>
                                        <span class="fw-bolder text-warning py-1">   {{ $nerkhTabdil }} درصد  </span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-sm-center mb-7">
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a class="text-gray-800 text-hover-primary fs-6 fw-bolder"> تاریخ عضویت:</a>
                                           <span dir=ltr class="fw-bolder text-warning py-1">  {{$createdTime}}   </span>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-sm-center mb-7">
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a class="text-gray-800 text-hover-primary fs-6 fw-bolder">  آخرین ورود :</a>
                                        <span  dir=ltr class="fw-bolder ltr text-warning py-1"> {{$loginTime}}   </span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-sm-center mb-7">
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a class="text-gray-800 text-hover-primary fs-6 fw-bolder"> تاریخ مسدودیت:</a>
                                        <span dir=ltr class="fw-bolder  text-warning py-1">  {{$blockedTime}}   </span>
                                    </div>
                                </div>
                            </div>



                        </div>
                        <!--end::Body-->

                    </div>

                    <!--end::لیست Widget 4-->
                </div>

                <div class="card card-xxl-stretch mb-xl-3">
                    <div class="card-header border-0">
                        <h3 class="card-title fw-bolder text-dark">نمودار میزان فعالیت ماهانه در سال جاری</h3>
                        <div id="chart" style="height: 300px;"></div>
                    </div>
                </div>

            </div>

            <x-slot name="footer">
                <button type="submit" class="btn btn-primary mr-2 px-10">
                    ثبت
                </button>
                <a href="{{ \App\Utilities\Url::admin('auth/user') }}" class="btn btn-danger">بازگشت</a>
            </x-slot>
        </x-backend.card>
    </x-backend.form.form>
    <script>

        const chart = new Chartisan({
            el: '#chart',
            url: "@chart('user_chart')",
            hooks: new ChartisanHooks()
                // .colors()
                .responsive()
                .beginAtZero()

                .colors()
                .datasets([{type: 'line', fill: false, borderColor: 'rgba(33, 135, 236 )'}, {type:'line', fill: false, borderColor: 'rgba(246, 157, 67)'} ]),

        });

    </script>
@endsection
