<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Models\CRM\Customer;
use App\Models\CRM\Invoice;
use App\Models\CRM\InvoiceDetail;
use App\Models\CRM\PreInvoice;
use App\Models\CRM\PreInvoiceDetail;
use App\Scopes\UserScope;
use App\Utilities\Jdf;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class UserChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
 public $id;


    public function handler(Request $request): Chartisan
    {

        $this->id= $request->session()->get('id');

        $montInvoice = [];
        $montPreInvoice = [];
        $year = Jdf::jdate('Y');
        $mont = Jdf::jdate('m');
        for ($i = 1; $i <=$mont; $i++) {
            $montInvoice[] = $this->DateCountInvoice($year, "-$i-01", "-$i-31", \request('id'));
        }
        for ($i = 1; $i <=$mont; $i++) {
            $montPreInvoice[] = $this->DateCountPreInvoice($year, "-$i-01", "-$i-31",\request('id') );
        }
        return Chartisan::build()
            ->labels(['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'])
            ->dataset('فاکتورها ', $montInvoice )
            ->dataset('پیش فاکتورها', $montPreInvoice );

    }


public function DateCountInvoice($Year, $dateFrom, $dateTo, $id)
{
    return Invoice::withoutGlobalScope(UserScope::class)->where('_user_id', $this->id)->whereBetween('date', [$Year . $dateFrom, $Year . $dateTo])->count();
//    return 5;

}

public function DateCountPreInvoice($Year, $dateFrom, $dateTo, $id)
{
    return PreInvoice::withoutGlobalScope(UserScope::class)->where('_user_id', $this->id)->whereBetween('date', [$Year . $dateFrom, $Year . $dateTo])->count();
}
}
