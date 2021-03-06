<?php

namespace App\Http\Controllers\Backend\CRM\PreInvoice;

use App\Http\Controllers\Controller;
use App\Http\Requests\TitleSearchValidation;
use App\Models\CRM\Customer;
use App\Models\CRM\PreInvoice;
use App\Models\CRM\PreInvoiceDetail;
use App\Utilities\Jdf;
use App\Utilities\MessageBag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreInvoiceController extends Controller
{

    protected $returnDefault = 'sadmin/crm/preInvoice';
    protected $model = \App\Models\CRM\PreInvoice::class;
    protected $modelInvoice = \App\Models\CRM\Invoice::class;
    protected $modelDetail = \App\Models\CRM\PreInvoiceDetail::class;
    protected $modelName = 'پیش فاکتور';
    protected $modelNameDetail = 'یک آیتم';
    protected $viewFolder = 'CRM/preInvoice';

    public function filter()
    {
//        $model = $this->model::OrderBy('id')->withTrashed();
        $model = $this->model::OrderBy('id');
        $filter = request()->all();

//        if (!empty($filter['term'])) {
//            $model->search($filter['term']);
//        }

        $details = PreInvoiceDetail::orderBy('id');
        if (!empty($filter['term'])) {

            request()->validate(PreInvoice::getValidationFullTextSearch());

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

        if (isset($filter['date_from'])) {
            request()->validate(PreInvoice::getValidationSearchDateFrom());

            $date = explode('/', $filter['date_from']);
            $gdate = Jdf::jalali_to_gregorian($date[0], $date[1], $date[2], '-') . ' 00:00:00';
            $model->where($date_type, '>=', $gdate);
        }

        if (isset($filter['date_to'])) {
            request()->validate(PreInvoice::getValidationSearchDateTo());

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
            request()->validate(PreInvoice::getValidationSearchNumber());
            $model->where('id', '=', $filter['perInvoiceNumber']);
        }
        if (isset($filter['title'])) {

            request()->validate(PreInvoice::getValidationSearchTitle());
            $model->where('title', '=', $filter['title']);
        }

        if (isset($filter['type'])) {
            $unOfficial="unOfficial";
            $official="official";
            if ($filter['type']==$unOfficial){
                $model->where('type', PreInvoice::TYPE_GHEYRE_RASMI);
            }elseif($filter['type']==$official){
                $model->where('type', PreInvoice::TYPE_RASMI);
            }
        }

        if (isset($filter['economicID'])) {
            request()->validate(PreInvoice::getValidationeconomicID());
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
        $customers = Customer::all();
        $data['customers'] = $customers;
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
        if ($model['status'] == PreInvoice::STATUS_FACTOR_SHODEH) {
            MessageBag::push("{$this->modelName}  به فاکتور تبدیل شده است .لذا قابل حذف نمی باشد");
            return redirect()->back();
        } else {
            $this->deleteAction([$id]);
            return redirect($this->returnDefault);
        }

    }
    public function create()
    {
        $customers = Customer::all();
        $data['customers'] = $customers;
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
    public function edit($id, Request $request)
    {

        $preInvoiceDetails = $this->modelDetail::where('pre_invoice_id', $id)->get();
        $model = $this->model::findOrFail($id);
        $totalSum = $model->totalPriceAll();
        $discount = $model->total_discount;
        $tax = $this->tax($totalSum);
        if($model['type']===PreInvoice::TYPE_RASMI) {

            $amountPayable = ($totalSum - $discount) + $tax;

        }else{
            $amountPayable = $totalSum - $discount;

        }
        $data['details'] = $preInvoiceDetails;
        $data['tax'] = $tax;
        $data['amountPayable'] = $amountPayable;
        $data['totalSum'] = $totalSum;
        $customers = Customer::all();
        $data['customers'] = $customers;
        $data['model'] = $model;
        return view("backend.{$this->viewFolder}.edit", $data);
    }
    public function update($id, Request $request)
    {

        request()->validate(PreInvoice::getValidationPreInvoice(true, $id));
        $model = $this->model::findOrFail($id);
        $model['date']= request('date');
        if ($model['status'] == PreInvoice::STATUS_OPEN) {

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
        } else {
            MessageBag::push('این پیش فاکتور به فاکتور تبدیل شده است.امکان تغییر آیتم ها وجود ندارد ');
            return redirect()->back();
        }
    }
    public function tax($totalSum)
    {
        $tax = ($totalSum * 9) / 100;
        return $tax;
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
        $count = count($this->model::whereIn('id', $ids)->where('status', 1)->get());
        if ($this->model::whereIn('id', $ids)->where('status', 1)->delete()) {
            MessageBag::push("تعداد {$count} {$this->modelName} با موفقیت حذف شد", MessageBag::TYPE_SUCCESS);
        } elseif ($this->model::whereIn('id', $ids)->where('status', \App\Models\CRM\PreInvoice::STATUS_FACTOR_SHODEH)) {
            MessageBag::push("{$this->modelName}  به فاکتور تبدیل شده است .لذا قابل حذف نمی باشد");
        } else {
            MessageBag::push("{$this->modelName}  حذف نشد لطفا مجددا تلاش فرمایید");

        }
    }
}
