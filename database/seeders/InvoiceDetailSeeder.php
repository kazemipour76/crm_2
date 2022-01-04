<?php

namespace Database\Seeders;

use App\Models\CRM\Customer;
use App\Models\CRM\InvoiceDetail;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetailSeeder extends Seeder
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
            $model = new InvoiceDetail();
//            $model-> product_name= 'product_name'.$i;
//            $model->unit_price ='10.00'.$i;
//            $model->count = $i;
//            $model->invoice_id = $i;
            $model->save();
        }


    }
}
