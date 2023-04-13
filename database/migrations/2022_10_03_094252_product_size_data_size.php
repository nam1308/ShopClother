<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductSizeDataSize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('product_size', function (Blueprint $table) {
            $table->bigInteger('id_productdetail')->change();
            $table->bigInteger('size')->change();
            // $table->foreign('id_productdetail')->references('id')->on('product_detail');
            // $table->foreign('size')->references('id')->on('size');
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
