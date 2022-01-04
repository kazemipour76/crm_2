<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta
        id="vp"
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <title>فاکتور فروش</title>
    <style>
        html, body {
            /*font-family:Tahoma, Geneva, sans-serif;*/
            /*font-size:12px;*/
            /*direction:rtl;*/
            /*margin:0;*/
            /*padding:0;*/
            height: 287mm !important;
        }

        .wrapper {
            min-height: 274mm !important;
            /*height:auto;*/
            /*margin:0 auto -50px auto;*/
        }

        .footer, .wrapper:after {
            width: 100%;
            height: 1px;
            background-color: #369;
        }

        .wrapper:after {
            content: "";
            /*display:block;*/
            background-color: #ffffff;
        }

        hr {
            border: 0;
            border-bottom: 1px dashed #CCC;
        }

        @font-face {
            font-family: 'Libre Barcode 128';
            font-style: normal;
            font-weight: 200;
            src: local('Libre Barcode 128 Regular'), local('LibreBarcode128-Regular'), url(https://www.digikala.com/static/files/87c6c4b6.ttf) format('truetype');
        }
    </style>
    <style>
        html, body {
            padding: 0;
            margin: 0 auto;
            max-width: 200mm;
            -webkit-print-color-adjust: exact;
        }

        body {
            padding: 0.5cm
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        table {
            width: 100%;
            table-layout: fixed;
            border-spacing: 0;
        }

        .header-table {
            table-layout: fixed;
            border-spacing: 0;
        }

        .header-table td {
            padding: 0;
            vertical-align: top;
        }

        body {
            font: 9pt IRANYekanWeb;
            direction: rtl;
        }

        .print-button {
            cursor: pointer;
            -webkit-box-shadow: none;
            box-shadow: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            display: -webkit-inline-box;
            display: -ms-inline-flexbox;
            display: inline-flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            border-radius: 5px;
            background: none;
            -webkit-transition: all .3s ease-in-out;
            transition: all .3s ease-in-out;
            position: relative;

            outline: none;
            text-align: center;

            padding: 8px 16px;
            font-size: 12px;
            font-size: .857rem;
            line-height: 1.833;
            font-weight: 700;
            background-color: #0fabc6;
            color: #fff;
            border: 1px solid #0fabc6;
        }

        .page {
            background: white;
            page-break-after: always;
        }

        .flex {
            display: flex;
        }

        .flex > * {
            float: left;
        }

        .flex-grow {
            flex-grow: 10000000;
        }

        .barcode {
            text-align: center;
            margin: 12px 0 0 0;
            /*height: 30px;*/
        }

        .barcode span {
            font-size: 35pt;
            font-family: 'Libre Barcode 128';
        }

        .portait {
            transform: rotate(-90deg) translate(0, 40%);
            text-align: center;
        }

        .header-item-wrapper {
            border: 1px solid #000;
            width: 100%;
            /*height: 100%;*/
            background: #eee;
            display: flex;
            align-content: center;
        }

        thead, tfoot {
            background: #eee;
        }

        .header-item-data {
            /*height: 100%;*/
            width: 100%;
        }

        .bordered {
            border: 1px solid #000;
            padding: 0.12cm;
        }

        .header-table table {
            width: 100%;
            vertical-align: middle;
        }

        .content-table {
            border-collapse: collapse;
        }

        .content-table td, th {
            border: 1px solid #000;
            text-align: center;
            padding: 0.1cm;
            font-weight: 200;
            font-family: "2  Baran";
            font-size: 9pt;
        }

        table.centered td {
            vertical-align: middle;
        }

        .serials {
            direction: ltr;
            text-align: left;
        }

        .title {
            text-align: right;
        }

        .grow {
            width: 100%;
            /*height: 100%;*/
        }

        .font-small {
            font-size: 8pt;
        }

        .font-medium {
            font-size: 10pt;
        }

        .font-big {
            font-size: 15pt;
        }

        .label {
            font-weight: bold;
            padding: 0 0 0 2px;
        }

        @page {
            size: A4 ;
            margin: 0;
            margin-bottom: 0.5cm;
            margin-top: 0.5cm;
        }

        .ltr {
            direction: ltr;
            display: block;
        }

        @media print {
            .print-button {
                display: none;
                visibility: hidden;
            }
        }
    </style>
</head>
<body>
<button class="print-button" id="print-button">پرینت</button>
<div class=" wrapper">

    <table class="header-table" style=" border-collapse:collapse; width: 100%">
        <tr>
            <td colspan="4">
                <b><img width="80px" height="80px" src="{{ asset('storage/img.png') }}"></b>

            </td>
            <td colspan="4" style="text-align: center; padding-top: 27px ;font-size: 14pt">
                <b>شرکت یکتا تجهیز صیانت علیرضا</b>
            </td>
            <td colspan="4" style="text-align: left; padding-top: 27px;font-size: 14pt;color: #0a6aa1">
                <b>YEKTA TAJHIZ</b>
            </td>

        </tr>

        <tr>
            <th colspan="7" style=" text-align: right ;padding-right: 20px; font-size: 10pt">
                @if($model->status)
                    پیش فاکتور
                @else
                    فاکتور
                @endif
                <br>
                {{$model->title}}
            </th>
            <th colspan="5" style=" text-align: right ;padding-right: 20px; font-size: 10pt">تاریخ: {{$model->date}}
                <br>
                شماره: A{{$model->id}}

            </th>

        </tr>
        <tr style="">
            <th colspan="1" style="border-collapse:collapse; text-align: right ;padding-right: 20px">
                مشخصات
            </th>
            <th colspan="6" style="border-collapse:collapse; height: 60px; text-align: right ;padding-right: 20px">
                <span class="label">مشتری:</span> {{$model->Customer->name}}
                <br>
                <span class="label">شماره‌اقتصادی :</span>
                {{$model->Customer->economicID}}
                <br>
                <span class="label">شناسه ملی:</span>
                {{$model->Customer->nationalID}}
                <br>
                <span class="label">نشانی:</span>

                {{$model->Customer->address}}
                <br>
                <span class="label">شماره تماس:</span>

                {{$model->Customer->phone}}
                <br>
                <span class="label">کد پستی:</span>

            </th>
            <th colspan="5" style="height: 60px; text-align: right ;padding-right: 20px">
                <span class="label">مشتری:</span> {{$model->Customer->name}}
                <br>
                <span class="label">شماره‌اقتصادی :</span>
                {{$model->Customer->economicID}}
                <br>
                <span class="label">شناسه ملی:</span>
                {{$model->Customer->nationalID}}
                <br>
                <span class="label">نشانی:</span>

                {{$model->Customer->address}}
                <br>
                <span class="label">شماره تماس:</span>

                {{$model->Customer->phone}}
                <br>
                <span class="label">کد پستی:</span>

            </th>

        </tr>
    </table>
    <table class="content-table ">
        <thead>
        <tr>
            <th colspan="1">ردیف</th>
            <th colspan="3">نام کالا یا خدمات</th>
            <th colspan="1">تعداد</th>
            <th colspan="1">واحد</th>
            <th colspan="3">مبلغ واحد (ریال)</th>
            <th colspan="3">مبلغ کل (ریال)</th>

        </tr>
        </thead>
        @foreach($details as $detail)
        <tr style="height: auto;font-size: 12px">
            <td colspan="1" style="">۱</td>
            <td colspan="3">

                {{$detail->product_name}}

            </td>
            <td colspan="1">
                {{--                {{$model->title}}--}}
                {{$detail->count}}

            </td>

            <td colspan="1">
                <span class="ltr">
{{--                    {{$model->title}}--}}
                    عدد
                   </span>
            </td>

            <td colspan="3">
                <span class="ltr">

                    {{\App\Utilities\HString::number2farsi(\App\Utilities\HString::dividePrice($detail->unit_price))}}
                </span>
            </td>
            <td colspan="3">
                <span class="ltr">
                    {{\App\Utilities\HString::number2farsi(\App\Utilities\HString::dividePrice($detail->totalPrice()))}}
                </span>
            </td>
        </tr>
        @endforeach
        <tr>
            <td colspan="4">
                <b>جمع کل (ریال)</b>
            </td>
            <td colspan="8" style="text-align: left ;padding-left: 10px;font-size: 11pt">
                <b>{{\App\Utilities\HString::number2farsi(\App\Utilities\HString::dividePrice($totalSum))}}</b>
            </td>

        </tr>
        <tr>
            <td colspan="4">
                <b> مالیات بر ارزش افزوده (ریال)ل</b>
            </td>
            <td colspan="8" style="text-align: left ;padding-left: 10px;font-size: 11pt">
                <b>{{\App\Utilities\HString::number2farsi(\App\Utilities\HString::dividePrice($tax))}}</b>
            </td>

        </tr>
        @if($model->total_discount)
            <tr>
                <td colspan="4">
                    <b> تخفیف (ریال)</b>
                </td>
                <td colspan="8" style="text-align: left ;padding-left: 10px;font-size: 11pt">
                    <b>{{\App\Utilities\HString::number2farsi(\App\Utilities\HString::dividePrice($model->total_discount))}}</b>
                </td>
            </tr>
        @endif
        <tr>
            <td colspan="4">
                <b>مبلغ قابل پرداخت (ریال)</b>
            </td>
            <td colspan="8"style="text-align: left ;padding-left: 10px;font-size: 12pt">
                <b>{{\App\Utilities\HString::number2farsi(\App\Utilities\HString::dividePrice($amountPayable))}}</b>
            </td>
        </tr>

        <tr>
            <td colspan="12" style=" border: none; background-color: #FFFFFF ">
                <div class="flex">
                    <div class="flex-grow " style="text-align: center;bottom: 0;">
                        @if($model->description)
                            <h3>
                                {{$model->description}}
                            </h3>
                        @endif
                    </div>

                </div>
                <span class="ltr" style="text-align: left;padding-left:40px; font-family:'2  Baran'; font-size: 20px">
                  امضاء و مهر شرکت
                                        </span>
            </td>
        </tr>
    </table>
</div>

<div class=" footer " style=" text-align: center">
    امضاء و مهر شرکت
    {{--        <img class="footer-img uk-align-center " width="150px" height="30px"--}}
    {{--             src="https://www.digikala.com/static/files/acb0d08c.jpg"/>--}}
</div>
</body>


<script>
    var printButton = document.getElementById('print-button');
    printButton.addEventListener('click', function () {
        window.print();
    })


    window.onload = function () {
        try {
            // var isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
            //
            // if(!isSafari) {
            //     return;
            // }

            if (screen.width >= 300 && screen.width < 500) {
                var mvp = document.getElementById('vp');
                mvp.setAttribute('content', 'initial-scale=0.35,width=device-width');
            } else if (screen.width > 500 && screen.width < 600) {
                var mvp = document.getElementById('vp');
                mvp.setAttribute('content', 'initial-scale=0.6,width=device-width');
            } else if (screen.width > 600 && screen.width < 700) {
                var mvp = document.getElementById('vp');
                mvp.setAttribute('content', 'initial-scale=0.7,width=device-width');
            }

        } catch (e) {

        }
    }
</script>
</html>
