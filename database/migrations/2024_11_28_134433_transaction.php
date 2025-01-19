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
        //
        Schema::create("transactions", function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("user_id");
            $table->foreign("user_id")->references("id")->on("users")->onDelete("restrict");
            $table->foreignId("book_id")->constrained()->onDelete("restrict");
            $table->date("rencana_ambil");
            $table->date("tanggal_ambil")->nullable();
            $table->date("rencana_kembali");
            $table->date("tanggal_kembali")->nullable();
            $table->enum("status", ["dipinjam", "dikembalikan", "batal", "menunggu"])->default("menunggu");
            $table->float("denda")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists("transaction");
    }
};
