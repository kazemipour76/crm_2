@extends('backend.layout.main')
@section('body')
    <div class="row">
        <div class="col-lg-6">
            <x-backend.form.form action="{{ \App\Utilities\Url::admin('crm/invoice/create') }}" method="post">
                @csrf
                <x-backend.card title="ایجاد  فاکتور جدید" color="17">
                    <div class="row ">

                        <div class="col-lg-6">
                            <x-backend.form.form-group title="نام مشتری">
                                <x-backend.form.select2 name="customer_id">
                                    @foreach($customers as $item)
                                        <option value="{{$item->id}}">
                                            {{$item->name}}
                                        </option>
                                    @endforeach
                                </x-backend.form.select2>
                            </x-backend.form.form-group>
                        </div>

                        <div class="col-lg-6 mt-8 mb-3">
                            <x-backend.form.form-group title="نوع :" isInline="true">
                                <x-backend.form.radio-inline>
                                    <x-backend.form.radio title="غیر رسمی" name="type"
                                                          value="{{\App\Models\CRM\Invoice::TYPE_GHEYRE_RASMI}}"
                                                          checked="{{\App\Models\CRM\Invoice::TYPE_GHEYRE_RASMI||!old('type') ? 'checked' : ''}}"

                                    />

                                    <x-backend.form.radio title="رسمی" name="type"
                                                          value="{{\App\Models\CRM\Invoice::TYPE_RASMI}}"
                                                          checked="{{\App\Models\CRM\Invoice::TYPE_RASMI||!old('type') ? 'checked' : ''}}"
                                    />
                                </x-backend.form.radio-inline>
                            </x-backend.form.form-group>
                        </div>
                        {{--                        <div class="col-lg-6">--}}
                        {{--                            <x-backend.form.form-group title="تاریخ">--}}
                        {{--                                <x-backend.form.datepicker name="created_at" :value="old('date_from')"/>--}}
                        {{--                            </x-backend.form.form-group>--}}
                        {{--                        </div>--}}


                    </div>

                    <x-slot name="footer">
                        <button type="submit" class="btn btn-primary mr-2 px-10">
                            ثبت
                        </button>
                        <a href="{{ \App\Utilities\Url::admin('crm/preInvoice') }}" class="btn btn-danger">بازگشت</a>
                    </x-slot>
                </x-backend.card>
            </x-backend.form.form>
        </div>
    </div>
@endsection
{{--@push('script')--}}
{{--    <script>--}}
{{--        $(function () {--}}
{{--            $("#checkAll").click(function () {--}}
{{--                $(".check").prop('checked', $(this).prop('checked'));--}}
{{--            });--}}
{{--        });--}}
{{--        jalaliDatepicker.startWatch();--}}
{{--    </script>--}}
{{--@endpush--}}

{{--@extends('backend.layout.main')--}}

{{--@section('page_title')--}}
{{--    داشبورد--}}
{{--@endsection--}}
{{--@section('body')--}}

{{--    <script src="https://unpkg.com/chart.js@^2.9.3/dist/Chart.min.js"></script>--}}
{{--    <script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>--}}

{{--    --}}{{--    <script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>--}}
{{--    --}}{{--    <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>--}}
{{--    <div class="post d-flex flex-column-fluid" id="kt_post">--}}

{{--        <div id="kt_content_container" class="container">--}}

{{--            <div class="row gy-5 gx-xl-8">--}}
{{--                <div class="col-xxl-4">--}}
{{--                    <div class="card card-xxl-stretch mb-xl-3">--}}
{{--                        <div class="card-header border-0">--}}
{{--                            <h3 class="card-title fw-bolder text-dark"> نمودار هزینه کل فاکتور به صورت ماهیانه</h3>--}}
{{--                            <div id="chart" style="height: 300px;"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="card card-xxl-stretch mb-xl-3">--}}

{{--                        <div class="card-header border-0">--}}
{{--                            <h3 class="card-title fw-bolder text-dark"> میزان قیمت هر فاکتور بر اساس مشتری</h3>--}}
{{--                            <div id="chart1" style="height: 300px;"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="card card-xxl-stretch mb-xl-3">--}}
{{--                        <div class="card-header border-0">--}}
{{--                            <h3 class="card-title fw-bolder text-dark">  فاکتورهای  صادر شده  بر اساس مشتری</h3>--}}
{{--                            <div id="chart3" style="height: 300px;"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="card card-xxl-stretch mb-xl-3">--}}
{{--                    <div class="card-header border-0">--}}
{{--                            <h3 class="card-title fw-bolder text-dark">  میزان فروش هر فاکتور بر اساس نوع فاکتور و نوع مشتری  </h3>--}}
{{--                            <div id="chart2" style="height: 300px;"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}

{{--    </div>--}}
{{--    </div>--}}

{{--    <script>--}}
{{--        const chart = new Chartisan({--}}
{{--            el: '#chart',--}}
{{--            url: "@chart('sample_chart')",--}}
{{--            hooks: new ChartisanHooks()--}}
{{--                // .colors()--}}
{{--                .responsive()--}}
{{--                .beginAtZero()--}}

{{--                .colors()--}}
{{--                .datasets([{--}}

{{--                    type: 'line', fill: false, borderColor: 'rgba(72,61,139)'--}}
{{--                }, 'bar']),--}}
{{--        });--}}

{{--        const chart1 = new Chartisan({--}}
{{--            el: '#chart1',--}}
{{--            url: "@chart('invoice_chart')",--}}
{{--            hooks: new ChartisanHooks()--}}
{{--                // .colors()--}}
{{--                // .responsive()--}}
{{--                .responsive()--}}
{{--                .beginAtZero()--}}
{{--                .colors()--}}
{{--                .datasets([{--}}

{{--                    type: 'bar', fill: false, backgroundColor: 'rgba(60,179,113)'--}}
{{--                }, 'bar']),--}}
{{--        });--}}

{{--        const chart2 = new Chartisan({--}}
{{--            el: '#chart2',--}}
{{--            url: "@chart('type_entity_chart')",--}}

{{--            hooks: new ChartisanHooks()--}}
{{--                .datasets('pie')--}}
{{--                .pieColors(),--}}
{{--        });--}}
{{--        const chart3 = new Chartisan({--}}
{{--            el: '#chart3',--}}
{{--            url: "@chart('test_chart')",--}}

{{--            hooks: new ChartisanHooks()--}}
{{--                // .colors()--}}
{{--                // .responsive()--}}
{{--                .responsive()--}}
{{--                .beginAtZero()--}}
{{--                .colors()--}}
{{--                .datasets([{--}}
{{--                    type: 'bar', fill: false, backgroundColor: 'rgba(139,0,139)'--}}
{{--                }, 'bar']),--}}
{{--        });--}}

{{--    </script>--}}
{{--@endsection--}}

