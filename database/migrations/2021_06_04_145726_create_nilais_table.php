<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');        
            $table->integer('semester')->nullable();
            $table->integer('ipa')->nullable();
            $table->integer('ips')->nullable();
            $table->integer('bahasa')->nullable();
            $table->integer('matematika')->nullable();
            $table->integer('olahraga')->nullable();
            $table->integer('mulog')->nullable();
            $table->integer('agama')->nullable();
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
        Schema::dropIfExists('nilais');
    }
}
