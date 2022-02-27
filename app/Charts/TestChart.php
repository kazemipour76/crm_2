<?php

declare(strict_types=1);

namespace App\Charts;

use App\Models\CRM\Customer;
use App\Models\CRM\PreInvoice;
use App\Models\CRM\PreInvoiceDetail;
use App\Utilities\Jdf;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class TestChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */

    public function handler(Request $request): Chartisan
    {
        $y=Customer::withCount('invoices');
        $y=$y->get()->pluck('invoices_count','name');
        return Chartisan::build()
            ->labels($y->keys()->toArray())
            ->dataset('تعداد فاکتور', $y->values()->toArray());
    }
}


















