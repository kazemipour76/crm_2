<x-backend.form.form id="{{ $formId }}" :action="\App\Utilities\Url::admin('library/library')" method="GET">
    <x-backend.card title="جست و جوی پیشرفته"
                    color="3"
                    icon="fa-filter"
                    :isCollapse="!\App\Utilities\Request::hasQuery()">

        <div class="col-12">
            <div class="card-body">

                <div class="row">

                    <div class="col-lg-6 mb-3">
                        <x-backend.form.form-group title="جست و جو در پوشه">
                            <x-backend.form.select2 name="folder">
                                <option value="0" @if(empty(old('folder'))) selected @endif>لطفا انتخاب کنید</option>
                                <option value="images" @if(old('folder') === 'images') selected @endif>تصاویر</option>
                                <option value="video" @if(old('folder') === 'video') selected @endif>ویدیوها</option>
                                <option value=doc" @if(old('folder') === 'doc') selected @endif>سند ها</option>

                            </x-backend.form.select2>
                        </x-backend.form.form-group>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <x-backend.form.form-group title="جست و جو با پسوند">
                            <x-backend.form.input name="ext" placeholder="..پسوند مورد نظر را برای جست و جو وارد نمایید.مثال: jpeg" value="{{old('ext')}}" ></x-backend.form.input>
                        </x-backend.form.form-group>
                    </div>



                    <div class="col-lg-12 mt-10 mb-3">
                        <x-backend.form.form-group title="نوع تاریخ :" isInline="true">
                            <x-backend.form.radio-inline>
                                <x-backend.form.radio title=" تاریخ ایجاد" name="date_type" value="created_at"/>
                                <x-backend.form.radio title=" تاریخ اخرین بروزرسانی" name="date_type"
                                                      value="updated_at"/>

                            </x-backend.form.radio-inline>
                        </x-backend.form.form-group>
                    </div>

                    <div class="col-lg-6 mb-3">
                        <x-backend.form.form-group title="تاریخ از">
                            <x-backend.form.datepicker name="date_from" :value="old('date_from')"/>
                        </x-backend.form.form-group>
                    </div>

                    <div class="col-lg-6 mb-3">
                        <x-backend.form.form-group title="تاریخ تا">
                            <x-backend.form.datepicker name="date_to" :value="old('date_to')"/>
                        </x-backend.form.form-group>
                    </div>

                </div>
            </div>
        </div>


        <x-slot name="footer">
            <button type="submit" class="btn btn-primary mr-2">جستجو</button>
            <a class="btn btn-warning" href="{{ \App\Utilities\Url::admin('library/library') }}">پاک کن</a>
        </x-slot>


    </x-backend.card>
</x-backend.form.form>
