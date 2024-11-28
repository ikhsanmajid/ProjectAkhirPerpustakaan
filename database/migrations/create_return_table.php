<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnsTable extends Migration
{
    public function up()
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi');
            $table->date('jatuh_tempo');
            $table->integer('keterlambatan')->nullable();
            $table->string('id_buku');
            $table->string('judul_buku');
            $table->string('pengarang')->nullable();
            $table->string('penerbit')->nullable();
            $table->integer('tahun_terbit')->nullable();
            $table->string('id_anggota');
            $table->string('nama_lengkap');
            $table->string('no_hp')->nullable();
            $table->decimal('denda_keterlambatan', 8, 2)->nullable();
            $table->decimal('denda_kerusakan', 8, 2)->nullable();
            $table->decimal('denda_lainnya', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('returns');
    }
}
