<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::table("transactions");
        $query->select("transactions.*", "books.title", "users.first_name", "users.last_name");
        $query->join("books", "transactions.book_id", "=", "books.id");
        $query->join("users", "transactions.user_id", "=", "users.id");

        $query->where("user_id", Auth::user()->id);

        $query->orderByRaw("FIELD(status, 'menunggu')");
        $query->orderBy("tanggal_ambil", "desc");

        $result = $query->paginate(10)->appends($request->query());

        //dd($users);

        return view('user.history', ['history' => $result]);
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
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrow $borrow)
    {
        //
    }

    public function scannerView()
    {
        return view("admin.management.borrow.scanner");
    }
}
