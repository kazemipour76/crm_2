<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLibraryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('libraries', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            // --------- file info ----------------
            $table->string('file_name');
            $table->string('ext');
            $table->string('folder');
            $table->string('path');
            $table->string('size');
            // --------- file info ----------------

            $table->string('title');//name file
            $table->text('caption')->nullable();//pasvnd
            $table->text('description')->nullable();//pasvnd
            $table->string('slug')->nullable();//
            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE tbl_libraries ADD FULLTEXT fulltext_index (file_name,title,caption,description)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('libraries');
    }
}
