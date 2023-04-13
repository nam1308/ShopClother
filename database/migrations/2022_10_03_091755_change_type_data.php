<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->bigInteger('id_user')->nullable()->change();
            // $table->foreign('id_user')->references('id')->on('users');
            // $table->foreign('id_customer')->references('id')->on('users');
        });
        Schema::table('order_details', function (Blueprint $table) {
            $table->bigInteger('id_order')->change();
            $table->bigInteger('id_product')->change();
            // $table->foreign('id_order')->references('id')->on('orders');
            // $table->foreign('id_product')->references('id')->on('product_detail');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->bigInteger('category')->change();
            $table->bigInteger('type')->change();
            $table->bigInteger('brand')->change();
            $table->bigInteger('supplier')->change();
            // $table->foreign('category')->references('id')->on('categories');
            // $table->foreign('type')->references('id')->on('type');
            // $table->foreign('brand')->references('id')->on('brands');
            // $table->foreign('supplier')->references('id')->on('suppliers');
        });
        Schema::table('product_detail', function (Blueprint $table) {
            $table->bigInteger('id_product')->change();
            $table->bigInteger('id_color')->change();
            // $table->foreign('id_product')->references('id')->on('products');
            // $table->foreign('id_color')->references('id')->on('color');
        });
        Schema::table('rate', function (Blueprint $table) {
            $table->bigInteger('id_product')->change();
            $table->bigInteger('id_customer')->change();
            // $table->foreign('id_product')->references('id')->on('products');
            // $table->foreign('id_customer')->references('id')->on('users');
        });
        Schema::table('bills', function (Blueprint $table) {
            $table->bigInteger('id_user')->change();
            $table->bigInteger('customer')->change();
            // $table->foreign('id_user')->references('id')->on('users');
            // $table->foreign('customer')->references('id')->on('users');
        });
        Schema::table('discount_detail', function (Blueprint $table) {
            $table->bigInteger('id_discount')->change();
            // $table->foreign('id_discount')->references('id')->on('discount');
        });
        Schema::table('discount_user', function (Blueprint $table) {
            $table->bigInteger('id_customer')->change();
            $table->bigInteger('id_discount')->change();
            // $table->foreign('id_customer')->references('id')->on('users');
            // $table->foreign('id_discount')->references('id')->on('discount');
        });
        Schema::table('favorite', function (Blueprint $table) {
            $table->bigInteger('id_product')->change();
            $table->bigInteger('id_customer')->change();
            // $table->foreign('id_product')->references('id')->on('products');
            // $table->foreign('id_customer')->references('id')->on('users');
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
