<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_events', function (Blueprint $table) {
            $table->bigIncrements('id_event');
            $table->bigInteger('id_bidang')->nullable()->unsigned();
            $table->string('title')->default(NULL);
            $table->text('deskripsi')->nullable()->default(NULL);
            $table->string('slug')->default(NULL);
            $table->string('nama_cp')->nullable()->default(NULL);
            $table->string('telp_cp')->nullable()->default(NULL);
            $table->string('foto')->nullable()->default(NULL);
            $table->string('video')->nullable()->default(NULL);
            $table->string('lokasi')->nullable()->default(NULL);
            $table->string('regis_link')->nullable()->default(NULL);
            $table->string('sertif_link')->nullable()->default(NULL);
            $table->string('event_link')->nullable()->default(NULL);
            $table->dateTime('start_tgl_event')->nullable()->default(NULL);
            $table->dateTime('end_tgl_event')->nullable()->default(NULL);
            $table->string('price')->nullable()->default(NULL);
            $table->enum('event_type', ['online', 'offline'])->nullable()->default(NULL);
            $table->string('isPaid')->default(0);
            $table->integer('is_verified')->default(0);

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
        Schema::dropIfExists('tb_events');
    }
}
