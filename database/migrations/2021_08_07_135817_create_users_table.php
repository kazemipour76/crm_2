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
            $table->string('name_en', 50)->nullable();
            $table->string('name_image', 50)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('nationalID', 50)->nullable();
            $table->string('economicID', 50)->nullable();
            $table->string('registration_number', 50)->nullable();
            $table->string('email')->unique();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('last_blocked_at')->nullable();
            $table->tinyInteger('user_type')->default(\App\Models\Auth\User::USER_NORMAL);
            $table->tinyInteger('user_block')->default(\App\Models\Auth\User::USER_UNBLOCK);

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
