<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePelajars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_pelajars', function (Blueprint $table) {
            $table->bigIncrements('id_pelajar');
            $table->bigInteger('id_user')->nullable()->unsigned();
            $table->string('nama')->default(NULL);
            $table->enum('pendidikan', ['sd', 'smp', 'sma'])->nullable()->default(NULL);
            $table->string('no_telepon', 20)->nullable()->default(NULL);
            $table->string('email', 50)->nullable()->default(NULL)->unique();
            $table->string('password', 255);
            $table->string('kota')->nullable()->default(NULL);
            $table->string('provinsi')->nullable()->default(NULL);
            $table->string('alamat')->nullable()->default(NULL);
            $table->text('bio')->nullable()->default(NULL);
            $table->string('foto')->nullable()->default(NULL);
            $table->integer('is_verified')->default(0);

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('tb_pelajars');
    }
}
