<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Golongan;
use App\Http\Requests\PegawaiRequest;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawai = Pegawai::with('golongan')->paginate(10);
        return view('pegawai.index', compact('pegawai'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $golongan = Golongan::all();
        return view('pegawai.create', compact('golongan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PegawaiRequest $request)
    {
        Pegawai::create($request->validated());
        return redirect()
            ->route('pegawai.index')
            ->with('success', 'Data pegawai berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pegawai $pegawai)
    {
        $pegawai->load('golongan');
        return view('pegawai.show', compact('pegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $pegawai)
    {
        $golongan = Golongan::all();
        return view('pegawai.edit', compact('pegawai', 'golongan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PegawaiRequest $request, Pegawai $pegawai)
    {
        $pegawai->update($request->validated());
        return redirect()
            ->route('pegawai.index')
            ->with('success', 'Data pegawai berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $pegawai)
    {
        if ($pegawai->komponenGaji()->count() > 0) {
            return redirect()
                ->route('pegawai.index')
                ->with('error', 'Pegawai tidak dapat dihapus karena sudah memiliki riwayat gaji!');
        }
        $pegawai->delete();
        return redirect()
            ->route('pegawai.index')
            ->with('success', 'Data pegawai berhasil dihapus!');
    }
}
