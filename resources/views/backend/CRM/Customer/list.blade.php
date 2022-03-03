@extends('backend.layout.main')
@php
    $formId = 'filter-form'
@endphp

@section('body')

    <div class="row mb-5">
        <div class="col-lg-12">
            @include('backend.CRM.customer.filter', ['formId' => $formId])
        </div>
    </div>

    <x-backend.form.form :action="Request::getRequestUri()" method="POST">
        @csrf
        <div class="row mb-5">
            <div class="col-lg-12">
                <x-backend.card no-padding="true" title="لیست کاربران" color="0" collapseid="#collapse-btn-2"
                                idcollapse="collapse-btn-2" icon="fa-list">

                    <div class="col-lg-6 p-5 ">
                        <a href="{{ \App\Utilities\Url::admin('crm/customer/create') }}"
                           class="btn btn-outline-success ml-5">
                            <x-backend.icon class="fa-plus"/>
                            ایجاد
                        </a>

                        <button type="submit"
                                class="x-confirm btn btn-outline-info dropdown"
                                data-title="حذف کاربر ها"
                                data-description="آیا از حذف این مشتری ها اطمینان دارید؟"
                                name="action" value="delete">
                            <x-backend.icon class="fa-trash"/>
                            حذف
                        </button>


                        {{--                        <a href="{{ \App\Utilities\Url::admin('dash') }}"--}}
                        {{--                           class="x-confirm"--}}
                        {{--                           data-description="Des"--}}
                        {{--                           data-title="my title"--}}
                        {{--                        >Dashboard</a>--}}
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <x-backend.full-text-search name="term" :value="old('term')" :formId="$formId"/>
                        </div>
                    </div>

                    <x-backend.table>
                        <colgroup>
                            <col style="width: 20px">
                            <col style="width: 20px ">
                            <col style="width: 20px">

                        </colgroup>
                        <thead>
                        <tr>
                            <th class="align-middle text-center">#</th>
                            <th class="align-middle text-center">
                                <div class="checkbox-list">
                                    <label class="checkbox ">
                                        <input class="check" id="checkAll" type="checkbox" name="Checkboxes1"/>
                                        <span></span>
                                    </label>
                                </div>
                            </th>
                            <th> عملیات</th>
                            <th> نام مشتری</th>
                            <th>نوع مشتری</th>
                            <th>تلفن</th>
                            <th>کد اقتصادی</th>
                            <th>شناسه/کد ملی</th>

                        </tr>
                        </thead>

                        <tbody>
                        @foreach($models as $model)
                            <tr>
                                <td class="align-middle text-center">{{ ($models->currentPage()-1) * $models->perPage() + $loop->index + 1 }}</td>
                                <td class="align-middle text-center">
                                    <div class="checkbox-list">
                                        <x-backend.form.checkbox name="checks[{{ $model->id }}]"/>
                                    </div>
                                </td>
                                <td>
                                    <x-backend.dropdown>
                                        <div class=" text-center">
                                            <a href="{{ \App\Utilities\Url::admin('crm/customer/' . $model->id .'/edit') }}"
                                               class="dropdown-item text-center">ویرایش</a>
                                            <div class="dropdown-divider"></div>
                                        </div>
                                        <div class=" text-center">
                                            <a href="http://127.0.0.1:8000/sadmin/crm/invoice?customer={{$model->id}}"
                                               class="dropdown-item text-center">لیست فاکتورها</a>
                                            <div class="dropdown-divider"></div>
                                        </div>
                                        <div class=" text-center">
                                            <a href="http://127.0.0.1:8000/sadmin/crm/preInvoice?customer={{$model->id}}"
                                               class="dropdown-item text-center">لیست پیش فاکتورها</a>
                                            <div class="dropdown-divider"></div>
                                        </div>
                                        <div class=" text-center">
                                            <a href="{{ \App\Utilities\Url::admin('crm/customer/'. $model->id . '/delete') }}"
                                               class="x-confirm text-center text-danger dropdown-item"
                                               data-title="حذف فایل"
                                               data-description="آیا از حذف این فایل  اطمینان دارید؟" name="action"
                                               value="delete">حذف</a>
                                        </div>
                                    </x-backend.dropdown>

                                </td>
                                <td>{{$model->name}}</td>
                                <td>{{$model->entity}}</td>
                                <td>{{$model->phone}}</td>
                                <td>{{$model->economicID}}</td>
                                <td>{{$model->nationalID}}</td>

                            </tr>
                        @endforeach
                        </tbody>
                    </x-backend.table>

                    <x-slot name="footer">
                        <x-backend.pagination :models="$models" :formId="$formId"></x-backend.pagination>
                    </x-slot>
                </x-backend.card>
            </div>
        </div>

    </x-backend.form.form>

@endsection

@push('script')
    <script>
        // $(document).ready(function(){
        //
        // });
        $(function () {
            $("#checkAll").click(function () {
                $(".check").prop('checked', $(this).prop('checked'));
            });
        });
        jalaliDatepicker.startWatch();


    </script>
@endpush



