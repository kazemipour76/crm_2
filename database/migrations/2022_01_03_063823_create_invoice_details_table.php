<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::dropIfExists('invoice_details');

        Schema::create('invoice_details', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('product_name', 255);
            $table->bigInteger('unit_price');
            $table->integer('count');
            $table->bigInteger('invoice_id')->unsigned()->index();
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE tbl_invoice_details ADD FULLTEXT fulltextsearch (product_name)');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_details');
    }
}
