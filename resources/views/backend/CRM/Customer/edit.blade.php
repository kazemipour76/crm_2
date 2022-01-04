@extends('backend.layout.main')
@section('body')
    <div class="row">
        <div class="col-lg-6">
            <x-backend.form.form action="{{ \App\Utilities\Url::admin('crm/customer/'. $model->id.'/edit')}}"
                                 method="post">
                @csrf
                <x-backend.card title="ویرایش کاربر">
                    <div class="row">

                        {{--                <div class="col-lg-6">--}}
                        {{--                    <x-backend.form.form-group title="رایانامه">--}}
                        {{--                        <x-backend.form.input name="email" type="email" placeholder="" :value="$model->email"/>--}}
                        {{--                    </x-backend.form.form-group>--}}
                        {{--                </div>--}}

                        <div class="col-lg-6">
                            <x-backend.form.form-group title="نام">
                                <x-backend.form.input name="name" :value="$model->name"/>
                            </x-backend.form.form-group>
                        </div>

                        <div class="col-lg-6">
                            <x-backend.form.form-group title="آدرس">
                                <x-backend.form.input name="address" :value="$model->address"/>
                            </x-backend.form.form-group>
                        </div>

                        <div class="col-lg-6">
                            <x-backend.form.form-group title="شناسه اقتصادی">
                                <x-backend.form.input name="economicID" :value="$model->economicID"/>
                            </x-backend.form.form-group>
                        </div>
                        <div class="col-lg-6">
                            <x-backend.form.form-group title="شناسه ملی">
                                <x-backend.form.input name="nationalID" :value="$model->nationalID"/>
                            </x-backend.form.form-group>
                        </div>

                        <div class="col-lg-6">
                            <x-backend.form.form-group title="تلفن">
                                <x-backend.form.input name="phone" :value="$model->phone"/>
                            </x-backend.form.form-group>
                        </div>


                    </div>

                    <x-slot name="footer">
                        <button type="submit" class="btn btn-primary mr-2 px-10">
                            ثبت
                        </button>
                        <a href="{{ \App\Utilities\Url::admin('crm/customer') }}" class="btn btn-danger">بازگشت</a>
                    </x-slot>
                </x-backend.card>
            </x-backend.form.form>
        </div>
    </div>
@endsection
