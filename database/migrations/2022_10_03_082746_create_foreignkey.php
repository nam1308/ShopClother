<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignkey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('orders', function (Blueprint $table) {
        //     $table->foreign('id_user')->references('id')->on('users');
        //     $table->foreign('id_customer')->references('id')->on('users');
        // });
        // Schema::table('order_details', function (Blueprint $table) {
        //     $table->foreign('id_order')->references('id')->on('orders');
        //     $table->foreign('id_product')->references('id')->on('product_detail');
        // });
        // Schema::table('products', function (Blueprint $table) {
        //     $table->foreign('category')->references('id')->on('categories');
        //     $table->foreign('type')->references('id')->on('type');
        //     $table->foreign('brand')->references('id')->on('brands');
        //     $table->foreign('supplier')->references('id')->on('suppliers');
        // });
        // Schema::table('product_detail', function (Blueprint $table) {
        //     $table->foreign('id_product')->references('id')->on('products');
        //     $table->foreign('id_color')->references('id')->on('color');
        // });
        Schema::table('product_size', function (Blueprint $table) {
            $table->foreign('id_productdetail')->references('id')->on('product_detail');
            $table->foreign('size')->references('id')->on('size');
        });
        Schema::table('rate', function (Blueprint $table) {
            $table->foreign('id_product')->references('id')->on('products');
            $table->foreign('id_customer')->references('id')->on('users');
        });
        Schema::table('bills', function (Blueprint $table) {
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('customer')->references('id')->on('users');
        });
        Schema::table('discount_detail', function (Blueprint $table) {
            $table->foreign('id_discount')->references('id')->on('discount');
        });
        Schema::table('discount_user', function (Blueprint $table) {
            $table->foreign('id_customer')->references('id')->on('users');
            $table->foreign('id_discount')->references('id')->on('discount');
        });
        Schema::table('favorite', function (Blueprint $table) {
            $table->foreign('id_product')->references('id')->on('products');
            $table->foreign('id_customer')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('foreignkey');
    }
}
