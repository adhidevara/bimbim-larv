<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableReviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_reviews', function (Blueprint $table) {
            $table->bigIncrements('id_review');
            $table->bigInteger('id_pelajar')->nullable()->unsigned();
            $table->bigInteger('id_mitra')->nullable()->unsigned();
            $table->string('pesan')->default(NULL);
            $table->string('rate')->default(NULL);
            $table->timestamp('tgl_review')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->enum('status', array('show','hidden'))->nullable()->default('show');
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
        Schema::dropIfExists('tb_reviews');
    }
}
