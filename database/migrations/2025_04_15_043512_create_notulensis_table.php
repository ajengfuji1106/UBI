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
        Schema::create('notulensis', function (Blueprint $table) {
            $table->id('id_notulensi');
            $table->unsignedBigInteger('id_rapat');
            $table->unsignedBigInteger('id_user');
            // $table->foreignId('id_rapat')->constrained('rapats', 'id_rapat')->onDelete('cascade');
            // $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            // $table->foreignId('id_user')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('judul_notulensi');
            $table->text('konten_notulensi');
            $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notulensis');
    }
};
