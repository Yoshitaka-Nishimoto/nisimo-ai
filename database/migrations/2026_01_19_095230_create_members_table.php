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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('rank'); // ランク（初級、中級、上級）
            $table->string('rubber'); // 使用ラバー
            $table->string('style'); // 戦型
            $table->string('photo_path')->nullable(); // 顔写真のパス
            $table->float('win_rate')->default(0); // 勝率
            $table->date('last_visit_date')->nullable(); // 最終来館日
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
