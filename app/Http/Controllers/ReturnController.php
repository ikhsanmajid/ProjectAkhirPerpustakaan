<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ReturnBook;

class ReturnController extends Controller
{
    public function create()
    {
        // Mengarahkan ke folder return dan file index.blade.php
        return view('return.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_transaksi' => 'required|string|max:255',
            'jatuh_tempo' => 'required|date',
            'keterlambatan' => 'nullable|integer',
            'id_buku' => 'required|string|max:255',
            'judul_buku' => 'required|string|max:255',
            'pengarang' => 'nullable|string|max:255',
            'penerbit' => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|integer',
            'id_anggota' => 'required|string|max:255',
            'nama_lengkap' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:15',
            'denda_keterlambatan' => 'nullable|numeric',
            'denda_kerusakan' => 'nullable|numeric',
            'denda_lainnya' => 'nullable|numeric',
        ]);

        ReturnBook::create($validated);
        return redirect()->route('return.create')->with('success', 'Data return berhasil disimpan.');
    }
}
