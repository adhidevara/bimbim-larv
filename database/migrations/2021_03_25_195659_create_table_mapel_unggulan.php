<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMapelUnggulan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_mapel_unggulan', function (Blueprint $table) {
            $table->bigIncrements('id_mapel_unggulan');
            $table->bigInteger('id_mitra')->nullable()->unsigned();
            $table->string('nama_mapel')->default(NULL);
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
        Schema::dropIfExists('tb_mapel_unggulan');
    }
}
