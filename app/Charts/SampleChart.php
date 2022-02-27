<?php

declare(strict_types=1);

namespace App\Charts;

use App\Models\CRM\Customer;
use App\Models\CRM\Invoice;
use App\Models\CRM\InvoiceDetail;
use App\Models\CRM\PreInvoice;
use App\Models\CRM\PreInvoiceDetail;
use App\Utilities\Jdf;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class SampleChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function returnDateId($Year, $dateFrom, $dateTo)
    {
        $result =Invoice::get()->whereBetween('date', [$Year . $dateFrom, $Year . $dateTo])->pluck('id');
     if ($result->isEmpty()) {
            return null;
        }
        return $result;
//            $totalSum = PreInvoiceDetail::whereIn('pre_invoice_id', $invoiceId)
//                ->selectRaw('SUM(count*unit_price) as total_price')
//                ->pluck('total_price')->toArray();
//            $totalSum = implode($totalSum);
//                return $totalSum;

    }

    public function sumTotalPriceMont($invoiceIds)
    {
        if ($invoiceIds !== null) {
            $totalSum= InvoiceDetail::whereIn('invoice_id', $invoiceIds)
                ->selectRaw('SUM(count*unit_price) as total_price')
                ->pluck('total_price')->first();
//            $totalSum = implode($totalSum);

            if ($totalSum==null) {
//
                return 0;
            }
            return $totalSum;
//
//
        }
        return 0;
    }

    public function handler(Request $request): Chartisan
    {
        $year = Jdf::jdate('Y');

        $mont1 = $this->returnDateId($year, "-01-01", "-01-31");
        $mont2 = $this->returnDateId($year, "-02-01", "-02-31");
        $mont3 = $this->returnDateId($year, "-03-01", "-03-31");
        $mont4 = $this->returnDateId($year, "-04-01", "-04-31");
        $mont5 = $this->returnDateId($year, "-05-01", "-05-31");
        $mont6 = $this->returnDateId($year, "-06-01", "-06-31");
        $mont7 = $this->returnDateId($year, "-07-01", "-07-31");
        $mont8 = $this->returnDateId($year, "-08-01", "-08-31");
        $mont9 = $this->returnDateId($year, "-09-01", "-09-31");
        $mont10 = $this->returnDateId($year, "-10-01", "-10-31");
        $mont11 = $this->returnDateId($year, "-11-01", "-11-31");
        $mont12 = $this->returnDateId($year, "-12-01", "-12-31");
        $monts[] = $this->sumTotalPriceMont($mont1);
        $monts[] = $this->sumTotalPriceMont($mont2);
        $monts[] = $this->sumTotalPriceMont($mont3);
        $monts[] = $this->sumTotalPriceMont($mont4);
        $monts[] = $this->sumTotalPriceMont($mont5);
        $monts[] = $this->sumTotalPriceMont($mont6);
        $monts[] = $this->sumTotalPriceMont($mont7);
        $monts[] = $this->sumTotalPriceMont($mont8);
        $monts[] = $this->sumTotalPriceMont($mont9);
        $monts[] = $this->sumTotalPriceMont($mont10);
        $monts[] = $this->sumTotalPriceMont($mont11);
        $monts[] = $this->sumTotalPriceMont($mont12);
//        $y=Customer::withCount('invoices');
//        $y=$y->get()->pluck('invoices_count','name');
//        return Chartisan::build()
//            ->labels($y->keys()->toArray())
//            ->dataset('تعداد فاکتور', $y->values()->toArray());
        return Chartisan::build()
            ->labels(['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'])
//            ->dataset('Sample', [$mont100, $mont2,$mont3 ,$mont4 ,$mont5 ,$mont6 ,$mont7 ,$mont8 ,$mont9 ,$mont10,$mont110,$mont12]);
            ->dataset('فروش ماهانه ريال', $monts );

//        return Chartisan::build()
//            ->labels([1,2,3,4,5,6,7,8,9,10,11,12])
//            ->dataset('تعداد فاکتور',1,1,1,1,1,1,1,1,1,1,1,1);
    }
}


















