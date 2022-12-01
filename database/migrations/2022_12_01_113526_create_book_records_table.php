<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_records', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('u_id')->nullable();
            $table->integer('b_id')->nullable();
            $table->date('issue_date')->nullable(); 
            $table->date('return_date')->nullable();
            $table->integer('book_rent')->nullable();
            $table->integer('return_status')->nullable();
            $table->integer('actual_return_date')->nullable();





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
        Schema::dropIfExists('book_records');
    }
};
