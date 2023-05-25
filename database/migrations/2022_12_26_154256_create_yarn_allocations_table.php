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
        Schema::create('yarn_allocations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('combo_id')->unsigned();
            $table->bigInteger('fabric_id')->unsigned();
            $table->float('req_finished')->nullable();
            $table->float('req_gray')->nullable();
            $table->boolean('status')->default(true)->comment('true used false for not used');

            $table->float('yarn_received')->default(0);
            $table->float('yarn_stock')->default(0);
            $table->float('fabric_received')->default(0);
            $table->float('fabric_stock')->default(0);



            $table->bigInteger('created_by')->nullable()->unsigned();
            $table->bigInteger('updated_by')->nullable()->unsigned();
            $table->timestamps();


            $table->foreign('combo_id')->references('id')->on('combos')->onDelete('cascade');
            $table->foreign('fabric_id')->references('id')->on('fabrications')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('yarn_allocations');
    }
};
