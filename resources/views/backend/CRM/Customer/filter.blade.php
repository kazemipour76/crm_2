<x-backend.form.form id="{{ $formId }}" :action="\App\Utilities\Url::admin('auth/user')" method="get">
    <x-backend.card icon="fa-filter" title="جست و جوی پیشرفته"
                    color="3"
                    icon="fa-filter"
                    :isCollapse="!\App\Utilities\Request::hasQuery()">
        <div class="col-12">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <x-backend.form.form-group title="نوع تاریخ">
                            <x-backend.form.radio-inline>
                                <x-backend.form.radio title=" تاریخ ایجاد" name="date_type" value="created_at"/>
                                <x-backend.form.radio title=" تاریخ اخرین بروزرسانی" name="date_type"
                                                      value="updated_at"/>
                            </x-backend.form.radio-inline>
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
            <a class="btn btn-warning" href="{{ \App\Utilities\Url::admin('auth/user') }}">
                <x-backend.icon class="fa-eraser"/>
                پاک کن</a>
        </x-slot>


    </x-backend.card>
</x-backend.form.form>
