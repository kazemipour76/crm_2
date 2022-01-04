<?php

namespace App\Http\Controllers\Backend\CRM\PreInvoice;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\CRM\Customer;
use App\Models\CRM\PreInvoice;
use App\Models\CRM\PreInvoiceDetail;
use App\Utilities\Jdf;
use App\Utilities\MessageBag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use function Couchbase\defaultDecoder;
use function React\Promise\all;

class PreInvoiceController extends Controller
{

    protected $returnDefault = 'sadmin/crm/preInvoice';
    protected $model = \App\Models\CRM\PreInvoice::class;
    protected $modelDetail = \App\Models\CRM\PreInvoiceDetail::class;
    protected $modelName = 'پیش فاکتور';
    protected $modelNameDetail = 'یک آیتم';
    protected $viewFolder = 'CRM/preInvoice';

    public function filter()
    {
//        $model = $this->model::OrderBy('id')->withTrashed();
        $model = $this->model::OrderBy('id');
        $filter = request()->all();

        if (!empty($filter['term'])) {
            $model->search($filter['term']);
        }

        $date_type = '';
        if (isset($filter['date_type'])) {
            $date_type = $filter['date_type'];
        }

        if (isset($filter['date_from'])) {
            $date = explode('/', $filter['date_from']);
            $gdate = Jdf::jalali_to_gregorian($date[0], $date[1], $date[2], '-') . ' 00:00:00';
            $model->where($date_type, '>=', $gdate);
        }

        if (isset($filter['date_to'])) {
            $date = explode('/', $filter['date_to']);
            $gdate = Jdf::jalali_to_gregorian($date[0], $date[1], $date[2], '-') . ' 23:59:59';
            $model->where($date_type, '<=', $gdate);
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
        $model->fill(request()->all());
        if ($model->save()) {
            MessageBag::push($this->modelName . ' با موفقیت ایجاد شد', MessageBag::TYPE_SUCCESS);
            return redirect("{$this->returnDefault}/" . $model->id . '/edit');
        } else {
            MessageBag::push($this->modelName . ' ایجاد نشد لطفا مجددا تلاش فرمایید');
            return redirect()->back();
        }

    }

    public function createPre($id)
    {
        $model = $this->model::findOrFail($id);

        $customers = Customer::all();
//        $preInvoice= $this->model::all();
        $preInvoiceDetails = PreInvoiceDetail::all();
        $data['details'] = $preInvoiceDetails;
        $data['customers'] = $customers;
        $data['model'] = $model;

        return view("backend.{$this->viewFolder}.detail.create", $data);
    }

    public function storePre($id)
    {
//        dd(request('checks'));
        $model = new PreInvoiceDetail();
        $model->pre_invoice_id = $id;
        $model->unit_price = preg_replace("/[^A-Za-z0-9 ]/", '',request('unit_price'));
        $model->fill(request()->all());
        if ($model->save()) {
            MessageBag::push($this->modelNameDetail . ' با موفقیت اضافه شد', MessageBag::TYPE_SUCCESS);
            return redirect("{$this->returnDefault}/" . $id . '/edit');
        } else {
            MessageBag::push($this->modelName . ' ایجاد نشد لطفا مجددا تلاش فرمایید');
            return redirect()->back();
        }

    }

    public function edit($id, Request $request)
    {
        $preInvoiceDetails = $this->modelDetail::where('pre_invoice_id', $id)->get();
        $model = $this->model::findOrFail($id);
        $totalSum = $model->totalPriceAll();
        $discount = $model->total_discount;
        $tax = $this->tax($totalSum);
        $amountPayable = ($totalSum - $discount) + $tax;
        $data['details'] = $preInvoiceDetails;
        $data['tax'] = $tax;
        $data['totalSum'] = $totalSum;
        $data['amountPayable'] = $amountPayable;
        $customers = Customer::all();
        $data['customers'] = $customers;
        $data['model'] = $model;
        return view("backend.{$this->viewFolder}.edit", $data);
    }

    public function update($id)
    {
        $model = $this->model::findOrFail($id);
//        dd($model);
        if(request('total_discount')==null){

            $model['total_discount']=null;
        }else{
       $x=\App\Utilities\HString::number2en(request('total_discount'));
            $model['total_discount']=preg_replace("/[^A-Za-z0-9 ]/", '',$x);

        }
//        $model->total_discount=111;
//        dd(   request('total_discount'));
//        request()->validate(Customer::getValidationCustomer(true, $id));
        $model->fill(request()->all());
        if ($model->save()) {
            MessageBag::push($this->modelName . ' با موفقیت ویرایش شد', MessageBag::TYPE_SUCCESS);
            return redirect()->back();
        } else {
            MessageBag::push('مجدد تلاش کنید ');
            return redirect()->back();
        }
    }
    public function editDetail($id){
//        dd('ddd');
        $model = $this->modelDetail::findOrFail($id);
        $data['model'] = $model;
        return view("backend.{$this->viewFolder}.detail.edit", $data);
    }

    public function  updateDetail($id){
        $model=$this->modelDetail::findOrFail($id);
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

//total_discount
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
//        dd($ids);
        $count = count($ids);
        if ($this->model::whereIn('id', $ids)->delete()) {
            MessageBag::push("تعداد {$count} {$this->modelName} با موفقیت حذف شد", MessageBag::TYPE_SUCCESS);
        } else {
            MessageBag::push("{$this->modelName}  حذف نشد لطفا مجددا تلاش فرمایید");
        }
    }
}
