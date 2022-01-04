@extends('backend.layout.main')
@section('body')
    <div class="col-lg-6">
        <x-backend.form.form action="{{ \App\Utilities\Url::admin('setting/' . $section)}}" method="post">
            @csrf
            <x-backend.card title="ویرایش تنظیمات {{ $setting['name'] }}">
                <div class="row">

                    @foreach($setting['children'] as $key => $item)
                        <div class="col-lg-12">

                            @if($item['type'] === \App\Models\Setting\Setting::TYPE_INPUT_TEXT)
                                <x-backend.form.form-group :title="$item['name']" :inputGroup="false">
                                    <x-backend.form.input name="{{ $section.'_'.$key }}" type="text"
                                                          value="{{ \App\Models\Setting\Setting::get($section.'_'.$key) }}"/>
                                </x-backend.form.form-group>
                            @endif

                            @if($item['type'] === \App\Models\Setting\Setting::TYPE_INPUT_EMAIL)
                                <x-backend.form.form-group :title="$item['name']" :inputGroup="false">
                                    <x-backend.form.input name="{{ $section.'_'.$key }}" type="email">
                                        {{ \App\Models\Setting\Setting::get($section.'_'.$key) }}
                                    </x-backend.form.input>
                                </x-backend.form.form-group>
                            @endif

                            @if($item['type'] === \App\Models\Setting\Setting::TYPE_INPUT_COLOR)
                                <x-backend.form.form-group :title="$item['name']" :inputGroup="false">
                                    <x-backend.form.input name="{{ $section.'_'.$key }}" type="color">
                                        {{ \App\Models\Setting\Setting::get($section.'_'.$key) }}
                                    </x-backend.form.input>
                                </x-backend.form.form-group>
                            @endif

                            @if($item['type'] === \App\Models\Setting\Setting::TYPE_INPUT_URL)
                                <x-backend.form.form-group :title="$item['name']" :inputGroup="false">
                                    <x-backend.form.input name="{{ $section.'_'.$key }}" type="url">
                                        {{ \App\Models\Setting\Setting::get($section.'_'.$key) }}
                                    </x-backend.form.input>
                                </x-backend.form.form-group>
                            @endif

                            @if($item['type'] === \App\Models\Setting\Setting::TYPE_TEXTAREA)
                                <x-backend.form.form-group :title="$item['name']" :inputGroup="false">
                                    <x-backend.form.textarea name="{{ $section.'_'.$key }}">
                                        {{ \App\Models\Setting\Setting::get($section.'_'.$key) }}
                                    </x-backend.form.textarea>
                                </x-backend.form.form-group>
                            @endif

                            @if($item['type'] === \App\Models\Setting\Setting::TYPE_SELECT)
                                <x-backend.form.form-group :title="$item['name']" :inputGroup="false">
                                    <x-backend.form.select2 name="{{ $section.'_'.$key }}">
                                        @foreach($item['list'] as $it)
                                            <option value="{{$it['value']}}"
                                                    @if( \App\Models\Setting\Setting::get($section.'_'.$key) == $it['value']) selected @endif>{{$it['name']}}</option>
                                        @endforeach
                                    </x-backend.form.select2>
                                </x-backend.form.form-group>
                            @endif
                            {{--                            </x-backend.form.form-group>--}}
                            @if($item['type'] === \App\Models\Setting\Setting::TYPE_CHECKBOX)
                                @if(isset($item['list']))
                                    <x-backend.form.form-group :title="$item['name']" :inputGroup="false">
                                        <x-dynamic-component
                                            :component="(isset($item['inline']) && $item['inline'] ) ? 'backend.form.checkbox-inline' : 'empty' ">
                                            @foreach($item['list'] as $it)
                                                <x-backend.form.checkbox title="{{$it['name']}}"
                                                                         name="{{ $section.'_'.$key }}"
                                                                         value="{{$it['value']}}"/>
                                            @endforeach
                                        </x-dynamic-component>
                                    </x-backend.form.form-group>
                                @else
                                    <x-backend.form.form-group :title="$item['name']" :inputGroup="false"
                                                               isInline="true">
                                        <x-backend.form.checkbox name="{{ $section.'_'.$key }}"
                                                                 :checked="!empty(\App\Models\Setting\Setting::get($section.'_'.$key))">
                                            {{ \App\Models\Setting\Setting::get($section.'_'.$key)}}
                                        </x-backend.form.checkbox>
                                    </x-backend.form.form-group>
                                @endif
                            @endif

                            @if($item['type'] === \App\Models\Setting\Setting::TYPE_INPUT_RADIO)
                                <x-backend.form.form-group :title="$item['name']" :inputGroup="false">
                                    <x-dynamic-component
                                        :component="(isset($item['inline']) && $item['inline'] ) ? 'backend.form.radio-inline' : 'empty' ">
                                        @foreach($item['list'] as $it)
                                            <x-backend.form.radio title="{{$it['name']}}" name="{{ $section.'_'.$key }}"
                                                                  value="{{$it['value']}}" :isFormGroup="true"
                                                                  :isRadioList="true"/>
                                        @endforeach
                                    </x-dynamic-component>
                                </x-backend.form.form-group>
                            @endif

                            @if($item['type'] === \App\Models\Setting\Setting::TYPE_SWITCH)
                                <x-backend.form.form-group :title="$item['name']" :inputGroup="false" isInline="true">
                                    <x-backend.form.switch name="'{{ $section.'_'.$key }}'"/>
                                </x-backend.form.form-group>
                            @endif

                        </div>
                        <div class="col-lg-6"></div>
                    @endforeach

                    <x-slot name="footer">
                        <button type="submit" class="btn btn-primary mr-2 px-10">
                            ثبت تغییرات
                        </button>
                    </x-slot>
                </div>
            </x-backend.card>
        </x-backend.form.form>
    </div>
@endsection
