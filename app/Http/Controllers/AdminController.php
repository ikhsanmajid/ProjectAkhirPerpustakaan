<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    //SECTION - User Management
    //ANCHOR - List Users
    public function listUsers(Request $request): View
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
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

    //ANCHOR - Edit User
    public function editUser($id): View
    {
        $user = User::findOrFail($id);
        return view('admin.management.user.edit', ['user' => $user]);
    }

    //ANCHOR - Update User
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return redirect()->route('admin.users.list')->with('success', 'User berhasil diperbarui.');
    }

    //ANCHOR - Delete User
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.list')->with('success', 'User berhasil dihapus.');
    }

    //!SECTION - User Management
}
