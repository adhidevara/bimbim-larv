<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableHargas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_hargas', function (Blueprint $table) {
            $table->bigIncrements('id_harga');
            $table->string('kota')->default(NULL);
            $table->string('sd')->default(NULL);
            $table->string('smp')->default(NULL);
            $table->string('sma-10')->default(NULL);
            $table->string('sma-11')->default(NULL);
            $table->string('sma-12')->default(NULL);
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
        Schema::dropIfExists('tb_hargas');
    }
}
