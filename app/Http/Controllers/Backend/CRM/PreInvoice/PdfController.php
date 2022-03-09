<?php

namespace App\Http\Controllers\Backend\CRM\PreInvoice;

use App\Http\Controllers\Controller;
use App\Models\CRM\Customer;
use App\Models\CRM\PreInvoice;
use App\Utilities\Number2Word;


class PdfController extends Controller
{

    protected $returnDefault = 'sadmin/crm/customer';
    protected $model = \App\Models\CRM\PreInvoice::class;
    protected $modelDetail = \App\Models\CRM\PreInvoiceDetail::class;
    protected $modelName = 'مشتری';
    protected $viewFolder = 'CRM/PreInvoice/pdf';


    public function create($id)
    {
        $numToStr=new Number2Word();

        $preInvoiceDetails = $this->modelDetail::where('pre_invoice_id', $id)->get();
        $data['details'] = $preInvoiceDetails;
        $model = $this->model::findOrFail($id);
        $totalSum = $model->totalPriceAll();
        $discount = $model->total_discount;
        $tax = $this->tax($totalSum);
        $data['totalSum'] = $totalSum;
        $customers = Customer::all();
        $data['customers'] = $customers;
        $data['model'] = $model;
        if ($model['type'] === PreInvoice::TYPE_RASMI) {
            $amountPayable = ($totalSum - $discount) + $tax;
        } else {
            $amountPayable = $totalSum - $discount;
            $tax = 0;
        }
        $data['tax'] = $tax;
        $data['amountPayable'] =$amountPayable ;
        if ($amountPayable==0){
            $data['amountPayableString'] ="صفر" ;
        }else{

            $data['amountPayableString'] =$numToStr->numberToWords($amountPayable) ;
        }
        return view("backend.$this->viewFolder", $data);

    }

    public function tax($totalSum)
    {
        $tax = ($totalSum * 9) / 100;
        return $tax;
    }



}
