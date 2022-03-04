<?php

namespace App\Http\Controllers\Backend\CRM\Invoice;

use App\Http\Controllers\Controller;
use App\Models\CRM\Customer;
use App\Models\CRM\Invoice;
use App\Models\CRM\InvoiceDetail;
use App\Models\CRM\PreInvoice;
use App\Utilities\Jdf;
use App\Utilities\MessageBag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class InvoiceController extends Controller
{
    protected $modelPreInvoice = \App\Models\CRM\PreInvoice::class;
//    protected $modelInvoice = \App\Models\CRM\Invoice::class;
    protected $modelPreInvoiceDetail = \App\Models\CRM\PreInvoiceDetail::class;
//    protected $modelInvoiceDetail = \App\Models\CRM\InvoiceDetail::class;
    protected $returnDefault = 'sadmin/crm/invoice';
    protected $model = \App\Models\CRM\Invoice::class;
    protected $modelDetail = \App\Models\CRM\InvoiceDetail::class;
    protected $modelName = '';
    protected $modelNameDetail = 'یک آیتم';
    protected $viewFolder = 'CRM/invoice';
    protected $isInvoice = false;

    public function filter()
    {
//        $model = $this->model::OrderBy('id')->withTrashed();
        $model = $this->model::OrderBy('id');
        $filter = request()->all();
//
//        if (!empty($filter['term'])) {
//            $model->search($filter['term']);
//        }

        $details = InvoiceDetail::orderBy('id');
        if (!empty($filter['term'])) {

            request()->validate(Invoice::getValidationFullTextSearch());

            $model->search($filter['term']);
            if ($details->search($filter['term'])) {
                $preInvoiceIds = $details->get()->pluck('pre_invoice_id')->toArray();
                $model->orWhereIn('id', $preInvoiceIds);
            }
        }

        $date_type = '';
        if (isset($filter['date_type'])) {
            $date_type = $filter['date_type'];
        }
        if (isset($filter['type'])) {
            $unOfficial="unOfficial";
            $official="official";
            if ($filter['type']==$unOfficial){
                $model->where('type', Invoice::TYPE_GHEYRE_RASMI);
            }elseif($filter['type']==$official){
                $model->where('type', Invoice::TYPE_RASMI);
            }
        }

        if (isset($filter['date_from'])) {
            request()->validate(Invoice::getValidationSearchDateFrom());

            $date = explode('/', $filter['date_from']);
            $gdate = Jdf::jalali_to_gregorian($date[0], $date[1], $date[2], '-') . ' 00:00:00';
            $model->where($date_type, '>=', $gdate);
        }

        if (isset($filter['date_to'])) {
            request()->validate(Invoice::getValidationSearchDateTo());

            $date = explode('/', $filter['date_to']);
            $gdate = Jdf::jalali_to_gregorian($date[0], $date[1], $date[2], '-') . ' 23:59:59';
            $model->where($date_type, '<=', $gdate);
        }
        if (isset($filter['customer']) && $filter['customer'] > 0) {
            $model->where('customer_id', '=', $filter['customer']);
        }
        if (isset($filter['perInvoiceNumber'])) {

            $x = \App\Utilities\HString::number2en($filter['perInvoiceNumber']);
            $filter['perInvoiceNumber'] = preg_replace("/[^0-9 ]/", '', $x);
            request()->validate(Invoice::getValidationSearchNumber());
            $model->where('id', '=', $filter['perInvoiceNumber']);
        }
        if (isset($filter['title'])) {

            request()->validate(Invoice::getValidationSearchTitle());
            $model->where('title', '=', $filter['title']);
        }

        if (isset($filter['economicID'])) {
            request()->validate(Invoice::getValidationeconomicID());
            $x = \App\Utilities\HString::number2en($filter['economicID']);
            $filter['economicID'] = preg_replace("/[^0-9 ]/", '', $x);
            $customerID = Customer::orderBy('id');
            $economicID=  $customerID->where('economicID', $filter['economicID'])->get()->pluck('id');
            $model->orWhereIn('customer_id', $economicID );
        }


        return $model;
    }


    public function index(Request $request)
    {
        $models = $this->filter()->paginate(request('perPage', 5));
        $old = \Request::flash($models);
        $old = \Request::old($old);
        $data = [
            'models' => $models,
            'old' => $old,
        ];

        return view("backend.{$this->viewFolder}.list", $data);
    }


    public function destroy($id)
    {
        $model = $this->model::findOrFail($id);
        $idPreInvoice = $model->PreInvoice->id;

        if (isset($model['pre_invoice_id'])) {
            $preInvoice = $this->modelPreInvoice::findOrFail($idPreInvoice);
            $preInvoice->status = 1;
            $preInvoice->save();
        }
        $this->deleteAction([$id]);
        return redirect($this->returnDefault);
    }

    public function create()
    {
        $customers = Customer::all();
//        $preInvoice= $this->model::all();
        $data['customers'] = $customers;

//        $data['preInvoice'] = $preInvoice;
        return view("backend.{$this->viewFolder}.create", $data);
    }

    public function store(Request $request)
    {
        $model = new $this->model;
        $model['date']=Jdf::jdate('Y/m/d');
        $model['_user_id']=Auth::id();
        $model->fill(request()->all());
        if ($model->save()) {
            MessageBag::push($this->modelName . ' با موفقیت ایجاد شد', MessageBag::TYPE_SUCCESS);
            return redirect("{$this->returnDefault}/" . $model->id . '/edit');
        } else {
            MessageBag::push($this->modelName . ' ایجاد نشد لطفا مجددا تلاش فرمایید');
            return redirect()->back();
        }

    }

//    public function createPre($id)
//    {
//        $model = $this->model::findOrFail($id);
//
//        $customers = Customer::all();
////        $preInvoice= $this->model::all();
//        $preInvoiceDetails = PreInvoiceDetail::all();
//        $data['details'] = $preInvoiceDetails;
//        $data['customers'] = $customers;
//        $data['model'] = $model;
//
//        return view("backend.{$this->viewFolder}.detail.create", $data);
//    }

    public function conversion($id)
    {

        $invoice = Invoice::all();
        if (!isset($invoice[0]))
            goto continuation;

        if ($invoice[0]['pre_invoice_id'] == $id) {
            MessageBag::push($this->modelName . ' قبلا فاکتور شده است');
            return redirect()->back();
        } else {

            continuation:
            $modelInvoice = new Invoice();
            $modelInvoiceDetail = new InvoiceDetail();

            $modelPreInvoice = $this->modelPreInvoice::findOrFail($id);
            $modelPreInvoiceDetail = $this->modelPreInvoiceDetail::where('pre_invoice_id', $id)->get();
            if (isset($modelPreInvoiceDetail[0]['pre_invoice_id'])) {

                $modelInvoice['status'] = \App\Models\CRM\Invoice::STATUS_FACTOR_SHODEH;
                $modelInvoice['type'] = $modelPreInvoice->type;
                $modelInvoice['customer_id'] = $modelPreInvoice->customer_id;
                $modelInvoice['pre_invoice_id'] = $id;
                $modelInvoice->save();

                $modelPreInvoice['status'] = \App\Models\CRM\Invoice::STATUS_FACTOR_SHODEH;
                $modelPreInvoice->save();

                $modelInvoiceDetail['product_name'] = $modelPreInvoiceDetail[0]->product_name;
                $modelInvoiceDetail['unit_price'] = $modelPreInvoiceDetail[0]->unit_price;
                $modelInvoiceDetail['count'] = $modelPreInvoiceDetail[0]->count;
                $modelInvoiceDetail['invoice_id'] = $modelInvoice->id;

                if ($modelInvoiceDetail->save()) {
                    MessageBag::push($this->modelNameDetail . ' با موفقیت تبدیل شد', MessageBag::TYPE_SUCCESS);
                    return redirect("{$this->returnDefault}/" . $modelInvoice->id . '/edit');
                } else {
                    MessageBag::push($this->modelName . ' تبدیل نشد لطفا مجددا تلاش فرمایید');
                    return redirect()->back();
                }
            } else {
                MessageBag::push($this->modelName . 'نباید بدون آیتم باشد . لطفا یک آیتم اضافه نمایید');
                return redirect()->back();

            }

        }

        return view("backend.{$this->viewFolder}.detail.create");
    }

//    public function storePre($id)
//    {
////        dd(request('checks'));
//        $model = new PreInvoiceDetail();
//        $model->pre_invoice_id = $id;
//        $model->unit_price = preg_replace("/[^A-Za-z0-9 ]/", '', request('unit_price'));
//        $model->fill(request()->all());
//        if ($model->save()) {
//            MessageBag::push($this->modelNameDetail . ' با موفقیت اضافه شد', MessageBag::TYPE_SUCCESS);
//            return redirect("{$this->returnDefault}/" . $id . '/edit');
//        } else {
//            MessageBag::push($this->modelName . ' ایجاد نشد لطفا مجددا تلاش فرمایید');
//            return redirect()->back();
//        }
//
//    }

    public function edit($id, Request $request)
    {
        $invoiceDetails = $this->modelDetail::where('invoice_id', $id)->get();
        $model = $this->model::findOrFail($id);
        $totalSum = $model->totalPriceAll();
        $discount = $model->total_discount;
        $tax = $this->tax($totalSum);
        if ($model['type'] ===Invoice::TYPE_RASMI) {
            $amountPayable = ($totalSum - $discount) + $tax;
        } else {
            $amountPayable = $totalSum - $discount;
            $tax = 0;
        }
        $data['amountPayable'] = $amountPayable;
        $data['details'] = $invoiceDetails;
        $data['tax'] = $tax;
        $data['totalSum'] = $totalSum;
        $customers = Customer::all();
        $data['customers'] = $customers;
        $data['model'] = $model;
        return view("backend.{$this->viewFolder}.edit", $data);
    }

    public function update($id)
    {
        request()->validate(Invoice::getValidationInvoice(true, $id));
        $model = $this->model::findOrFail($id);
//        dd($model);
        if (request('total_discount') == null) {

            $model['total_discount'] = null;
        } else {
            $x = \App\Utilities\HString::number2en(request('total_discount'));
            $model['total_discount'] = preg_replace("/[^A-Za-z0-9 ]/", '', $x);

        }

        $model->fill(request()->all());
        if ($model->save()) {
            MessageBag::push($this->modelName . ' با موفقیت ویرایش شد', MessageBag::TYPE_SUCCESS);
            return redirect()->back();
        } else {
            MessageBag::push('مجدد تلاش کنید ');
            return redirect()->back();
        }

    }

    public function editDetail($id)
    {
//        dd('ddd');
        $model = $this->modelDetail::findOrFail($id);
        $data['model'] = $model;
        return view("backend.{$this->viewFolder}.detail.edit", $data);
    }

    public function updateDetail($id)
    {
        $model = $this->modelDetail::findOrFail($id);
        $model->fill(request()->all());
        if ($model->save()) {
            MessageBag::push($this->modelName . ' با موفقیت ویرایش شد', MessageBag::TYPE_SUCCESS);
            return redirect()->back();
        } else {
            MessageBag::push('مجدد تلاش کنید ');
            return redirect()->back();
        }
    }

//    public function totalPrice($models)
//    {
//
//        $totalSum = 0;
//        $countPrice = $models->count();
//        for ($i = 1; $i <= $countPrice;) {
//            foreach ($models as $unit) {
//                $mul_price = $unit->unit_price * $unit->count;
//                $totalSum = $totalSum + $mul_price;
//                $i++;
//            }
//        }
//        return $totalSum;
//    }

    public function tax($totalSum)
    {
        $tax = ($totalSum * 9) / 100;
        return $tax;
    }

    public function discount()
    {
        $discount = request('total_discount');
        dd($discount);
    }

    /*
     * ------------------------------- actions ------------------------------
     */
    public function actions(Request $request)
    {

        $ids = array_keys(request('checks', []));
        $action = trim(strtolower(request('action', '')));

        switch ($action) {
            case 'delete':
                $this->deleteAction($ids);
                break;
        }

        return redirect()->back();
    }

    public function deleteAction($ids)
    {
        $count = count($ids);
        $model = $this->model::findOrFail($ids);
        for ($i = 0; $i < $count; $i++) {
            $idPreInvoice = $model[$i]['pre_invoice_id'];
            if (isset($idPreInvoice)) {
                $preInvoice = $this->modelPreInvoice::findOrFail($idPreInvoice);
                $preInvoice->status = 1;
                $preInvoice->save();
            }

        }
        if ($this->model::whereIn('id', $ids)->delete()) {
            MessageBag::push("تعداد {$count} {$this->modelName} با موفقیت حذف شد", MessageBag::TYPE_SUCCESS);
        } else {
            MessageBag::push("{$this->modelName}  حذف نشد لطفا مجددا تلاش فرمایید");
        }

    }
}
