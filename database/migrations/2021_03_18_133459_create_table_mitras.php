<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMitras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_mitras', function (Blueprint $table) {
            $table->bigIncrements('id_mitra');
            $table->bigInteger('id_user')->nullable()->unsigned();
            $table->bigInteger('id_bidang')->nullable()->unsigned();
            $table->string('nama')->default(NULL);
            $table->string('no_telepon', 20)->nullable()->default(NULL);
            $table->string('email', 50)->nullable()->default(NULL)->unique();
            $table->string('password', 255);
            $table->dateTime('tgl_lahir')->nullable()->default(NULL);
            $table->enum('jk', ['pria', 'wanita'])->nullable()->default(NULL);
            $table->string('provinsi')->nullable()->default(NULL);
            $table->string('kota')->nullable()->default(NULL);
            $table->string('kecamatan')->nullable()->default(NULL);
            $table->string('kelurahan')->nullable()->default(NULL);
            $table->string('alamat')->nullable()->default(NULL);
            $table->string('kode_pos')->nullable()->default(NULL);
            $table->string('institusi')->default(NULL);
            $table->string('prodi')->default(NULL);
            $table->string('ipk')->default(NULL);
            $table->enum('status_studi', ['lulus', 'mahasiswa aktif', 'cuti'])->nullable()->default(NULL);
            $table->string('title')->default(NULL);
            $table->text('deskripsi')->nullable()->default(NULL);
            $table->integer('tarif')->nullable()->default(NULL);
            $table->string('slug')->default(NULL);
            $table->string('foto')->nullable()->default(NULL);
            $table->string('video')->nullable()->default(NULL);
            $table->string('cv')->nullable()->default(NULL);
            $table->integer('is_verified')->default(0);

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_bidang')->references('id_bidang')->on('tb_bidangs')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('tb_mitra');
    }
}
