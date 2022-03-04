<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
//            $table->string('id', '30')->primary()->unique();
            $table->string('name', 50);
            $table->string('address', 255)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('nationalID', 50)->nullable();
            $table->string('economicID', 50)->nullable();
            $table->tinyInteger('entity',)->default(\App\Models\CRM\Customer::LEGAL);
            $table->bigInteger('_user_id');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE tbl_customers ADD FULLTEXT fulltext_index (economicID,nationalID,email,phone,name,address)');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
