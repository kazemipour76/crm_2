@extends('backend.layout.main')
@section('body')
    <x-backend.form.form action="{{ \App\Utilities\Url::admin('auth/user/create') }}" method="post">
        @csrf
        <x-backend.card title="افرودن کاربر جدید">
            <div class="row">

                <div class="col-lg-6">
                    <x-backend.form.form-group title="رایانامه">
                        <x-backend.form.input
                            name="email"
                            type="email"
                            placeholder="myemail@gmail.com"
                        />
                    </x-backend.form.form-group>
                </div>

                <div class="col-lg-6">
                    <x-backend.form.form-group title="نام">
                        <x-backend.form.input name="name"/>
                    </x-backend.form.form-group>
                </div>

                <div class="col-lg-6">
                    <x-backend.form.form-group title="گذرواژه">
                        <x-backend.form.input name="password"/>
                    </x-backend.form.form-group>
                </div>

                <div class="col-lg-6">
                    <x-backend.form.form-group title="تکرار گذرواژه">
                        <x-backend.form.input name="repassword"/>
                    </x-backend.form.form-group>
                </div>


            </div>

            <x-slot name="footer">
                <button type="submit" class="btn btn-primary mr-2 px-10">
                    ثبت
                </button>
                <a href="{{ \App\Utilities\Url::admin('auth/user') }}" class="btn btn-danger">بازگشت</a>
            </x-slot>
        </x-backend.card>
    </x-backend.form.form>

@endsection
