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

class TypeEntityChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
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



    public function handler(Request $request): Chartisan
    {
//        $totalSumPriceInvoice = $this->resultSumPriceInvoice($invoice->get()->pluck('id'));
        $invoiceOfficialNatural = $this->resultTypeAndEntityInvoiceIds(Customer::NATURAL, Invoice::TYPE_RASMI);
        $invoiceOfficialNaturalPrice = $this->resultSumPriceInvoice($invoiceOfficialNatural);
        $invoiceUnOfficialNatural = $this->resultTypeAndEntityInvoiceIds(Customer::NATURAL, Invoice::TYPE_GHEYRE_RASMI);
        $invoiceUnOfficialNaturalPrice = $this->resultSumPriceInvoice($invoiceUnOfficialNatural);
        $invoiceOfficialLegal = $this->resultTypeAndEntityInvoiceIds(Customer::LEGAL, Invoice::TYPE_RASMI);
        $invoiceOfficialLegalPrice = $this->resultSumPriceInvoice($invoiceOfficialLegal);
        $invoiceUnOfficialLegal = $this->resultTypeAndEntityInvoiceIds(Customer::LEGAL, Invoice::TYPE_GHEYRE_RASMI);
        $invoiceUnOfficialLegalPrice = $this->resultSumPriceInvoice($invoiceUnOfficialLegal);


        return Chartisan::build()
            ->labels(['رسمی و حقیقی','غیررسمی و حقیقی','رسمی و حقوقی','غیر رسمی و حقوقی'])

            ->dataset('هزینه کل فاکتورهای صادر شده برای مشتری',
                [
                    $invoiceOfficialNaturalPrice,
                    $invoiceUnOfficialNaturalPrice,
                    $invoiceOfficialLegalPrice,
                    $invoiceUnOfficialLegalPrice,
                ]);
    }
}
