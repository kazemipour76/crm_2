<?php

namespace App\Http\Controllers\Backend\CRM;

use App\Http\Controllers\Controller;
use App\Models\CRM\Customer;
use App\Models\CRM\Invoice;
use App\Models\CRM\InvoiceDetail;
use App\Models\CRM\PreInvoice;
use App\Utilities\Jdf;
use App\Utilities\MessageBag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{

    protected $returnDefault = 'sadmin/crm/customer';
    protected $modelName = 'مشتری';
    protected $viewFolder = 'CRM/Customer';
    protected $model = \App\Models\CRM\Customer::class;

    public function filter()
    {
//        $model = $this->model::OrderBy('id')->withTrashed();
        $model = $this->model::OrderBy('id');
        $filter = request()->all();


        $date_type = '';
        if (isset($filter['date_type'])) {
            $date_type = $filter['date_type'];
        }

        if (isset($filter['entity'])) {
            $legal="legal";
            $natural="natural";
            if ($filter['entity']==$legal){
                $model->where('entity', Customer::LEGAL);
            }elseif($filter['entity']==$natural){
                $model->where('entity', Customer::NATURAL);
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
        return view("backend.{$this->viewFolder}.create");
    }

    public function store()
    {
        $model = new Customer();
        request()->validate(Customer::getValidationCustomer());
        $model->_user_id=Auth::id();
        $model->fill(request()->all());
//        $model->fillUser();

        if ($model->save()) {
            MessageBag::push($this->modelName . ' با موفقیت ایجاد شد', MessageBag::TYPE_SUCCESS);
            return redirect("{$this->returnDefault}/" . $model->id . '/edit');
        } else {
            MessageBag::push($this->modelName . ' ایجاد نشد لطفا مجددا تلاش فرمایید');
            return redirect()->back();
        }

    }

    public function edit($id)
    {
        $model = Customer::findOrFail($id);
        $data['model'] = $model;
        return view("backend.{$this->viewFolder}.edit", $data);
    }

    public function update($id)
    {
        $model = Customer::findOrFail($id);
        request()->validate(Customer::getValidationCustomer(true, $id));
        $model->fill(request()->all());
        if ($model->save()) {
            MessageBag::push($this->modelName . ' با موفقیت ویرایش شد', MessageBag::TYPE_SUCCESS);
            return redirect()->back();
        } else {
            MessageBag::push('مجدد تلاش کنید ');
            return redirect()->back();
        }
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
        if (Customer::whereIn('id', $ids)->delete()) {
            MessageBag::push("تعداد {$count} {$this->modelName} با موفقیت حذف شد", MessageBag::TYPE_SUCCESS);
        } else {
            MessageBag::push("{$this->modelName}  حذف نشد لطفا مجددا تلاش فرمایید");
        }
    }

    public function invoicesList($id)
    {
        $model = Invoice::where('customer_id', $id)->paginate(5);
        $data['models'] = $model;
        return view("backend.{$this->viewFolder}.lists.invoice", $data);
    }

    public function preInvoicesList($id)
    {
        $model = PreInvoice::where('customer_id', $id)->paginate(5);
        $data['models'] = $model;
        return view("backend.{$this->viewFolder}.lists.preInvoice", $data);
    }
}
