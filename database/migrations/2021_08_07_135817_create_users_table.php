<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->string('email')->unique();
            $table->text('password');
            $table->timestamps();
            $table->text('remember_token')->nullable();
            $table->text('remember_token_time_creat')->nullable();
        });
        DB::statement('ALTER TABLE tbl_users ADD FULLTEXT fulltext_index (email,name)');
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
