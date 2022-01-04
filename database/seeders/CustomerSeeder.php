<?php

namespace Database\Seeders;

use App\Models\CRM\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();


        for($i=1;$i<=20;$i++){
            $model = new Customer();
            $model->name = 'name_company'.$i;
            $model->address ='address'.$i;
            $model->phone = 'phone'.$i;
            $model->email = \Str::random(10).'@gmail.com';
            $model->nationalID = '12345678900_'.$i;
            $model->economicID = '00_'.$i;
            $model->save();
        }


    }
}
