<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\ReturnBook;
use App\Models\Transaction;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class ReturnController extends Controller
{
    public function index(Request $request)
    {
        if ($request->filled("member_id")) {
            $querySql = Transaction::join('books', 'transactions.book_id', '=', 'books.id')
                ->join('users', 'transactions.user_id', '=', 'users.id')
                ->select('transactions.*', 'users.first_name', 'users.last_name', 'books.title', 'books.publisher', 'books.author', 'books.publication_year', 'books.isbn', 'users.email', 'users.no_hp', 'users.jenis_identitas', 'users.nomor_identitas');

            $validated = $request->validate([
                "member_id" => "required",
                "full_name" => "required",
                "phone" => "required",
                "start_date" => "nullable",
                "end_date" => "nullable"
            ]);

            //dd($validated);

            $querySql->where('user_id', $validated['member_id']);

            if (isset($validated["start_date"])) {
                $querySql->whereBetween('tanggal_ambil', [DateTime::createFromFormat('d-m-Y', $validated['start_date'])->format('Y-m-d'), DateTime::createFromFormat('d-m-Y', $validated['end_date'])->format('Y-m-d')]);
            }

            $querySql->orderBy('tanggal_ambil', 'desc');

            $result = $querySql->paginate(10)->appends($request->query());
            // Mengarahkan ke folder return dan file index.blade.php
            return view('admin.management.return.index', [
                "query" => $validated,
                "data" => $result
            ]);
        } else {
            $validated = $request->validate([
                "start_date" => "nullable",
                "end_date" => "nullable"
            ]);

            $querySql = Transaction::join('books', 'transactions.book_id', '=', 'books.id')
                ->join('users', 'transactions.user_id', '=', 'users.id')
                ->select('transactions.*', 'users.first_name', 'users.last_name', 'books.title', 'books.publisher', 'books.author', 'books.publication_year', 'books.isbn', 'users.email', 'users.no_hp', 'users.jenis_identitas', 'users.nomor_identitas');

            //dd($validated);

            $querySql->orderBy('tanggal_ambil', 'desc');

            if (isset($validated["start_date"])) {
                $querySql->whereBetween('tanggal_ambil', [DateTime::createFromFormat('d-m-Y', $validated['start_date'])->format('Y-m-d'), DateTime::createFromFormat('d-m-Y', $validated['end_date'])->format('Y-m-d')]);
            }

            $result = $querySql->paginate(10)->appends($request->query());
            // Mengarahkan ke folder return dan file index.blade.php
            return view('admin.management.return.index', [
                "query" => $validated,
                "data" => $result
            ]);
        }
    }

    public function updateReturn(Request $request, Transaction $transaction, Book $book)
    {

        $validated = $request->validate([
            'late' => 'nullable',
            'id_buku' => 'required',
            'denda_keterlambatan' => 'nullable',
            'denda_kerusakan' => 'nullable',
            'denda_lainnya' => 'nullable',
            'method' => 'required'
        ]);

        DB::beginTransaction();

        try {
            if ($validated['method'] == 'kembali') {
                $updatePengembalian = $transaction->where('id', $request->id)
                    ->update([
                        'tanggal_kembali' => Carbon::now()->timezone('Asia/Jakarta'),
                        'status' => 'dikembalikan',
                        'denda_keterlambatan' => $validated['denda_keterlambatan'],
                        'denda_kerusakan' => $validated['denda_kerusakan'],
                        'denda_lainnya' => $validated['denda_lainnya'],
                        'late' => $validated['late']
                    ]);

                if ($updatePengembalian) {
                    $available_book = Book::findOrFail($validated['id_buku']);
                    $available_book->available_quantity = $available_book->available_quantity + 1;
                    $available_book->save();

                    DB::commit();

                    return response()->json([
                        "message" => "Pengembalian Buku Berhasil",
                        "status" => "success"
                    ]);
                }
            } else {
                $updatePengembalian = $transaction->where('id', $request->id)
                    ->update([
                        'status' => 'batal',
                        'late' => $validated['late']
                    ]);

                if ($updatePengembalian) {
                    $available_book = Book::findOrFail($validated['id_buku']);
                    $available_book->available_quantity = $available_book->available_quantity + 1;
                    $available_book->save();

                    DB::commit();

                    return response()->json([
                        "message" => "Pembatalan Peminjaman Buku Berhasil",
                        "status" => "success"
                    ]);
                }
            }

            return response()->json([
                "message" => "Pengembalian Buku Gagal",
                "status" => "failed"
            ]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                "message" => "Buku Tidak Ditemukan",
                "status" => "failed"
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                "message" => "Terjadi Kesalahan Server " . $e->getMessage(),
                "status" => "failed"
            ]);
        }
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
