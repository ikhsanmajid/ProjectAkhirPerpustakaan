<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnBook extends Model
{
    use HasFactory;

    protected $table = 'returns';

    protected $fillable = [
        'no_transaksi',
        'jatuh_tempo',
        'keterlambatan',
        'id_buku',
        'judul_buku',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'id_anggota',
        'nama_lengkap',
        'no_hp',
        'denda_keterlambatan',
        'denda_kerusakan',
        'denda_lainnya',
    ];
}
