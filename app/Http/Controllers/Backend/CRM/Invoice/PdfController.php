<?php

namespace App\Http\Controllers\Backend\CRM\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\CRM\Customer;
use App\Models\CRM\Invoice;
use App\Models\CRM\PreInvoice;
use App\Utilities\Jdf;
use App\Utilities\MessageBag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PdfController extends Controller
{

    protected $returnDefault = 'sadmin/crm/customer';
    protected $model = \App\Models\CRM\Invoice::class;
    protected $modelDetail = \App\Models\CRM\InvoiceDetail::class;
    protected $modelName = 'مشتری';
    protected $viewFolder = 'CRM/invoice/pdf';


    public function index(Request $request)
    {
//
    }


    public function destroy($id)
    {
        //
    }

    public function create($id)
    {
        $preInvoiceDetails = $this->modelDetail::where('invoice_id', $id)->get();
        $data['details'] = $preInvoiceDetails;
        $model = $this->model::findOrFail($id);
        $totalSum = $model->totalPriceAll();
        $discount = $model->total_discount;
        $tax = $this->tax($totalSum);
        $data['totalSum'] = $totalSum;
        $customers = Customer::all();
        $data['customers'] = $customers;
        $data['model'] = $model;
        if ($model['type'] === Invoice::TYPE_RASMI) {
            $amountPayable = ($totalSum - $discount) + $tax;
        } else {
            $amountPayable = $totalSum - $discount;
            $tax = 0;
        }
        $data['tax'] = $tax;
        $data['amountPayable'] = $amountPayable;
        return view("backend.$this->viewFolder", $data);
    }

    public function tax($totalSum)
    {
        $tax = ($totalSum * 9) / 100;
        return $tax;
    }

    public function store()
    {
//
    }

    public function edit($id)
    {
//
    }

    public function update($id)
    {
//
    }

}
