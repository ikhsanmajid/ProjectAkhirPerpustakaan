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
        Schema::table("users", function (Blueprint $table) {
            $table->dropColumn("nama");
            $table->string("first_name")->after("id");
            $table->string("last_name")->after("first_name")->nullable();
            $table->string("jenis_identitas")->after("last_name");
            $table->string("nomor_identitas")->after("jenis_identitas");
            $table->string("no_hp")->after("nomor_identitas");
            $table->string("alamat")->after("nomor_identitas");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table("users", function (Blueprint $table) {
            $table->string("nama")->after("id");
            $table->dropColumn("first_name");
            $table->dropColumn("last_name");
            $table->dropColumn("jenis_identitas");
            $table->dropColumn("nomor_identitas");
            $table->dropColumn("no_hp");
            $table->dropColumn("alamat");
        });
    }
};
