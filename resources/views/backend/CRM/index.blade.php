@extends('backend.layout.main')

@section('page_title')
    داشبورد
@endsection
@section('body')

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="jquery.numberr.js"></script>
    <div class="post d-flex flex-column-fluid" id="kt_post">

        <div id="kt_content_container" class="container">
            <div class="row gy-5 g-xl-8 mb-10">
                <!--begin::Col-->
            @include('backend.CRM.reports.preInvoice')
            <!--end::Col-->
                <!--begin::Col-->
            @include('backend.CRM.reports.invoice')
            <!--end::Col-->
                <!--begin::Col-->
            @include('backend.CRM.reports.customer')
            <!--end::Col-->
            </div>
        </div>

    </div>
    <script>
        function animateValue(obj, start, end, duration) {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                obj.innerHTML = Math.floor(progress * (end - start) + start);
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }
        const preInvoiceCount = document.getElementById("preInvoiceCount");
        const invoiceCount = document.getElementById("invoiceCount");
        const customerCount = document.getElementById("customerCount");
        animateValue(customerCount, 0, {{$customerCount}}, 2000);
        animateValue(invoiceCount, 0, {{$invoiceCount}}, 2000);
        animateValue(preInvoiceCount, 0, {{$preInvoiceCount}}, 2000);
    </script>
@endsection
