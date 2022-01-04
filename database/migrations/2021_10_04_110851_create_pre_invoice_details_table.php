<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_invoice_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_name', 255);
            $table->bigInteger('unit_price');
            $table->integer('count');
            $table->bigInteger('pre_invoice_id')->unsigned()->index();
            $table->foreign('pre_invoice_id')->references('id')->on('pre_invoices')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_invoice_details');
    }
}
