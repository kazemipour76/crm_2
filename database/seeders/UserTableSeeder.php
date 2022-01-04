<?php

namespace Database\Seeders;

use App\Models\Auth\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        User::factory()->count(100)->create();
        $user = new User();
        $user->name='admin';
        $user->email='admin@admin.com';
        $user->password= Hash::make('1234');
        $user->save();
    }
}
