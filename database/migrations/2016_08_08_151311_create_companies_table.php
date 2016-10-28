<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');

            $table->string('company_name')->nullable();
            $table->string('label')->nullable();

            $table->string('first_name');
            $table->string('last_name');

            $table->string('phone_number',10)->nullable();
            $table->string('address')->nullable();
            $table->string('city',50)->nullable();
            $table->string('province',50)->nullable();
            $table->string('postalcode',6)->nullable();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::drop('companies');
    }
}
