<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('style_id')->unsigned();
            $table->integer('effected_accessories')->default(1);
            $table->string('effected_inventory_ids')->nullable();
            $table->string('message');
            $table->integer('type')->default(0)->comment('0 for Insert 1 for Update');
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->nullable()->unsigned();
            $table->bigInteger('received_by')->default(1)->unsigned();
            $table->boolean('status')->default(0)->comment('0 for unread 1 for read');
             // foraign key reference
             $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
             $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
             $table->foreign('received_by')->references('id')->on('users')->onDelete('cascade');
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
        //
    }
};
