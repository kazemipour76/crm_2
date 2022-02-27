@extends('backend.layout.main')
@section('body')
    <div class="row">
        <div class="col-lg-6">
            <x-backend.form.form action="{{ \App\Utilities\Url::admin('auth/user/' . $model->id .'/permissions') }}" method="post">
                @csrf
                <x-backend.card title="تغییر سطح دسترسی" color="25">
                    <div class="row ">

                        <div class="col-lg-6">

                        <div class="col-lg-6 mt-8 mb-3">
                            <x-backend.form.form-group title="نوع :" isInline="true">
                                <x-backend.form.radio-inline>


                                    <x-backend.form.radio title="کاربر ادمین" name="user_status"
                                                          value="{{\App\Models\Auth\User::USER_BLOCK}}"
                                                          checked="{{\App\Models\CRM\Customer::LEGAL||!old('user_status') ? 'checked' : ''}}"
                                    />
                                    <x-backend.form.radio title="کاربر ویژه" name="user_status"
                                                          value="{{\App\Models\CRM\Customer::LEGAL}}"
                                                          checked="{{\App\Models\CRM\Customer::LEGAL||!old('user_status') ? 'checked' : ''}}"
                                    />
                                    <x-backend.form.radio title="کاربر عادی" name="user_status"
                                                          value="{{\App\Models\CRM\Customer::NATURAL}}"
                                                          checked="{{\App\Models\CRM\Customer::NATURAL||!old('user_status') ? 'checked' : ''}}"

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
