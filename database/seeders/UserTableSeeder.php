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

        $user = new User();
        $user->id = 1;
        $user->name='admin';
        $user->email='admin@admin.com';
        $user->password= Hash::make('1234');
        $user->save();

        $user = new User();
        $user->id = 2;
        $user->name='fadakar';
        $user->email='fadakargholamreza@gmail.com';
        $user->password= Hash::make('1234');
        $user->save();


        $user = new User();
        $user->id = 3;
        $user->name='test';
        $user->email='test@gmail.com';
        $user->password= Hash::make('1234');
        $user->save();


         User::factory()->count(20)->create();

    }
}
