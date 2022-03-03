<x-backend.form.form id="{{ $formId }}" :action="\App\Utilities\Url::admin('auth/user')" method="get">
    <x-backend.card icon="fa-filter" title="جست و جوی پیشرفته"
                    color="2"
                    icon="fa-filter"
        {{--                    :isCollapse="!\App\Utilities\Request::hasQuery()"--}}
    >
        <div class="col-12">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                            <x-backend.form.form-group title=" جست و جو بر اساس نوع تاریخ">
                                <x-backend.form.radio title=" تاریخ اخرین ورود" name="date_type"
                                value="last_login_at" checked="{{old('date_type')=== 'last_login_at'||!old('date_type') ? 'checked' : ''}}"/>
                                <x-backend.form.radio title=" تاریخ عضویت" name="date_type" value="created_at" checked="{{old('date_type')=== 'created_at'||!old('date_type') ? 'checked' : ''}}"/>
                            </x-backend.form.form-group>
                        </div>
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

                    <div class="col-lg-6">


                        <x-backend.form.form-group title="جست و جو بر اساس نوع کاربر">

                            <x-backend.form.checkbox
                                title=" کاربران ادمین" name="user_type[]" value="3"
                                checked="{{ (is_array(old('user_type')) && in_array(3, old('user_type'))) ? ' checked' : '' }}"
                            />
                            <x-backend.form.checkbox title=" کاربران ویژه" name="user_type[]" value="2"
                              checked="{{ (is_array(old('user_type')) && in_array(2, old('user_type'))) ? ' checked' : '' }}"

                            />
                            <x-backend.form.checkbox title=" کاربران عادی" name="user_type[]" value="0"
                             checked="{{ (is_array(old('user_type')) && in_array(0, old('user_type'))) ? ' checked' : '' }}"

                            />
                            <x-backend.form.checkbox title=" کاربران مسدود" name="user_type[]" value="1"
                                     checked="{{ (is_array(old('user_type')) && in_array(1, old('user_type'))) ? ' checked' : '' }}"

                            />
                            <x-backend.form.checkbox title=" همه" id="checkAll" name="user_type1" value="10"
                            checked="{{ (is_array(old('user_type'))
                                    && in_array(0, old('user_type'))
                                     && in_array(1, old('user_type'))
                                      && in_array(2, old('user_type'))
                                      && in_array(3, old('user_type'))
                                       )? ' checked' : '' }}"

                            />

                        </x-backend.form.form-group>

                    </div>
                </div>
            </div>
        </div>


        {{--                <x-backend.form.checkbox name="checks[{{ $model->id }}]"/>--}}


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


