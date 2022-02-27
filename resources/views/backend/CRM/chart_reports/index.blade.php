@extends('backend.layout.main')

@section('page_title')
    داشبورد
@endsection
@section('body')

    <script src="https://unpkg.com/chart.js@^2.9.3/dist/Chart.min.js"></script>
    <script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>

    {{--    <script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>--}}
    {{--    <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>--}}
    <div class="post d-flex flex-column-fluid" id="kt_post">

        <div id="kt_content_container" class="container">

            <div class="row gy-5 gx-xl-8">
                <div class="col-xxl-4">
                    <div class="card card-xxl-stretch mb-xl-3">
                        <div class="card-header border-0">
                            <h3 class="card-title fw-bolder text-dark"> نمودار هزینه کل فاکتور به صورت ماهیانه</h3>
                            <div id="chart" style="height: 300px;"></div>
                        </div>
                    </div>
                    <div class="card card-xxl-stretch mb-xl-3">

                        <div class="card-header border-0">
                            <h3 class="card-title fw-bolder text-dark"> میزان قیمت هر فاکتور بر اساس مشتری</h3>
                            <div id="chart1" style="height: 300px;"></div>
                        </div>
                    </div>
                    <div class="card card-xxl-stretch mb-xl-3">
                        <div class="card-header border-0">
                            <h3 class="card-title fw-bolder text-dark">  فاکتورهای  صادر شده  بر اساس مشتری</h3>
                            <div id="chart3" style="height: 300px;"></div>
                        </div>
                    </div>
                    <div class="card card-xxl-stretch mb-xl-3">
                        <div class="card-header border-0">
                            <h3 class="card-title fw-bolder text-dark">  میزان فروش هر فاکتور بر اساس نوع فاکتور و نوع مشتری  </h3>
                            <div id="chart2" style="height: 300px;"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    </div>
    </div>

    <script>
        const chart = new Chartisan({
            el: '#chart',
            url: "@chart('sample_chart')",
            hooks: new ChartisanHooks()
                // .colors()
                .responsive()
                .beginAtZero()

                .colors()
                .datasets([{

                    type: 'line', fill: false, borderColor: 'rgba(72,61,139)'
                }, 'bar']),
        });

        const chart1 = new Chartisan({
            el: '#chart1',
            url: "@chart('invoice_chart')",
            hooks: new ChartisanHooks()
                // .colors()
                // .responsive()
                .responsive()
                .beginAtZero()
                .colors()
                .datasets([{

                    type: 'bar', fill: false, backgroundColor: 'rgba(60,179,113)'
                }, 'bar']),
        });

        const chart2 = new Chartisan({
            el: '#chart2',
            url: "@chart('type_entity_chart')",

            hooks: new ChartisanHooks()
                .datasets('pie')
                .pieColors(),
        });
        const chart3 = new Chartisan({
            el: '#chart3',
            url: "@chart('test_chart')",

            hooks: new ChartisanHooks()
                // .colors()
                // .responsive()
                .responsive()
                .beginAtZero()
                .colors()
                .datasets([{
                    type: 'bar', fill: false, backgroundColor: 'rgba(139,0,139)'
                }, 'bar']),
        });

    </script>
@endsection

