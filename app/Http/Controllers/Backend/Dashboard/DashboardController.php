<?php

namespace App\Http\Controllers\Backend\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\CRM\Customer;
use App\Models\CRM\Invoice;
use App\Models\CRM\InvoiceDetail;
use App\Models\CRM\PreInvoice;
use App\Models\CRM\PreInvoiceDetail;
use App\Utilities\NumToWord;
use Chartisan\PHP\Chartisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class DashboardController extends Controller
{

//    public $preInvoice;
    public $data;
    public $customer;


        public function index()
    {


        $customer = Customer::get();
        $this->customer = $customer;
        $preInvoice = PreInvoice::orderBy('id');
        $invoice = Invoice::orderBy('id');

        //------------------------invoices------------------------

        $totalSumPriceInvoice = $this->resultSumPriceInvoice($invoice->get()->pluck('id'));
        $invoiceOfficialNatural = $this->resultTypeAndEntityInvoiceIds(Customer::NATURAL, Invoice::TYPE_RASMI);
        $invoiceOfficialNaturalPrice = $this->resultSumPriceInvoice($invoiceOfficialNatural);
        $invoiceUnOfficialNatural = $this->resultTypeAndEntityInvoiceIds(Customer::NATURAL, Invoice::TYPE_GHEYRE_RASMI);
        $invoiceUnOfficialNaturalPrice = $this->resultSumPriceInvoice($invoiceUnOfficialNatural);
        $invoiceOfficialLegal = $this->resultTypeAndEntityInvoiceIds(Customer::LEGAL, Invoice::TYPE_RASMI);
        $invoiceOfficialLegalPrice = $this->resultSumPriceInvoice($invoiceOfficialLegal);
        $invoiceUnOfficialLegal = $this->resultTypeAndEntityInvoiceIds(Customer::LEGAL, Invoice::TYPE_GHEYRE_RASMI);
        $invoiceUnOfficialLegalPrice = $this->resultSumPriceInvoice($invoiceUnOfficialLegal);

        //------------------------preInvoices------------------------

        $totalSumPricePreInvoice = $this->resultSumPricePreInvoice($preInvoice->get()->pluck('id'));
        $preInvoiceOfficialNatural = $this->resultTypeAndEntityPreInvoiceIds(Customer::NATURAL, PreInvoice::TYPE_RASMI);
        $preInvoiceOfficialNaturalPrice = $this->resultSumPricePreInvoice($preInvoiceOfficialNatural);
        $preInvoiceUnOfficialNatural = $this->resultTypeAndEntityPreInvoiceIds(Customer::NATURAL, PreInvoice::TYPE_GHEYRE_RASMI);
        $preInvoiceUnOfficialNaturalPrice = $this->resultSumPricePreInvoice($preInvoiceUnOfficialNatural);
        $preInvoiceOfficialLegal = $this->resultTypeAndEntityPreInvoiceIds(Customer::LEGAL, PreInvoice::TYPE_RASMI);
        $preInvoiceOfficialLegalPrice = $this->resultSumPricePreInvoice($preInvoiceOfficialLegal);
        $preInvoiceUnOfficialLegal = $this->resultTypeAndEntityPreInvoiceIds(Customer::LEGAL, PreInvoice::TYPE_GHEYRE_RASMI);
        $preInvoiceUnOfficialLegalPrice = $this->resultSumPricePreInvoice($preInvoiceUnOfficialLegal);

        //------------------------customer------------------------

        $invoiceLegalId = $this->resultInvoiceIds(Customer::LEGAL);
        $invoiceNaturalId = $this->resultInvoiceIds(Customer::NATURAL);
        $totalSumLegal = $this->resultSumPriceInvoice($invoiceLegalId);
        $totalSumNatural = $this->resultSumPriceInvoice($invoiceNaturalId);

        $this->data = [
            //------------------------invoices------------------------

            'invoiceOfficialNaturalCount' => $invoiceOfficialNatural == null ? 0 : $invoiceOfficialNatural->count(),
            'invoiceOfficialNaturalPrice' => $invoiceOfficialNaturalPrice,
            'invoiceUnOfficialNaturalCount' => $invoiceUnOfficialNatural == null ? 0 : $invoiceUnOfficialNatural->count(),
            'invoiceUnOfficialNaturalPrice' => $invoiceUnOfficialNaturalPrice,
            'invoiceOfficialLegalCount' => $invoiceOfficialLegal == null ? 0 : $invoiceOfficialLegal->count(),
            'invoiceOfficialLegalPrice' => $invoiceOfficialLegalPrice,
            'invoiceUnOfficialLegalCount' => $invoiceUnOfficialLegal == null ? 0 : $invoiceUnOfficialLegal->count(),
            'invoiceUnOfficialLegalPrice' => $invoiceUnOfficialLegalPrice,
            'totalSumPriceInvoice' => $totalSumPriceInvoice,
            'invoiceCount' => $invoice->whereHas('details', function ($q) {
            })->count(),

            //------------------------preInvoices------------------------

            'preInvoiceOfficialNaturalCount' => $preInvoiceOfficialNatural == null ? 0 : $preInvoiceOfficialNatural->count(),
            'preInvoiceOfficialNaturalPrice' => $preInvoiceOfficialNaturalPrice,
            'preInvoiceUnOfficialNaturalCount' => $preInvoiceUnOfficialNatural == null ? 0 : $preInvoiceUnOfficialNatural->count(),
            'preInvoiceUnOfficialNaturalPrice' => $preInvoiceUnOfficialNaturalPrice,
            'preInvoiceOfficialLegalCount' => $preInvoiceOfficialLegal == null ? 0 : $preInvoiceOfficialLegal->count(),
            'preInvoiceOfficialLegalPrice' => $preInvoiceOfficialLegalPrice,
            'preInvoiceUnOfficialLegalCount' => $preInvoiceUnOfficialLegal == null ? 0 : $preInvoiceUnOfficialLegal->count(),
            'preInvoiceUnOfficialLegalPrice' => $preInvoiceUnOfficialLegalPrice,
            'totalSumPricePreInvoice' => $totalSumPricePreInvoice,
            'preInvoiceCount' => $preInvoice->whereHas('details', function ($q) {
            })->count(),

            //------------------------customer------------------------

            'customerCount' => $customer->count(),
            'totalSumNatural' => $totalSumNatural,
            'totalSumLegal' => $totalSumLegal,
            'entityNatural' => $customer->where('entity', Customer::NATURAL)->count(),
            'entityLegal' => $customer->where('entity', Customer::LEGAL)->count(),
        ];
//        dd($this->data['invoiceOfficialNaturalCount']);

        return view('backend.CRM.index', $this->data);
    }

    public function handler(Request $request): Chartisan
    {
        $y = Customer::withCount('invoices');
        $y = $y->get()->pluck('invoices_count', 'name');
        return Chartisan::build()
            ->labels($y->keys()->toArray())
            ->dataset('Sample', $y->values()->toArray());
    }

    public $entity;

    public function resultInvoiceIds($entity)
    {
        $this->entity = $entity;
        return Invoice::orderBy('id')->whereHas('customer', function ($q) {
            $q->where('entity', $this->entity);
        })->pluck('id');

    }

    public function resultTypeAndEntityInvoiceIds($entity, $type)
    {
        $this->entity = $entity;
        $result = Invoice::orderBy('id')->where('type', $type)->whereHas('customer', function ($q) {
            $q->where('entity', $this->entity);
        })->pluck('id');
        if ($result->isEmpty()) {
            return null;
        }
        return $result;
    }

    public function resultTypeAndEntityPreInvoiceIds($entity, $type)
    {
        $this->entity = $entity;
        $result = PreInvoice::orderBy('id')->where('type', $type)->whereHas('customer', function ($q) {
            $q->where('entity', $this->entity);
        })->pluck('id');
        if ($result->isEmpty()) {
            return null;
        }
        return $result;
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

    public function chart(User $user)
    {
        if (!Gate::allows('isSpecial', $user)) {
            abort(403, 'این بخش از سایت مخصوص کاربران ویژه می باشد');
        }

        return view('backend/CRM/chart_reports/index');
    }
}

