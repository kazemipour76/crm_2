@extends('backend.layout.main')
@section('body')
    <div class="row">
        <div class="col-lg-12">
            <x-backend.form.form
                action="{{ \App\Utilities\Url::admin('crm/invoiceDetail/'.$model->id.'/edit') }}" method="post">
                @csrf
                <x-backend.card title="ویرایش اقلام فاکتور" icon="fa-edit" color="20">
                    <div class="row ">

                        <div class="col-lg-6 ">
                            <x-backend.form.form-group title="نام محصول / خدمات">
                                <x-backend.form.input name="product_name" :value="$model->product_name"/>
                            </x-backend.form.form-group>
                        </div>

                        <div class="col-lg-1">
                            <x-backend.form.form-group title="تعداد">
                                <x-backend.form.input name="count" :value="\App\Utilities\HString::number2farsi(\App\Utilities\HString::dividePrice($model->count))"/>
                            </x-backend.form.form-group>
                        </div>

                        <div class="col-lg-4">
                            <x-backend.form.form-group title=" قیمت واحد">
                                <x-backend.form.input name="unit_price" :value="\App\Utilities\HString::number2farsi(\App\Utilities\HString::dividePrice($model->unit_price))" />
                            </x-backend.form.form-group>
                        </div>
                    </div>

                    <x-slot name="footer">
                        <button type="submit" class="btn btn-primary mr-2 px-10">
                            ثبت
                        </button>
                        <a href="{{ \App\Utilities\Url::admin('crm/invoice/'.$model->invoice->id.'/edit') }}"
                           class="btn btn-danger">بازگشت</a>
                    </x-slot>
                </x-backend.card>
            </x-backend.form.form>
        </div>
    </div>
@endsection
