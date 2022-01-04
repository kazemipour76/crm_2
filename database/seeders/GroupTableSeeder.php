<?php

namespace Database\Seeders;

use App\Models\Auth\Group;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class GroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Group::factory()->count(10)->create();
    }
}
