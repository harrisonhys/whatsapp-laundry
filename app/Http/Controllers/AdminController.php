<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::withCount('pesanan')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_admin' => 'required|string|max:255',
            'email' => 'required|string|email|unique:admins,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        Admin::create([
            'nama_admin' => $request->nama_admin,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.index')
            ->with('success', 'Admin berhasil ditambahkan');
    }

    public function show(Admin $admin)
    {
        $admin->load('pesanan.pelanggan');
        return view('admin.show', compact('admin'));
    }

    public function edit(Admin $admin)
    {
        return view('admin.edit', compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'nama_admin' => 'required|string|max:255',
            'email' => 'required|string|email|unique:admins,email,' . $admin->id_admin . ',id_admin',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'nama_admin' => $request->nama_admin,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.index')
            ->with('success', 'Admin berhasil diupdate');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->route('admin.index')
            ->with('success', 'Admin berhasil dihapus');
    }
}
