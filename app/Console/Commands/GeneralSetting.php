<?php

namespace App\Console\Commands;

use App\Models\Setting\Setting;
use Illuminate\Console\Command;

class GeneralSetting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'platform:setting:fresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fresh all setting in platform';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $settings = config('platform.setting');
        $list = [];
        Setting::orderBy('key')->delete();
        foreach($settings as $key => $section)
        {
            foreach ($section['children'] as $childKey => $item) {
                $dbKey =  $key.'_'.$childKey;
                $dbValue =  $item['default'] ?? '';
                $model = new Setting();
                $model->key = $dbKey;
                $model->value = $dbValue;
               if($model->save())
               {
                   $this->info("Created Setting key[{$dbKey}] = '{$dbValue}'");
               }
               else
               {
                   $this->error("Not create Setting key[{$dbKey}] = '{$dbValue}'");
               }

            }
        }

        return 0;
    }
}
