<?php

namespace App\Http\Controllers\Backend\CRM\PreInvoice;

use App\Http\Controllers\Controller;
use App\Models\CRM\PreInvoice;
use App\Models\CRM\PreInvoiceDetail;
use App\Utilities\MessageBag;

class PreInvoiceDetailController extends Controller
{

    protected $returnDefault = 'sadmin/crm/preInvoice';
    protected $model = \App\Models\CRM\PreInvoice::class;
    protected $modelDetail = \App\Models\CRM\PreInvoiceDetail::class;
    protected $modelName = 'پیش فاکتور';
    protected $modelNameDetail = 'یک آیتم';
    protected $viewFolder = 'CRM/preInvoice';


    public function destroy($id)
    {
        $this->deleteAction($id);
        return redirect()->back();
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

        if ($status['status'] == PreInvoice::STATUS_OPEN) {
            $model = new PreInvoiceDetail();
            $model->pre_invoice_id = $id;
            $model->count = request('count');
            $model->unit_price = preg_replace("/[^A-Za-z0-9 ]/", '', request('unit_price'));
            request()->validate(PreInvoiceDetail::getValidationCustomer(true, $id));
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
        request()->validate(PreInvoiceDetail::getValidationCustomer(true, $id));

        $model = $this->modelDetail::findOrFail($id);
        $status = $this->model::findOrFail($model['pre_invoice_id']);
        if ($status['status'] == PreInvoice::STATUS_OPEN) {
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

    /*
     * ------------------------------- actions ------------------------------
     */

    public function deleteAction($id)
    {
        if ($this->modelDetail::where('id', $id)->delete()) {
            MessageBag::push("تعداد 1 {$this->modelName} با موفقیت حذف شد", MessageBag::TYPE_SUCCESS);
        } else {
            MessageBag::push("{$this->modelName}  حذف نشد لطفا مجددا تلاش فرمایید");
        }
    }
}
