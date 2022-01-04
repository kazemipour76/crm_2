@extends('backend.layout.main')
@section('body')
    <div class="row ">
        <div class="col-lg-6">
            <x-backend.form.form action="{{ \App\Utilities\Url::admin('library/library/'. $model->id.'/edit')}}"
                                 method="post"
                                 enctype="multipart/form-data">
                @csrf
                <x-backend.card title="ویرایش فایل" icon="fa-edit">
                    <div class="row">

                        <div class="col-lg-12">
                            <x-backend.form.form-group title="عنوان">
                                <x-backend.form.input name="name" placeholder="" :value="$model->title"/>
                            </x-backend.form.form-group>
                        </div>

                        <div class="col-lg-12">
                            <x-backend.form.form-group title="{{$model->title }}">
                                <img src="{{ $model->full_path_asset }}" WIDTH="210"/>
                            </x-backend.form.form-group>
                        </div>


                        <div class="col-lg-12">
                            <x-backend.form.form-group title="فایل">
                                <x-backend.form.input type="file" name="file"/>
                            </x-backend.form.form-group>
                        </div>


                        <div class="col-lg-12">
                            <x-backend.form.form-group title="زیر نویس">
                                <x-backend.form.textarea name="caption">
                                    {{$model->caption}}
                                </x-backend.form.textarea>
                            </x-backend.form.form-group>
                        </div>


                        <div class="col-lg-12">
                            <x-backend.form.form-group title="توضیحات">
                                <x-backend.form.textarea name="description">
                                    {{$model->description}}
                                </x-backend.form.textarea>
                            </x-backend.form.form-group>
                        </div>

                    </div>


                    <x-slot name="footer">
{{--                        <button type="submit"--}}
{{--                                class="x-confirm btn btn-outline-danger dropdown"--}}


{{--                                name="action" value="delete">--}}

{{--                            <x-backend.icon class="fa-trash"/>--}}
{{--                            حذف--}}
{{--                        </button>--}}


                        <a href="{{ \App\Utilities\Url::admin('library/library/' . $model->id .'/delete') }}"
                           class="x-confirm btn btn-outline-danger"
                           data-title="حذف فایل"
                           data-description="آیا از حذف این فایل اطمینان دارید؟"
                        >   <x-backend.icon class="fa-trash"/>
                            حذف</a>

                        <button type="submit" class="btn btn-primary mr-2 px-10">
                            ثبت
                        </button>
                        <a href="{{ \App\Utilities\Url::admin('library/library') }}" class="btn btn-danger">بازگشت</a>
                    </x-slot>
                </x-backend.card>
            </x-backend.form.form>
        </div>
    </div>
@endsection
