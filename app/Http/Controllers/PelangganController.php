<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::withCount('pesanan')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('pelanggan.index', compact('pelanggan'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|unique:pelanggan,nomor_telepon',
            'alamat' => 'nullable|string',
            'email' => 'nullable|email|unique:pelanggan,email',
        ]);

        Pelanggan::create($request->only('nama', 'nomor_telepon', 'alamat', 'email'));

        return redirect()->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil ditambahkan');
    }

    public function show(Pelanggan $pelanggan)
    {
        $pelanggan->load('pesanan.admin');
        return view('pelanggan.show', compact('pelanggan'));
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255',
                'nomor_telepon' => 'required|string|unique:pelanggan,nomor_telepon,' . $pelanggan->id_pelanggan . ',id_pelanggan',
                'alamat' => 'nullable|string',
                'email' => 'nullable|email|unique:pelanggan,email,' . $pelanggan->id_pelanggan . ',id_pelanggan',
            ]);

            $pelanggan->update($request->only('nama', 'nomor_telepon', 'alamat', 'email'));

            return redirect()->route('pelanggan.index')
                ->with('success', 'Pelanggan berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();
        return redirect()->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil dihapus');
    }
}
