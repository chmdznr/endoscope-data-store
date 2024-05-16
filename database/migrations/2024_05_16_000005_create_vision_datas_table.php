<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisionDatasTable extends Migration
{
    public function up()
    {
        Schema::create('vision_datas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('trial_code');
            $table->string('name');
            $table->integer('gravidity')->nullable();
            $table->integer('parity')->nullable();
            $table->integer('age')->nullable();
            $table->string('trial_type');
            $table->datetime('time_taken');
            $table->string('file_type');
            $table->longText('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
