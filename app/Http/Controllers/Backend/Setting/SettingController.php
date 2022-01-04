<?php

namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting\Setting;
use App\Utilities\MessageBag;
use Illuminate\Support\Facades\Cache;


class SettingController extends Controller
{

    public function edit($section)
    {
        $settingConfig = config('platform.setting');
        if (isset($settingConfig[$section])) {
            $pageSetting = $settingConfig[$section];
            $data['section'] = $section;
            $data['setting'] = $pageSetting;
            return view("backend.setting.edit", $data);
        } else {
            return redirect()->back();
        }
    }

    public function update($section)
    {
        $configSetting = config('platform.setting')[$section]['children'];
        $all = request()->except('_token');
        Cache::forget(Setting::CACHE_KEY);

        foreach ($configSetting as $key => $setting) {

            $value = null;
            if (isset($all[$section.'_'.$key])) {
                $value = $all[$section.'_'.$key];
            }
            $model = Setting::findOrFail($section.'_'.$key);
            $model->value = $value;
            $model->save();
        }


        MessageBag::push('تنظیمات با موفقیت تغییر کرد', MessageBag::TYPE_SUCCESS);
        return redirect()->back();
    }


}
