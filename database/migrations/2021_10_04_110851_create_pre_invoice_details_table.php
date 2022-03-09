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
//        Schema::dropIfExists('pre_invoice_details');
//
        Schema::create('pre_invoice_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_name', 50);
            $table->string('unit_price');
            $table->integer('count');
            $table->bigInteger('pre_invoice_id')->unsigned()->index();
            $table->foreign('pre_invoice_id')->references('id')
                ->on('pre_invoices')->onDelete('cascade');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE tbl_pre_invoice_details ADD FULLTEXT
    fulltextsearch (product_name)');

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
