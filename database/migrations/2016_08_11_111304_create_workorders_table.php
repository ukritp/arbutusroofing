<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workorders', function (Blueprint $table) {
            $table->increments('id');

            $table->text('description');
            $table->string('workorder_number', 50)->nullable();

            $table->string('tenant_first_name')->nullable();
            $table->string('tenant_last_name')->nullable();
            $table->string('tenant_phone_number', 10)->nullable();

            $table->integer('property_id')->unsigned();
            $table->foreign('property_id')->references('id')->on('properties');

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
        Schema::drop('workorders');
    }
}
