<?php

use App\Models\Setting\Setting;
/**
 * Setting::TYPE_CHECKBOX
 * Setting::TYPE_TEXT
 * Setting::TYPE_URl
 * Setting::TYPE_TEXTAREA
 * Setting::TYPE_RADIO
 * Setting::TYpe_SELECT
 */

return [
    'kazemi' => [
        'name' => 'kazmi',
        'icon' => 'fa-rocket',
        'children' => [
            'ali' => ['type' => Setting::TYPE_TEXTAREA, 'name' => 'علی' , 'default' => 'ali de'],
        ]
    ],

    'media' => [
        'name' => 'مدیا',
        'icon' => 'fa-video',
        'children' => [
            'key' => ['type' => Setting::TYPE_INPUT_TEXT, 'name' => 'عنوان عکس ها'],
            'salam' => ['type' => Setting::TYPE_INPUT_TEXT, 'name' => 'تست سلام'],

        ]
    ],

    'general' => [
        'name' => 'عمومی',
        'icon' => 'fa-cogs',
        'children' => [
            'site_name' => ['type' => Setting::TYPE_INPUT_TEXT, 'name' => 'عنوان سایت' , 'default' => 'My Site'],
            'site_url' => ['type' => Setting::TYPE_INPUT_URL, 'name' => 'ادرس سایت' ],
            'site_email' => ['type' => Setting::TYPE_INPUT_EMAIL, 'name' => 'ایمیل سایت' ],
            'site_color' => ['type' => Setting::TYPE_INPUT_COLOR, 'name' => 'غیر رنگ' ],
            'admin_prefix' => ['type' => Setting::TYPE_INPUT_TEXT, 'name' => 'ادرس ورود به ادمین' , 'default' => 'sadmin'],
            'isPost' => ['type' => Setting::TYPE_CHECKBOX, 'name' => 'ایا پست ها در صفحه اول نمایش داده شود؟'],
            'isComment' => ['type' => Setting::TYPE_SWITCH, 'name' => 'آیا کامنت ها نمایش داده شود؟'],
            'description' => ['type' => Setting::TYPE_TEXTAREA, 'name' => 'نوضیحات متا صفحه اول' , 'default' => 'salam desc',],
            'test' => [
                'type' => Setting::TYPE_SELECT,
                'name' => 'نست توضیحات',
                'default' => 2,
                'list' => [
                    ['value' => 1 , 'name' => 'انتخاب اول'],
                    ['value' => 2 , 'name' => 'انتخاب دوم'],
                    ['value' => 3 , 'name' => 'انتخاب سوم'],
                ]
            ],

            'radio' => [
                'type' => Setting::TYPE_INPUT_RADIO,
                'default' => 1,
                'name' => 'نست توضیحات',
                'inline'=>true,
                'list' => [
                    ['value' => 1 , 'name' => 'انتخاب اول'],
                    ['value' => 2 , 'name' => 'انتخاب دوم'],
                    ['value' => 3 , 'name' => 'انتخاب سوم'],
                ]
            ],

            'checkbox' => [
                'type' => Setting::TYPE_CHECKBOX,
                'default' => 1,
                'name' => 'نست توضیحات',
//                'inline'=>true,
                'list' => [
                    ['value' => 1 , 'name' => 'انتخاب اول'],
                    ['value' => 2 , 'name' => 'انتخاب دوم'],
                    ['value' => 3 , 'name' => 'انتخاب سوم'],
                ]
            ],
        ]
    ],

    'footer' => [
        'name' => 'پا صفحه',
        'icon' => 'fa-wrench',
        'children' => [
            'copyright' => ['type' => Setting::TYPE_CHECKBOX, 'name' => 'input form group name'],
        ]
    ],

];
