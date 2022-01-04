<?php

namespace Database\Seeders;

use App\Http\Controllers\Backend\CMS\MenuController;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserTableSeeder::class,
            GroupTableSeeder::class,
            MenuSeeder::class,
            CustomerSeeder::class,
        ]);
    }
}
