<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumActiveToTabelIntrucetionAndDiscount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('introduces', function (Blueprint $table) {
            $table->integer('active')->default(0);
        });
        Schema::table('discount', function (Blueprint $table) {
            $table->integer('show')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tabel_intrucetion_and_discount', function (Blueprint $table) {
            //
        });
    }
}
