<?php

namespace Database\Seeders;

use App\Models\CRM\Customer;
use App\Models\CRM\Invoice;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class InvoiceSeeder extends Seeder
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
//            $model = new Invoice();
//            $model->total_price = '500.00'.$i;
//            $model->total_discount ='1.0'.$i;
//            $model->tax = '9.'.$i;
//            $model->status = rand(0,1);
//            $model->customer_id = $i;
            $model->save();
        }


    }
}
