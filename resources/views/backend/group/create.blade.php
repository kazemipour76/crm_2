@extends('backend.layout.main')
@section('body')
    <x-backend.form.form action="{{ \App\Utilities\Url::admin('auth/group/create') }}" method="post">
        @csrf
        <x-backend.card title="افرودن گروه جدید">
            <div class="row">

                <div class="col-lg-6">
                    <x-backend.form.form-group title="نام">
                        <x-backend.form.input name="name"/>
                    </x-backend.form.form-group>
                </div>
            </div>
            <x-slot name="footer">
                <button type="submit" class="btn btn-primary mr-2 px-10">
                    ثبت
                </button>
                <a href="{{ \App\Utilities\Url::admin('auth/group') }}" class="btn btn-danger">بازگشت</a>
            </x-slot>
        </x-backend.card>
    </x-backend.form.form>

@endsection
