<?php

namespace Database\Seeders;

use App\Models\CRM\Customer;
use App\Models\CRM\PreInvoice;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PerInvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

//        for($i=1;$i<=20;$i++){
//            $model = new PreInvoice();
//            $model->total_price = '52.00'.$i;
//            $model->total_discount ='2.'.$i;
//            $model->tax = '9.'.$i;
//            $model->customer_id = $i;
//            $model->invoice_id = $i;
//            $model->status = rand(0,1);
//            $model->save();
//        }


    }
}
