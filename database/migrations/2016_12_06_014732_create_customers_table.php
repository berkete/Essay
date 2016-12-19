<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->timestamp('created_at');
            $table->integer('in');
            $table->integer('out');
            $table->text('door');
            $table->text('status');
            $table->text('company');
            $table->text('status2');
            $table->text('company2');
            $table->unsignedInteger('card_number');
            $table->text('card_holder');
            $table->increments('id');

//            $table->foreign('card_number')->references('id')->on('users')->onDelete('cascade');

//            $table->timestamps();
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->foreign('card_number')->references('id')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('customers');
    }
}
