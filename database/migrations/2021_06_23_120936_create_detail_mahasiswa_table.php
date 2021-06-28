<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailmahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
    */
    public function up()
    {
        Schema::create('detail_mahasiswas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone', 16);
            $table->text('alamat')->nullable($value = true);
            $table->text('foto')->nullable($value = true);
            $table->integer('mahasiswa_id')->unsigned();
            $table->timestamps();


            $table->foreign('mahasiswa_id')
            ->references('id')
            ->on('mahasiswas')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detailmahasiswa');
    }
}
