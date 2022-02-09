<?php

namespace App\Http\Controllers\Backend\CRM\PreInvoice;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\CRM\Customer;
use App\Models\CRM\Invoice;
use App\Models\CRM\PreInvoice;
use App\Models\CRM\PreInvoiceDetail;
use App\Utilities\Jdf;
use App\Utilities\MessageBag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use League\CommonMark\Extension\CommonMark\Node\Block\ThematicBreak;
use function Couchbase\defaultDecoder;
use function React\Promise\all;

class PreInvoiceDetailController extends Controller
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

//    public function create($id)
//    {
//        dd($id);
//        $this->deleteAction([$id]);
//        $customers = Customer::all();
////        $preInvoice= $this->model::all();
//        $data['customers'] = $customers;
//
////        $data['preInvoice'] = $preInvoice;
//        return view("backend.{$this->viewFolder}.create", $data);
//    }

//    public function store(Request $request)
//    {
//        $model = new $this->model;
//        $model->fill(request()->all());
//        if ($model->save()) {
//            MessageBag::push($this->modelName . ' با موفقیت ایجاد شد', MessageBag::TYPE_SUCCESS);
//            return redirect("{$this->returnDefault}/" . $model->id . '/edit');
//        } else {
//            MessageBag::push($this->modelName . ' ایجاد نشد لطفا مجددا تلاش فرمایید');
//            return redirect()->back();
//        }
//
//    }

    public function create($id)
    {
        $model = $this->model::findOrFail($id);

//        $customers = Customer::all();
//        $preInvoice= $this->model::all();
//        $preInvoiceDetails = PreInvoiceDetail::all();
//        $data['details'] = $preInvoiceDetails;
//        $data['customers'] = $customers;
        $data['model'] = $model;


        return view("backend.{$this->viewFolder}.detail.create", $data);
    }
public function pdf(){
    return view("backend.CRM.pdf");
//    dd('lll');
}

    public function store($id)
    {

        $status = $this->model::findOrFail($id);
        $old = \Request::flash($status);
        $old = \Request::old($old);
        $data = [
            'models' => $status,
            'old' => $old,
        ];

//        dd($old);
        if($status['status']==PreInvoice::STATUS_OPEN){
            $model = new PreInvoiceDetail();
            $model->pre_invoice_id = $id;
            $model->count = request('count');
            $model->unit_price = preg_replace("/[^A-Za-z0-9 ]/", '',request('unit_price'));
            request()->validate(PreInvoiceDetail::getValidationCustomer(true, $id));
            $model->fill(request()->all());
            if ($model->save()) {
                MessageBag::push($this->modelNameDetail . ' با موفقیت اضافه شد', MessageBag::TYPE_SUCCESS);
                return redirect("{$this->returnDefault}/" . $id . '/edit');
            } else {
                MessageBag::push($this->modelName . ' ایجاد نشد لطفا مجددا تلاش فرمایید');
                return redirect($data)->back();
            }
        }else{
            MessageBag::push( ' امکان تغییر  وجود ندارد');
            return redirect()->back();
        }


    }

//    public function edit($id, Request $request)
//    {
//        $preInvoiceDetails = $this->modelDetail::where('pre_invoice_id', $id)->get();
//        $model = $this->model::findOrFail($id);
//        $totalSum = $model->totalPriceAll();
//        $discount = $model->total_discount;
//        $tax = $this->tax($totalSum);
//        $amountPayable = ($totalSum - $discount) + $tax;
//        $data['details'] = $preInvoiceDetails;
//        $data['tax'] = $tax;
//        $data['totalSum'] = $totalSum;
//        $data['amountPayable'] = $amountPayable;
//        $customers = Customer::all();
//        $data['customers'] = $customers;
//        $data['model'] = $model;
//        return view("backend.{$this->viewFolder}.edit", $data);
//    }

//    public function update($id)
//    {
//        $model = $this->model::findOrFail($id);
////        request()->validate(Customer::getValidationCustomer(true, $id));
//        $model->fill(request()->all());
//        if ($model->save()) {
//            MessageBag::push($this->modelName . ' با موفقیت ویرایش شد', MessageBag::TYPE_SUCCESS);
//            return redirect()->back();
//        } else {
//            MessageBag::push('مجدد تلاش کنید ');
//            return redirect()->back();
//        }
//    }
    public function edit($id){
//        dd('ddd');
        $model = $this->modelDetail::findOrFail($id);
        $data['model'] = $model;
        return view("backend.{$this->viewFolder}.detail.edit", $data);
    }

    public function  update($id){
        request()->validate(PreInvoiceDetail::getValidationCustomer(true, $id));

        $model=$this->modelDetail::findOrFail($id);
        $status = $this->model::findOrFail($model['pre_invoice_id']);
        if($status['status']==PreInvoice::STATUS_OPEN){
        if(request('unit_price')||request('count')){
                $x=\App\Utilities\HString::number2en(request('unit_price'));
                $y=\App\Utilities\HString::number2en(request('count'));
                $model['unit_price']=preg_replace("/[^A-Za-z0-9 ]/", '',$x);
                $model['count']=preg_replace("/[^A-Za-z0-9 ]/", '',$y);

            }

            $model->fill(request()->all());
            if ($model->save()) {
                MessageBag::push($this->modelName . ' با موفقیت ویرایش شد', MessageBag::TYPE_SUCCESS);
                return redirect()->back();
            } else {
                MessageBag::push('مجدد تلاش کنید ');
                return redirect()->back();
            }
        } else {
            MessageBag::push('این پیش فاکتور به فاکتور تبدیل شده است.امکان تغییر آیتم ها وجود ندارد ');
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

        $count = count($ids);
        if ($this->modelDetail::whereIn('id', $ids)->delete()) {
            MessageBag::push("تعداد {$count} {$this->modelName} با موفقیت حذف شد", MessageBag::TYPE_SUCCESS);
        } else {
            MessageBag::push("{$this->modelName}  حذف نشد لطفا مجددا تلاش فرمایید");
        }
    }
}
