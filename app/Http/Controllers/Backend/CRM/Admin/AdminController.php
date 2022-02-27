<?php

namespace App\Http\Controllers\Backend\CRM\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\CRM\Customer;
use App\Models\CRM\Invoice;
use App\Models\CRM\InvoiceDetail;
use App\Models\CRM\PreInvoice;
use App\Models\CRM\PreInvoiceDetail;
use App\Utilities\Jdf;
use App\Utilities\MessageBag;
use App\Utilities\Number2Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{


    public function index($id)
    {
        $modelUser = User::findOrFail($id);
        $invoiceCount = Invoice::where('_user_id', $id)->count();
        $preInvoiceCount = PreInvoice::where('_user_id', $id)->count();
        $customerCount = Customer::where('_user_id', $id)->count();
        $montInvoice = [];
        $montPreInvoice = [];
        $totalSumPriceInvoice = $this->resultSumPriceInvoice(Invoice::where('_user_id', $id)->get()->pluck('id'));
        $totalSumPricePreInvoice = $this->resultSumPricePreInvoice(PreInvoice::where('_user_id', $id)->get()->pluck('id'));
//        dd($totalSumPriceInvoice,$totalSumPricePreInvoice);
        if ($totalSumPricePreInvoice !== 0) {
            $nerkhTabdil = ($totalSumPriceInvoice / $totalSumPricePreInvoice) * 100;
        } else {
            $nerkhTabdil = 0;
        }

        $year = Jdf::jdate('Y');
        for ($i = 0; $i < 12; $i++) {
            $montInvoice[] = $this->DateCountInvoice($year, "-$i-01", "-$i-31", $id);
        }
        for ($i = 0; $i < 12; $i++) {
            $montPreInvoice[] = $this->DateCountInvoice($year, "-$i-01", "-$i-31", $id);
        }
//        dd($montInvoice,$montPreInvoice);
    }

    public function DateCountInvoice($Year, $dateFrom, $dateTo, $id)
    {
        return Invoice::where('_user_id', $id)->whereBetween('date', [$Year . $dateFrom, $Year . $dateTo])->count();

    }

    public function DateCountPreInvoice($Year, $dateFrom, $dateTo, $id)
    {
        return PreInvoice::where('_user_id', $id)->whereBetween('date', [$Year . $dateFrom, $Year . $dateTo])->count();

    }

    public function resultSumPriceInvoice($invoiceId)
    {
        if ($invoiceId !== null) {
            $totalSum = InvoiceDetail::whereIn('invoice_id', $invoiceId)
                ->selectRaw('SUM(count*unit_price) as total_price')
                ->pluck('total_price')->toArray();
            $totalSum = implode($totalSum);
            if ($totalSum) {
                return $totalSum;
            }
            return 0;

        }
        return 0;
    }

    public function resultSumPricePreInvoice($invoiceId)
    {
        if ($invoiceId !== null) {
            $totalSum = PreInvoiceDetail::whereIn('pre_invoice_id', $invoiceId)
                ->selectRaw('SUM(count*unit_price) as total_price')
                ->pluck('total_price')->toArray();
            $totalSum = implode($totalSum);
            if ($totalSum) {
                return $totalSum;
            }
            return 0;

        }
        return 0;
    }


}
