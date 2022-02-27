<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::dropIfExists('pre_invoices');
        Schema::create('pre_invoices', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('total_price')->nullable();
            $table->bigInteger('total_discount')->nullable();
            $table->string('description',255)->nullable();
            $table->string('title',255)->nullable();
            $table->date('date')->nullable();
            $table->bigInteger('tax')->nullable();
            $table->bigInteger('_user_id');

            $table->tinyInteger('status' ,)->default(\App\Models\CRM\PreInvoice::STATUS_OPEN);
            $table->tinyInteger('type');
            $table->bigInteger('customer_id')->unsigned()->index();
//            $table->bigInteger('invoice_id')->unsigned()->index()->nullable();


            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
//            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE tbl_pre_invoices ADD FULLTEXT fulltext_index (description,title)');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_invoices');
    }
}
