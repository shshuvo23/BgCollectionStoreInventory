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
        Schema::create('export_calenders', function (Blueprint $table) {
            $table->id();
            $table->string('job_no');
            $table->bigInteger('buyer_id')->unsigned();
            $table->string('merchandiser');
            $table->text('fabrication');
            $table->string('order_no');
            $table->integer('order_qty');
            $table->float('unit_price');
            $table->float('total');
            $table->date('month');
            $table->bigInteger('status_id')->unsigned()->nullable();

            $table->timestamps();

            $table->foreign('buyer_id')->references('id')->on('buyers');
            $table->foreign('status_id')->references('id')->on('calender_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('export_calenders');
    }
};
