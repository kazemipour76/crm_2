<?php

namespace Database\Seeders;

use App\Models\CRM\Customer;
use App\Models\CRM\PreInvoiceDetail;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Nette\Utils\Random;

class PerInvoiceDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        Model::unguard();
//        for($i=1;$i<=20;$i++){
//            $model = new PreInvoiceDetail();
//            $model->product_name = 'product_name'.$i;
//            $model->unit_price ='10.00'.$i;
//            $model->count = $i;
//            $model->per_invoice_id = $i;
//            $model->save();
//        }


    }
}
