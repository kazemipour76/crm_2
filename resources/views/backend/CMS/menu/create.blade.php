@extends('backend.layout.main')
@section('body')
    <x-backend.form.form action="{{ \App\Utilities\Url::admin('cms/menu/create') }}" method="post">
        @csrf
        <x-backend.card title="افرودن کاربر جدید">
            <div class="row">
                <div class="col-lg-6">
                    <x-backend.form.form-group title="عنوان">
                        <x-backend.form.input name="title"/>
                    </x-backend.form.form-group>
                </div>

                <div class="col-lg-6">
                    <x-backend.form.form-group title="انتخاب والد">
                        <x-backend.form.select2 name="parent_id">
                            <option value="" @if(empty(old('folder'))) selected @endif>انتخاب کنید</option>
                            @foreach($models as  $model)
                                <option
                                    value="{{$model->id}}" @if(empty(old('folder')))  @endif>{{$model->title}}</option>
                            @endforeach

                        </x-backend.form.select2>
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
