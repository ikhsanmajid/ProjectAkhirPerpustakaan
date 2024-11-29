<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //SECTION - User Management
    //ANCHOR - List Users
    public function listUsers(Request $request): View
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                  ->orWhere('last_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('nomor_identitas', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(10)->appends($request->query());

        return view('admin.management.user.list', ['users' => $users]);
    }

    //ANCHOR - Create User
    public function createUser(Request $request): View
    {
        return view('admin.management.user.create');
    }

    //ANCHOR - Store User
    public function storeUser(Request $request, User $user): View
    {
        $user->create($request->all());
        return view('', ['user'=> $user]);
    }

    //ANCHOR - Edit User
    public function editUser($id): View
    {
        $user = User::findOrFail($id);
        // dd($user);
        return view('admin.management.user.edit', ['user' => $user]);
    }

    //ANCHOR - Update User
    public function updateUser(Request $request, $id)
    {
        $data = $request->all();

        if(isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
            // dd($data['password']);
        }

        if(isset($data['is_active'])) {
            $data['is_active'] = $data['is_active'] == 'true' ? true : false;
        }

        $validator = Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:8',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
            'jenis_identitas' => 'required|string|max:50',
            'nomor_identitas' => 'required|string|max:50',
            'role' => 'required|string|in:admin,user',
            'is_active' => 'required|boolean',
        ]);

        // dd([$request->all(), $validator->errors()]);

        if ($validator->fails()) {
            return redirect()->route('admin.users.edit', $id)
                             ->with('error', 'Terjadi kesalahan saat memperbarui user.')
                             ->withErrors($validator)
                             ->withInput();

        }

        try {
            $user = User::findOrFail($id);
            // $data = $request->all();

            if (empty($data['password'])) {
                unset($data['password']);
            }

            $user->update($data);

            return redirect()->route('admin.users.list')->with('success', 'User berhasil diperbarui.');
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->route('admin.users.edit', $id)
                             ->with('error', 'Terjadi kesalahan saat memperbarui user.')
                             ->withInput();
        }
    }

    //ANCHOR - Delete User
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.list')->with('success', 'User berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $users = User::where('first_name', 'LIKE', "%$query%")
            ->orWhere('last_name', 'LIKE', "%$query%")
            ->orWhere('email', 'LIKE', "%$query%")
            ->orWhere('id', 'LIKE', "%$query%")
            ->limit(10)
            ->get();

        return response()->json($users);
    }
    
    //!SECTION - User Management

    public function scannerView()
    {
        return view("admin.management.borrow.scanner");
    }
}
