@extends('backend.layout.main')
@section('body')

    <x-backend.form.form action="{{ \App\Utilities\Url::admin('auth/user/userInformation')}}" method="post">
        @csrf
        <x-backend.card title="ویرایش اطلاعات" color="25">
            <x-slot name="footer">
                <button type="submit" class="btn btn-primary mr-2 px-10">
                    ثبت
                </button>
                <a href="{{ \App\Utilities\Url::admin('auth/user') }}" class="btn btn-danger">بازگشت</a>
            </x-slot>

            <div class="row">

                <div class="col-lg-6">
                    <x-backend.form.form-group title="نامی که بر اساس آن فاکتور صادر می شود">
                        <x-backend.form.input name="name" :value="$model->name"/>
                    </x-backend.form.form-group>
                </div>
                <div class="col-lg-6">
                    <x-backend.form.form-group title="نام انگلیسی">
                        <x-backend.form.input name="name_en" :isFarsi=false :value="$model->name_en"/>
                    </x-backend.form.form-group>
                </div>
                <div class="col-lg-6">
                    <x-backend.form.form-group title="رایانامه">
                        <x-backend.form.input name="email" :isFarsi=false type="email" placeholder="" :value="$model->email"/>
                    </x-backend.form.form-group>
                </div>

                <div class="col-lg-6">
                    <x-backend.form.form-group title="آدرس">
                        <x-backend.form.input name="address"  placeholder="" :value="$model->address"/>
                    </x-backend.form.form-group>
                </div>

                <div class="col-lg-6">
                    <x-backend.form.form-group title="شماره تلفن">
                        <x-backend.form.input name="phone" :isFarsi=false :value="$model->phone"/>
                    </x-backend.form.form-group>
                </div>
                <div class="col-lg-6">
                    <x-backend.form.form-group title="شناسه ملی">
                        <x-backend.form.input name="nationalID" :isFarsi=false placeholder="" :value="$model->nationalID"/>
                    </x-backend.form.form-group>
                </div>

                <div class="col-lg-6">
                    <x-backend.form.form-group title="کد اقتصادی">
                        <x-backend.form.input name="economicID" :isFarsi=false :value="$model->economicID"/>
                    </x-backend.form.form-group>
                </div>
                <div class="col-lg-6">
                    <x-backend.form.form-group title="شماره ثبت">
                        <x-backend.form.input name="registration_number" :isFarsi=false :value="$model->registration_number"/>
                    </x-backend.form.form-group>
                </div>
                در صورت نیاز می توانید رمز عبور جدید را در بخش زیر وارد نمایید
                <div class="row separator separator-dashed my-15 ">

                    <div class="col-lg-6">
                        <x-backend.form.form-group title="گذرواژه جدید">
                            <x-backend.form.input :isFarsi=false name="password"/>
                        </x-backend.form.form-group>
                    </div>

                    <div class="col-lg-6">
                        <x-backend.form.form-group title=" تکرار گذرواژه جدید">
                            <x-backend.form.input :isFarsi=false name="repassword"/>
                        </x-backend.form.form-group>
                    </div>
                </div>

            </div>
        </x-backend.card>
    </x-backend.form.form>

@endsection
