<?php

namespace App\Http\Controllers\Backend\CRM\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\CRM\Customer;
use App\Models\CRM\Invoice;
use App\Models\CRM\InvoiceDetail;
use App\Models\CRM\PreInvoice;
use App\Models\CRM\PreInvoiceDetail;
use App\Utilities\Jdf;
use App\Utilities\MessageBag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use function Couchbase\defaultDecoder;
use function React\Promise\all;

class InvoiceDetailController extends Controller
{

    protected $returnDefault = 'sadmin/crm/invoice';
    protected $model = \App\Models\CRM\Invoice::class;
    protected $modelDetail = \App\Models\CRM\InvoiceDetail::class;
    protected $modelName = ' فاکتور';
    protected $modelNameDetail = 'یک آیتم';
    protected $viewFolder = 'CRM/invoice';


    public function index()
    {
//
    }

    public function destroy($id)
    {
        $this->deleteAction([$id]);
        return redirect($this->returnDefault);
    }

    public function create()
    {
//
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

        if ($status['status'] == Invoice::STATUS_OPEN) {
            $model = new InvoiceDetail();
            $model->invoice_id = $id;
            $model->count = request('count');
            $model->unit_price = preg_replace("/[^A-Za-z0-9 ]/", '', request('unit_price'));
            request()->validate(InvoiceDetail::getValidationInvoiceDetail(true, $id));
            $model->fill(request()->all());
            if ($model->save()) {
                MessageBag::push($this->modelNameDetail . ' با موفقیت اضافه شد', MessageBag::TYPE_SUCCESS);
                return redirect("{$this->returnDefault}/" . $id . '/edit');
            } else {
                MessageBag::push($this->modelName . ' ایجاد نشد لطفا مجددا تلاش فرمایید');
                return redirect($data)->back();
            }
        } else {
            MessageBag::push(' امکان تغییر  وجود ندارد');
            return redirect()->back();
        }


    }


    public function edit($id)
    {
        $model = $this->modelDetail::findOrFail($id);
        $data['model'] = $model;
        return view("backend.{$this->viewFolder}.detail.edit", $data);
    }

    public function update($id)
    {
        request()->validate(InvoiceDetail::getValidationInvoiceDetail(true, $id));

        $model = $this->modelDetail::findOrFail($id);
        $status = $this->model::findOrFail($model['invoice_id']);
        if ($status['status'] == Invoice::STATUS_OPEN) {
            if (request('unit_price') || request('count')) {
                $x = \App\Utilities\HString::number2en(request('unit_price'));
                $y = \App\Utilities\HString::number2en(request('count'));
                $model['unit_price'] = preg_replace("/[^A-Za-z0-9 ]/", '', $x);
                $model['count'] = preg_replace("/[^A-Za-z0-9 ]/", '', $y);

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
