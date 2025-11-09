<?php

namespace App\Http\Controllers\Parkir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisKendaraan;
use App\Models\KendaraanMasuk;

class JenisKendaraanController extends Controller
{
    public function index()
    {
        $data = JenisKendaraan::all();
        return view('parkir/admin/JenisKendaraan', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_kendaraan' => 'required|string|max:100',
            'harga' => 'required|numeric',
            'kapasitas_slot' => 'required|integer',
        ]);

        JenisKendaraan::create($request->all());

        return back()->with('success', 'Jenis Kendaraan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_kendaraan' => 'required|string|max:100',
            'harga' => 'required|numeric',
            'kapasitas_slot' => 'required|integer',
        ]);

        $jenis = JenisKendaraan::findOrFail($id);
        $jenis->update($request->all());

        return back()->with('success', 'Jenis Kendaraan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jenis = JenisKendaraan::findOrFail($id);
        $jenis->delete();

        return back()->with('success', 'Jenis Kendaraan berhasil dihapus.');
    }

public function slot()
{
    // Mengambil semua jenis kendaraan
    $jenisKendaraans = JenisKendaraan::all();
    
    // Menghitung jumlah kendaraan yang terparkir untuk setiap jenis
    $terparkir = KendaraanMasuk::selectRaw('id_jeniskendaraan, count(*) as jumlah')
        ->groupBy('id_jeniskendaraan')
        ->pluck('jumlah', 'id_jeniskendaraan')
        ->toArray();

    return view('parkir.admin.SlotKendaraan', compact('jenisKendaraans', 'terparkir'));
}

    public function slotStore(Request $request)
    {
        $request->validate([
            'id_jeniskendaraan' => 'required|exists:jenis_kendaraan,id',
            'kapasitas_slot' => 'required|integer',
        ]);

        $jenis = JenisKendaraan::findOrFail($request->id_jeniskendaraan);
        $jenis->kapasitas_slot = $request->kapasitas_slot;
        $jenis->save();

        return back()->with('success', 'Kapasitas slot berhasil diperbarui.');
    }
}