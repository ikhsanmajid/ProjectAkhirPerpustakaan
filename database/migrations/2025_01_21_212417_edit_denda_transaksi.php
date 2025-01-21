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
        Schema::table("transactions", function(Blueprint $table) {
            $table->dropColumn("denda");
            $table->decimal("denda_keterlambatan", 8, 2)->after("status")->default(0);
            $table->decimal("denda_kerusakan", 8, 2)->after("denda_keterlambatan")->default(0);;
            $table->decimal("denda_lainnya", 8, 2)->after("denda_kerusakan")->default(0);;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table("transactions", function(Blueprint $table) {
            $table->double("denda");
            $table->dropColumn("denda_keterlambatan");
            $table->dropColumn("denda_kerusakan");
            $table->dropColumn("denda_lainnya");
        });
    }
};
