@extends('backend.layout.main')
@section('body')
    <div class="row">
        <div class="col-lg-6">
            <x-backend.form.form action="{{ \App\Utilities\Url::admin('auth/user/' . $model->id .'/permissions') }}" method="post">
                @csrf
                <x-backend.card title="تغییر سطح دسترسی" color="25">
                    <div class="row ">

                        <div class="col-lg-6">
                        <p>مشخصات کاربری:</p>
                        <p>نام کاربری:</p>
                        <p>ایمیل کاربری:</p>
                        <p>مشخصات کاربری:</p>

                            <div class="col-lg-6 mt-8 mb-3">
                            <x-backend.form.form-group title="نوع :" isInline="true">
                                <x-backend.form.radio-inline>


                                    <x-backend.form.radio title="کاربر ادمین" name="user_type"
                                                          value="{{\App\Models\Auth\User::USER_ADMIN}}"
                                                          checked="{{\App\Models\Auth\User::USER_ADMIN=== $model->user_type ? 'checked' : ''}}"
                                    />
                                    <x-backend.form.radio title="کاربر ویژه" name="user_type"
                                                          value="{{\App\Models\Auth\User::USER_SPECIAL}}"
                                                          checked="{{\App\Models\Auth\User::USER_SPECIAL=== $model->user_type ? 'checked' : ''}}"
                                    />
                                    <x-backend.form.radio title="کاربر عادی" name="user_type"
                                                          value="{{\App\Models\Auth\User::USER_NORMAL}}"
                                                          checked="{{\App\Models\Auth\User::USER_NORMAL=== $model->user_type ?  'checked' : ''}}"

                                    />

                                </x-backend.form.radio-inline>
                            </x-backend.form.form-group>
                        </div>
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
        </div>
    </div>
@endsection
