@extends('backend.layout.main')
@section('body')
{{--    <img src="public/imageUser/16456156294.jpg">--}}
    <x-backend.card title="افزودن تصویر برای نمایش در فاکتور " color="25">
        <form method="POST" enctype="multipart/form-data" id="upload-image" action="{{ \App\Utilities\Url::admin('auth/user/image') }}" >
            @csrf

            <div class="row">

                <div class="col-md-12">
                    <div class="form-group">
                        <input type="file" name="image" placeholder="Choose image" id="image">
                        @error('image')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        @if(Auth::user()->name_image!==null)
                        <img width="150px" height="150px" src="{{URL::asset('/imageUser/'.Auth::user()->name_image)}}">
                        @else
                            لطفا با کلیک روی گزینه Choose File یک تصویر انتخاب نمایید
                        @endif
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mr-2 px-10">
                    ثبت
                </button>
            </div>
        </form>

            <x-slot name="footer">

                <a href="{{ \App\Utilities\Url::admin('auth/user') }}" class="btn btn-danger">بازگشت</a>
                <a href="{{ \App\Utilities\Url::admin('auth/user/image/deleteImage') }}" class="btn btn-danger">حذف تصویر</a>
            </x-slot>
        </x-backend.card>

@endsection
