<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Book;
use App\Models\Borrow;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BorrowController extends Controller
{
    //Admin
    public function index()
    {
        return view("admin.management.borrow.index");
    }

    public function show(Request $request)
    {
        $transaction = DB::table("transactions")
            ->join("books", "transactions.book_id", "=", "books.id")
            ->join("users", "transactions.user_id", "=", "users.id")
            ->select("transactions.id as trx_id", "transactions.*", "books.*", "users.*")
            ->where("transactions.id", $request->id)
            ->first();

        //dd($transaction);
        return view("admin.management.borrow.updateScanner", ["data" => $transaction]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeAdmin(Request $request)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Borrow $borrow)
    {
        //
        $updateDataTrx = Transaction::find($request->id);
        $updateDataTrx->status = "dipinjam";
        $updateDataTrx->tanggal_ambil = date("Y-m-d");
        $updateDataTrx->save();

        if ($updateDataTrx) {
            return response()->json([
                "message" => "Update Status Buku Berhasil",
                "status" => "success"
            ]);
        } else {
            return response()->json([
                "message" => "Update Status Buku Gagal",
                "status" => "failed"
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrow $borrow)
    {
        //
    }


    // User
    public function storeUser(Request $request)
    {
        //
        $validated = $request->validate([
            "id_user" => "required",
            "id_buku" => "required",
            "rencana_tanggal_pinjam" => "required",
            "rencana_tanggal_kembali" => "required"
        ]);

        $check_user_menunggu_pinjam = Transaction::where('user_id', $validated['id_user'])
            ->where(function ($query) {
                $query->where('status', 'menunggu')
                    ->orWhere('status', 'dipinjam');
            })
            ->first();

        if ($check_user_menunggu_pinjam !== null) {
            return response()->json([
                "message" => "User Maksimal meminjam 1 buku",
                "status" => "failed"
            ]);
        }

        $transaction = Transaction::create([
            "user_id" => $validated["id_user"],
            "book_id" => $validated["id_buku"],
            "rencana_ambil" => $validated["rencana_tanggal_pinjam"],
            "rencana_kembali" => $validated["rencana_tanggal_kembali"]
        ]);

        if ($transaction) {
            $available_book = Book::find($validated["id_buku"]);

            if ($available_book->available_quantity <= 0) {
                return response()->json([
                    "message" => "Stok Buku 0",
                    "status" => "failed",
                ]);
            }

            $available_book->available_quantity = $available_book->available_quantity - 1;
            $available_book->save();

            return response()->json([
                "message" => "Buku berhasil dipinjam",
                "status" => "success",
                "data" => $transaction
            ]);
        } else {
            return response()->json([
                "message" => "Buku gagal dipinjam",
                "status" => "failed"
            ]);
        }
    }

    public function storeUserFromAdmin(Request $request)
    {
        //
        $validated = $request->validate([
            "id_user" => "required",
            "id_buku" => "required",
            "tanggal_pinjam" => "required",
            "rencana_tanggal_kembali" => "required"
        ]);

        $check_user_menunggu_pinjam = Transaction::where('user_id', $validated['id_user'])
            ->where(function ($query) {
                $query->where('status', 'menunggu')
                    ->orWhere('status', 'dipinjam');
            })
            ->first();

        if ($check_user_menunggu_pinjam !== null) {
            return response()->json([
                "message" => "User Maksimal meminjam 1 buku",
                "status" => "failed"
            ]);
        }

        DB::beginTransaction();

        try {
            $transaction = Transaction::create([
                "user_id" => $validated["id_user"],
                "book_id" => $validated["id_buku"],
                "status" => "dipinjam",
                "rencana_ambil" => $validated["tanggal_pinjam"],
                "tanggal_ambil" => $validated["tanggal_pinjam"],
                "rencana_kembali" => $validated["rencana_tanggal_kembali"]
            ]);

            if ($transaction) {
                $available_book = Book::findOrFail($validated["id_buku"]);

                if ($available_book->available_quantity <= 0) {
                    throw new Exception("Stok Buku 0");
                }

                $available_book->available_quantity = $available_book->available_quantity - 1;
                $available_book->save();

                DB::commit();

                return response()->json([
                    "message" => "Buku berhasil dipinjam",
                    "status" => "success",
                    "data" => $transaction
                ]);
                
            } else {
                throw new Exception("Buku Gagal Dipinjam");
            }
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                "message" => "Buku Tidak Ditemukan",
                "status" => "failed"
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                "message" => $e->getMessage(),
                "status" => "failed"
            ]);
        }
    }
}
