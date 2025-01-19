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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');                  // Judul buku
            $table->string('author');                 // Penulis buku
            $table->string('isbn')->unique();         // ISBN buku dengan nilai unik
            $table->string('publisher');              // Penerbit buku
            $table->integer('publication_year');      // Tahun terbit buku
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Foreign key ke tabel categories
            $table->integer('total_quantity');        // Jumlah total buku
            $table->integer('available_quantity');    // Jumlah buku yang tersedia
            $table->text('description')->nullable();  // Deskripsi buku, opsional
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
