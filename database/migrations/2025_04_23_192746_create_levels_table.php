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
        Schema::create('levels', function (Blueprint $table) {
            $table->id(); // id màn chơi (tự tăng)
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade');
            $table->unsignedInteger('level_number');
            $table->string('name'); // tên màn (ví dụ: màn 1, màn 2,...)
            $table->unsignedInteger('item_a_count'); // số lượng item A
            $table->unsignedInteger('item_b_count'); // số lượng item B
            $table->integer('start_x');
            $table->integer('start_y');
            $table->integer('end_x');
            $table->integer('end_y');
            $table->boolean('last')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};
