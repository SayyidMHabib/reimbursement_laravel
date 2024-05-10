<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aju_user_id');
            $table->string('aju_user');
            $table->string('aju_jenis_data');
            $table->date('aju_tgl');
            $table->longText('aju_item')->charset('binary');
            $table->integer('aju_jumlah');
            $table->smallInteger('aju_approve_direktur');
            $table->dateTime('aju_tgl_approve_direktur');
            $table->string('aju_user_approve_direktur');
            $table->smallInteger('aju_approve_finance');
            $table->dateTime('aju_tgl_approve_finance');
            $table->string('aju_user_approve_finance');
            $table->smallInteger('aju_tolak');
            $table->dateTime('aju_tgl_tolak');
            $table->text('aju_alasan_tolak');
            $table->string('aju_user_tolak');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
