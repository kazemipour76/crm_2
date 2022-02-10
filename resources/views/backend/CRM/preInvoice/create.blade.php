@extends('backend.layout.main')
@section('body')
    <div class="row">
        <div class="col-lg-6">
            <x-backend.form.form action="{{ \App\Utilities\Url::admin('crm/preInvoice/create') }}" method="post">
                @csrf
                <x-backend.card title="ایجاد پیش فاکتور جدید" color="16">
                    <div class="row ">

                        <div class="col-lg-6">
                            <x-backend.form.form-group title="نام مشتری">
                                <x-backend.form.select2 name="customer_id">
                                    @foreach($customers as $item)
                                    <option value="{{$item->id}}">
                                        {{$item->name}}
                                    </option>
                                    @endforeach
                                </x-backend.form.select2>
                            </x-backend.form.form-group>
                        </div>

                        <div class="col-lg-6 mt-8 mb-3">
                            <x-backend.form.form-group title="نوع :" isInline="true">
                                <x-backend.form.radio-inline>
                                    <x-backend.form.radio title="غیر رسمی" name="type"
                                                          value="{{\App\Models\CRM\Invoice::TYPE_GHEYRE_RASMI}}"
                                                          checked="{{\App\Models\CRM\Invoice::TYPE_GHEYRE_RASMI||!old('type') ? 'checked' : ''}}"

                                    />

                                    <x-backend.form.radio title="رسمی" name="type"
                                                          value="{{\App\Models\CRM\Invoice::TYPE_RASMI}}"
                                                          checked="{{\App\Models\CRM\Invoice::TYPE_RASMI||!old('type') ? 'checked' : ''}}"
                                    />
                                </x-backend.form.radio-inline>
                            </x-backend.form.form-group>
                        </div>

{{--                        <div class="col-lg-6">--}}
{{--                            <x-backend.form.form-group title="تاریخ">--}}
{{--                                <x-backend.form.datepicker name="created_at" :value="old('date_from')"/>--}}
{{--                            </x-backend.form.form-group>--}}
{{--                        </div>--}}


                    </div>

                    <x-slot name="footer">
                        <button type="submit" class="btn btn-primary mr-2 px-10">
                            ثبت
                        </button>
                        <a href="{{ \App\Utilities\Url::admin('crm/preInvoice') }}" class="btn btn-danger">بازگشت</a>
                    </x-slot>
                </x-backend.card>
            </x-backend.form.form>
        </div>
    </div>
@endsection
{{--@push('script')--}}
{{--    <script>--}}
{{--        $(function () {--}}
{{--            $("#checkAll").click(function () {--}}
{{--                $(".check").prop('checked', $(this).prop('checked'));--}}
{{--            });--}}
{{--        });--}}
{{--        jalaliDatepicker.startWatch();--}}
{{--    </script>--}}
{{--@endpush--}}
