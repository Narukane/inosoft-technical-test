<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMotorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('motor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kendaraan');
            $table->foreign('id_kendaraan')->references('_id')->on('kendaraan')->onDelete('cascade');
            $table->string('mesin');
            $table->string('tipe_suspensi');
            $table->string('tipe_transmisi');
            $table->integer('stock')->default(0);
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
        Schema::dropIfExists('motor');
    }
}
