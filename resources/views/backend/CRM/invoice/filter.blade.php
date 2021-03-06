<x-backend.form.form id="{{ $formId }}" :action="\App\Utilities\Url::admin('crm/invoice')" method="get">
    <x-backend.card icon="fa-filter" title="جست و جوی پیشرفته"
                    color="6"
                    icon="fa-filter"
        {{--                    :isCollapse="!\App\Utilities\Request::hasQuery()"--}}
    >
        <div class="col-12">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <x-backend.form.form-group title="جست و جو بر اساس نام مشتری">
                            <x-backend.form.select2 name="customer">
                                <option value="0" @if(empty(old('customer'))) selected @endif>لطفا انتخاب کنید</option>
                                @foreach(\App\Models\CRM\Customer::all() as $customer)
                                    <option value="{{$customer->id}}"
                                            @if(old('customer') === "$customer->id") selected @endif>{{$customer->name}}</option>
                                @endforeach
                            </x-backend.form.select2>
                        </x-backend.form.form-group>
                    </div>
                    <div class="col-lg-6">
                        <x-backend.form.form-group title="جست و جو بر اساس شماره  فاکتور">
                            <x-backend.form.input name="perInvoiceNumber" :value="old('perInvoiceNumber')"/>
                        </x-backend.form.form-group>
                    </div>

                    <div class="col-lg-6">
                        <x-backend.form.form-group title="جست و جو بر اساس عنوان   فاکتور">
                            <x-backend.form.input name="title" :value="old('perInvoiceTitle')"/>
                        </x-backend.form.form-group>
                    </div>
                    <div class="col-lg-6">
                        <x-backend.form.form-group title="جست و جو بر اساس کد افتصادی">
                            <x-backend.form.input name="economicID" :value="old('economicID')"/>
                        </x-backend.form.form-group>
                    </div>

                    <div class="col-lg-6">
                        <x-backend.form.form-group title="نوع تاریخ">
                            <x-backend.form.radio title=" تاریخ ایجاد" name="date_type" value="created_at" checked="{{old('date_type')=== 'created_at'||!old('type') ? 'checked' : ''}}"/>
                            <x-backend.form.radio title=" تاریخ اخرین بروزرسانی" name="date_type"
                                                  value="updated_at" checked="{{old('date_type')=== 'updated_at'||!old('type') ? 'checked' : ''}}"/>
                        </x-backend.form.form-group>
                    </div>

                    <div class="col-lg-6">
                        <x-backend.form.form-group title="جست و جو بر اساس نوع  فاکتور">
                            <x-backend.form.radio title=" غیر رسمی" name="type"
                                                  value="unOfficial" checked="{{old('type')=== 'unOfficial'||!old('type') ? 'checked' : ''}}"/>
                            <x-backend.form.radio title=" رسمی" name="type" value="official" checked="{{old('type')=== 'official'||!old('type') ? 'checked' : ''}}"/>
                            <x-backend.form.radio title=" همه" name="type" value="all"  checked="{{old('type')=== 'all'||!old('type') ? 'checked' : ''}}"/>
                        </x-backend.form.form-group>
                    </div>

                    <div class="col-lg-6">
                        <x-backend.form.form-group title="تاریخ از">
                            <x-backend.form.datepicker name="date_from" :value="old('date_from')"/>
                        </x-backend.form.form-group>
                    </div>

                    <div class="col-lg-6">
                        <x-backend.form.form-group title="تاریخ تا">
                            <x-backend.form.datepicker name="date_to" :value="old('date_to')"/>
                        </x-backend.form.form-group>
                    </div>
                </div>
            </div>
        </div>

        <x-slot name="footer">
            <button type="submit" class="btn btn-primary mr-2">
                <x-backend.icon class="fa-file-search"/>
                جست و جو
            </button>
            <a class="btn btn-warning" href="{{ \App\Utilities\Url::admin('crm/invoice') }}">
                <x-backend.icon class="fa-eraser"/>
                پاک کن</a>
        </x-slot>


    </x-backend.card>
</x-backend.form.form>
