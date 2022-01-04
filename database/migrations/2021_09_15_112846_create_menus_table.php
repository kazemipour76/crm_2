<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('parent_id')->unsigned()->index()->nullable();
            $table->bigInteger('library_id')->unsigned()->index()->nullable();
            $table->string('title', 50);
            $table->string('order', 50);
            $table->string('link', 50)->nullable();
            $table->string('icon', 50)->nullable();
            $table->boolean('isBold')->default(false);
            $table->timestamps();
//            $table->foreign('parent_id')->references('id')->on('parent')->onDelete('cascade');
//            $table->foreign('permission_id')->references('id')->on('permission')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
