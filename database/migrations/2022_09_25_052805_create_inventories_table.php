<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    use SoftDeletes;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('style_id')->unsigned();
            $table->bigInteger('accessories_id')->unsigned();
            $table->bigInteger('color_id')->nullable()->unsigned();
            $table->bigInteger('size_id')->nullable()->unsigned();
            $table->float('garments_quantity')->default(0);
            $table->float('requered_quantity')->default(0);
            $table->float('received_quantity')->default(0);
            $table->float('stock_quantity')->default(0);
            // new
            $table->float('consumption')->nullable();
            $table->string('bar_or_ean_code')->nullable();
            $table->float('tolerance')->default(0);

            $table->bigInteger('created_by')->nullable()->unsigned();
            $table->bigInteger('updated_by')->nullable()->unsigned();
            // foraign key reference
            $table->foreign('style_id')->references('id')->on('styles')->onDelete('cascade');
            $table->foreign('accessories_id')->references('id')->on('accessories')->onDelete('cascade');
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('cascade');
            $table->foreign('size_id')->references('id')->on('sizes')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('inventories');
    }
};
