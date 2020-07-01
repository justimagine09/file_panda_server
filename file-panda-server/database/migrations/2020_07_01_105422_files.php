<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Files extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->timestamps();

            // Foreign keys
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('file_type_id')->unsigned();

            // constraints
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('file_type_id')->references('id')->on('file_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
