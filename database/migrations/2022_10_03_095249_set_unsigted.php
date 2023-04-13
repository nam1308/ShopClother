<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetUnsigted extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->bigInteger('id_user')->unsigned()->nullable()->change();
            $table->bigInteger('id_customer')->unsigned()->nullable()->change();
        });
        Schema::table('order_details', function (Blueprint $table) {
            $table->bigInteger('id_order')->unsigned()->change();
            $table->bigInteger('id_product')->unsigned()->change();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->bigInteger('category')->unsigned()->change();
            $table->bigInteger('type')->unsigned()->change();
            $table->bigInteger('brand')->unsigned()->change();
            $table->bigInteger('supplier')->unsigned()->change();
        });
        Schema::table('product_detail', function (Blueprint $table) {
            $table->bigInteger('id_product')->unsigned()->change();
            $table->bigInteger('id_color')->unsigned()->change();
        });
        Schema::table('rate', function (Blueprint $table) {
            $table->bigInteger('id_product')->unsigned()->change();
            $table->bigInteger('id_customer')->unsigned()->change();
        });
        Schema::table('bills', function (Blueprint $table) {
            $table->bigInteger('id_user')->unsigned()->change();
            $table->bigInteger('customer')->unsigned()->change();
        });
        Schema::table('discount_detail', function (Blueprint $table) {
            $table->bigInteger('id_discount')->unsigned()->change();
        });
        Schema::table('discount_user', function (Blueprint $table) {
            $table->bigInteger('id_customer')->unsigned()->change();
            $table->bigInteger('id_discount')->unsigned()->change();
        });
        Schema::table('favorite', function (Blueprint $table) {
            $table->bigInteger('id_product')->unsigned()->change();
            $table->bigInteger('id_customer')->unsigned()->change();
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
