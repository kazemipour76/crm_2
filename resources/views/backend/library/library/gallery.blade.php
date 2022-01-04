@extends('backend.layout.main')

@php
    $formId = 'filter-form'
@endphp

@section('body')


    <div class="row mb-5">
        <div class="col-lg-12">
            @include('backend.library.library.filter', ['formId' => $formId])

        </div>
    </div>



    <x-backend.card no-padding="true" title="کتابخانه" color="2" collapseid="#collapse-btn-2"
                    idcollapse="collapse-btn-2" icon="fa-list">

        <x-slot name="nav">
            <a href="{{\App\Utilities\Url::admin('library/library/create') }}"
               class="btn btn-outline-success ml-5">
                <x-backend.icon class="fa-plus"/>
                ایجاد
            </a>
            <a href="{{\App\Utilities\Url::admin('library/library/') }}" class="btn btn-outline-primary ml-5">
                <x-backend.icon class="fa-list"/>
                لیست
            </a>
        </x-slot>

        <div class="row">
            <div class="col-12 ">
                <x-backend.full-text-search name="term" :value="old('term')" :formId="$formId"/>
            </div>
        </div>

        <div class="d-flex flex-column-fluid flex-wrap p-30">

            @foreach($models as $model)
                <div class="mx-5 my-5">
                    <div class="card card-custom overlay">

                        <div class="card-body p-0">
                            <div class="overlay-wrapper">
                                <img src="{{$model->full_path_asset}}" alt="" class="w-100 rounded"
                                     style="max-width:200px"/>
                            </div>
                            <div class="overlay-layer ">
                                <a href="{{ \App\Utilities\Url::admin('library/library/' . $model->id .'/edit') }}"
                                   class="btn font-weight-bold btn-primary btn-shadow mx-1">ویرایش</a>
                                <a href="{{ \App\Utilities\Url::admin('library/library/' . $model->id . '/delete') }}"
                                   class="x-confirm btn  btn-danger btn-shadow dropdown"
                                   data-title="حذف فایل"
                                   data-description="آیا از حذف این فایل  اطمینان دارید؟" name="action" value="delete">حذف</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        <x-slot name="footer">
            <div class="d-flex justify-content-center">
                <x-backend.pagination :models="$models"></x-backend.pagination>
            </div>
        </x-slot>
    </x-backend.card>



@endsection
