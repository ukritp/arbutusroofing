<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->increments('id');

            $table->string('property_name');

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();

            $table->string('phone_number',10)->nullable();
            $table->string('address');
            $table->string('city',50)->nullable();
            $table->string('province',50)->nullable();
            $table->string('postalcode',6)->nullable();

            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies');

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
        Schema::drop('properties');
    }
}
