@extends('backend.layout.main')
@section('body')
    <div class="row">
        <div class="col-lg-6">
            <x-backend.form.form action="{{ \App\Utilities\Url::admin('crm/customer/create') }}" method="post">
                @csrf
                <x-backend.card title="افرودن کاربر جدید">
                    <div class="row ">

                        <div class="col-lg-6">
                            <x-backend.form.form-group title="نام">
                                <x-backend.form.input name="name"/>
                            </x-backend.form.form-group>
                        </div>

                        <div class="col-lg-6">
                            <x-backend.form.form-group title="آدرس">
                                <x-backend.form.input name="address"/>
                            </x-backend.form.form-group>
                        </div>

                        <div class="col-lg-6">
                            <x-backend.form.form-group title="شناسه اقتصادی">
                                <x-backend.form.input name="economicID"/>
                            </x-backend.form.form-group>
                        </div>
                        <div class="col-lg-6">
                            <x-backend.form.form-group title="شناسه ملی">
                                <x-backend.form.input name="nationalID"/>
                            </x-backend.form.form-group>
                        </div>

                        <div class="col-lg-6">
                            <x-backend.form.form-group title="تلفن">
                                <x-backend.form.input name="phone"/>
                            </x-backend.form.form-group>
                        </div>

                        {{--                <div class="col-lg-6">--}}
                        {{--                    <x-backend.form.form-group title="رایانامه">--}}
                        {{--                        <x-backend.form.input--}}
                        {{--                            name="email"--}}
                        {{--                            type="email"--}}
                        {{--                            placeholder="myemail@gmail.com"--}}
                        {{--                        />--}}
                        {{--                    </x-backend.form.form-group>--}}
                        {{--                </div>--}}

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
