<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Models\CRM\Customer;
use App\Models\CRM\Invoice;
use App\Models\CRM\InvoiceDetail;
use App\Models\CRM\PreInvoice;
use App\Models\CRM\PreInvoiceDetail;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class InvoiceChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */

    public function handler(Request $request): Chartisan
    {
        $result = Customer::orderBy('id')->pluck('id');
        foreach ($result as $x)
        {
            $totalSum = Invoice::orderBy('id')->where('customer_id',$x)->whereHas('details', function ($q) {
            })->pluck('id');
            $totalSum1[]= InvoiceDetail::whereIn('invoice_id', $totalSum)
                ->selectRaw('SUM(count*unit_price) as total_price')
                ->pluck('total_price')->first();


        }

        $y=Customer::withCount('invoices');
        $y=$y->get()->pluck('invoices_count','name');
        return Chartisan::build()
            ->labels($y->keys()->toArray())

            ->dataset('هزینه کل فاکتورهای صادر شده برای مشتری', $totalSum1);
    }
}
