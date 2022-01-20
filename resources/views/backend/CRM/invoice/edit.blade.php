@extends('backend.layout.main')
@section('body')
    <div class="row">
        <div class="col-lg-12">
            <x-backend.form.form action="{{ \App\Utilities\Url::admin('crm/preInvoice/'. $model->id.'/edit')}}"
                                 method="POST">
                @csrf
                <x-backend.card title="ویرایش پیش فاکتور" icon="fa-edit">
                    <div class="col-lg-6">
                        شماره پیش فاکتور: A{{$model->id}}
                    </div>
                    <div class="row ">
                        <div class="col-lg-6">
                            <x-backend.form.form-group title="عنوان">
                                <x-backend.form.input name="title" :value="$model->title"
                                                      placeholder="درصورت نیازعنوان پیش فاکتور را وارد کنید"/>
                            </x-backend.form.form-group>
                        </div>

                        <div class="col-lg-6">
                            <x-backend.form.form-group title="تاریخ">
                                <x-backend.form.datepicker name="date" :value="$model->date"
                                                           placeholder="تاریخ را وارد کنید (اجباری)"/>
                            </x-backend.form.form-group>
                        </div>

                        <div class="col-lg-6">
                            <x-backend.form.form-group title="نام مشتری">
                                <x-backend.form.select2 name="customer_id">
                                    @foreach($customers as $item)
                                        <option value="{{$item->id}}"
                                                @if($item->id===$model->customer_id) selected @endif>
                                            {{$item->name}}
                                        </option>
                                    @endforeach
                                </x-backend.form.select2>
                            </x-backend.form.form-group>
                        </div>


                        <div class="col-lg-6">
                            <x-backend.form.form-group title="وضعیت">
                                <x-backend.form.input name="address" :value="$model->status" disable="disabled"/>
                            </x-backend.form.form-group>
                        </div>

                        <div class="col-lg-6">
                            <x-backend.form.form-group title="قیمت کل  ریال">
                                <x-backend.form.input name="total_price"
                                                      disable="disabled"    :value="\App\Utilities\HString::number2farsi(\App\Utilities\HString::dividePrice($totalSum))"/>
                            </x-backend.form.form-group>
                        </div>
                        <div class="col-lg-6">


                            <x-backend.form.form-group title=" تخفیف کل  ریال">
                                <x-backend.form.input name="total_discount" :value="\App\Utilities\HString::number2farsi(\App\Utilities\HString::dividePrice($model->total_discount))"
                                                      separate="true"   placeholder="درصورت نیاز تخفیف مورد نظر را وارد کنید"/>
                            </x-backend.form.form-group>
                        </div>
                        <div class="col-lg-6">
                            <x-backend.form.form-group title="مالیات" >
                                @if(!$model->type)
                                    <x-backend.form.input name="address"
                                                          disable="disabled" :value="0"/>
                                @else
                                    <x-backend.form.input name="address"
                                                          disable="disabled"  :value="\App\Utilities\HString::number2farsi(\App\Utilities\HString::dividePrice($tax))"/>
                                    @endif
                            </x-backend.form.form-group>
                        </div>

                        <div class="col-lg-6 mt-8 mb-3">
                            <x-backend.form.form-group title="نوع :" isInline="true">
                                <x-backend.form.radio-inline>
                                    <x-backend.form.radio title="غیر رسمی"
                                                          name="type"
                                                          value="{{\App\Models\CRM\PreInvoice::TYPE_GHEYRE_RASMI}}"
                                                          :checked="\App\Models\CRM\PreInvoice::TYPE_GHEYRE_RASMI === $model->type"
                                    />
                                    <x-backend.form.radio title="رسمی"
                                                          name="type"
                                                          value="{{\App\Models\CRM\PreInvoice::TYPE_RASMI}}"
                                                          :checked="\App\Models\CRM\PreInvoice::TYPE_RASMI === $model->type"
                                    />
                                </x-backend.form.radio-inline>
                            </x-backend.form.form-group>

                        </div>
                        <div class="col-lg-12">
                            <x-backend.form.form-group title="مبلغ قابل پرداخت ریال: ">
                                <x-backend.form.input  name="address"  disable="disabled"
                                                      :value="\App\Utilities\HString::number2farsi(\App\Utilities\HString::dividePrice($amountPayable))" />
                            </x-backend.form.form-group>
                        </div>

                        <div class="col-lg-12">
                            <x-backend.form.form-group title="توضیحات:">
                                <x-backend.form.textarea name="description"
                                                         placeholder="درصورت نیاز توضیحات خود را وارد کنید">
                                                                        {{$model->description}}
                                </x-backend.form.textarea>
                            </x-backend.form.form-group>
                        </div>

                    </div>

                    <x-slot name="footer">
                        <button type="submit" class="btn btn-primary mr-2 px-10">
                            ثبت
                        </button>
                        <a href="{{ \App\Utilities\Url::admin('crm/preInvoice') }}" class="btn btn-danger">بازگشت</a>
                        <a href="{{ \App\Utilities\Url::admin('crm/preInvoice/'. $model->id.'/pdf') }}" class="btn btn-warning float-left ml-4">نمایش  فاکتور</a>
                    </x-slot>
                </x-backend.card>
            </x-backend.form.form>











            <div class="row mt-5">
                <div class="col-lg-12">
                    <x-backend.form.form action="{{ \App\Utilities\Url::admin('crm/preInvoiceDetail/'.$model->id.'/create') }}"
                                                    method="post">
                                                    @csrf
{{--                    <x-backend.form.form :action="Request::getRequestUri()" method="POST">--}}
{{--                        @csrf--}}
                    <x-backend.card no-padding="true" title="اقلام پیش فاکتور" color="2"
                                    collapseid="#collapse-btn-2"
                                    idcollapse="collapse-btn-2" icon="fa-list">
                        <x-slot name="nav">

                                <div class="row">

                                    <div class="col-lg-6">
                                        <x-backend.form.form-group title="نام محصول / خدمات">
                                            <x-backend.form.input name="product_name"
                                                                  placeholder="نام محصول را وارد کنید"/>
                                        </x-backend.form.form-group>
                                    </div>

                                    <div class="col-lg-1">
                                        <x-backend.form.form-group title="تعداد">
                                            <x-backend.form.input name="count" placeholder="تعداد"/>
                                        </x-backend.form.form-group>
                                    </div>

                                    <div class="col-lg-3">
                                        <x-backend.form.form-group title=" قیمت واحد">
                                            <x-backend.form.input name="unit_price" placeholder="قیمت را وارد کنید " separate="true"/>
                                        </x-backend.form.form-group>
                                    </div>

                                    <div class="col-lg-1 pl-20 p-5">
                                        <button type="submit" class="btn btn-outline-success ml-5 fa fa-plus">
                                            افزودن
                                        </button>
                                    </div>
                                </div>
                        </x-slot>
                        <div class="row">
                            <div class="col-12">
                            </div>
                        </div>
                        <x-backend.table>
                            <colgroup>
                                <col style="width: 10px">
                                <col style="width: 10px ">
                                <col style="width: 20px ">
                                <col style="width: 300px ">
                                <col style="width: 14px ">
                                <col style="width: 200px ">
                                <col style="width: 200px ">
                            </colgroup>
                            <thead>
                            <tr>
                                <th class="align-middle text-center">#</th>
                                <th class="align-middle text-center">

                                </th>
                                <th>عملیات</th>
                                <th>محصول/خدمات</th>
                                <th>تعداد</th>
                                <th>قیمت واحد</th>
                                <th>جمع کل</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($details as $item)
                                <tr>
                                    <td></td>
                                    <td class="align-middle text-center">

                                    </td>
                                    <td>
                                        <x-backend.dropdown>
                                            <div class=" text-center">
                                                <a href="{{ \App\Utilities\Url::admin('crm/preInvoiceDetail/'. $item->id.'/edit') }}"
                                                   class="dropdown-item text-center">ویرایش</a>
                                                <div class="dropdown-divider"></div>
                                            </div>
                                            <div class=" text-center">

                                                <a href="{{ \App\Utilities\Url::admin('crm/preInvoiceDetail/'. $item->id . '/delete') }}"
                                                   class="x-confirm text-center text-danger dropdown-item"
                                                   data-title="حذف فایل"
                                                   data-description="آیا از حذف این فایل  اطمینان دارید؟"
                                                   name="action"
                                                   value="delete">حذف</a>

                                            </div>
                                        </x-backend.dropdown>

                                    </td>
                                    <td>{{$item->product_name}}</td>
                                    <td>{{\App\Utilities\HString::number2farsi($item->count)}}</td>
                                    <td>{{\App\Utilities\HString::number2farsi(\App\Utilities\HString::dividePrice($item->unit_price))}}</td>
                                    <td>{{\App\Utilities\HString::number2farsi(\App\Utilities\HString::dividePrice($item->totalPrice()))}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </x-backend.table>

                         </x-backend.card>

                    </x-backend.form.form>
                </div>
           </div>

        </div>
    </div>
@endsection
@push('script')
    <script>
        $(function () {
            $("#checkAll").click(function () {
                $(".check").prop('checked', $(this).prop('checked'));
            });
        });
        jalaliDatepicker.startWatch();

        function separateNum(value, input) {
            /* seprate number input 3 number */
            var nStr = value + '';
            nStr = nStr.replace(/\,/g, "");
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            if (input !== undefined) {

                input.value = x1 + x2;
            } else {
                return x1 + x2;
            }
        }


    </script>
@endpush
