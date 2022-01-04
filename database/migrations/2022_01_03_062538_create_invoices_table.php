<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::dropIfExists('invoices');
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('total_price')->nullable();
            $table->bigInteger('total_discount')->nullable();
            $table->string('description',255)->nullable();
            $table->string('title',255)->nullable();
            $table->date('date')->nullable();
            $table->bigInteger('tax',)->nullable();
            $table->tinyInteger('status',)->default(\App\Models\CRM\Invoice::STATUS_OPEN);
            $table->tinyInteger('type');
            $table->bigInteger('customer_id')->unsigned()->index();
            $table->bigInteger('pre_invoice_id')->unsigned()->index()->nullable();

            $table->foreign('pre_invoice_id')->references('id')->on('pre_invoices')->onDelete('cascade');

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
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
        Schema::dropIfExists('invoices');
    }
}
