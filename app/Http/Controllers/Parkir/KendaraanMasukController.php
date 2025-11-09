<?php

namespace App\Http\Controllers\Parkir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KendaraanMasuk;
use App\Models\JenisKendaraan;
use App\Models\RiwayatKeluar;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class KendaraanMasukController extends Controller
{
    public function index()
    {
        $jenisKendaraans = JenisKendaraan::all();

        foreach ($jenisKendaraans as $jenis) {
            $totalMasuk = KendaraanMasuk::where('id_jeniskendaraan', $jenis->id)->count();
            
            $jenis->terparkir = $totalMasuk;
            $jenis->sisa_slot = $jenis->kapasitas_slot - $totalMasuk;
        }

        $riwayatMasuk = KendaraanMasuk::with('jenisKendaraan')->orderBy('waktu_masuk', 'desc')->take(5)->get();

        return view('parkir.admin.KendaraanMasuk', compact('jenisKendaraans', 'riwayatMasuk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kendaraan' => 'required|string|max:100',
            'id_jeniskendaraan' => 'required|exists:jenis_kendaraan,id',
        ]);

        $jenis = JenisKendaraan::findOrFail($request->id_jeniskendaraan);
        $totalMasuk = KendaraanMasuk::where('id_jeniskendaraan', $jenis->id)->count();

        if ($totalMasuk >= $jenis->kapasitas_slot) {
            return back()->with('error', 'Maaf, slot parkir untuk ' . $jenis->jenis_kendaraan . ' sudah penuh.');
        }

        $kode_unik = strtoupper(Str::random(8));

        KendaraanMasuk::create([
            'id_user'           => Auth::id(),
            'id_jeniskendaraan' => $request->id_jeniskendaraan,
            'kode_unik'         => $kode_unik,
            'nama_kendaraan'    => $request->nama_kendaraan,
            'waktu_masuk'       => now(),
        ]);

        $writer = new PngWriter();
        
        $qrCode = new QrCode($kode_unik);
        
        $qrCodeDataUri = $writer->write(
            $qrCode,
            null, // Logo
            null, // Label
            ['size' => 250, 'margin' => 10] // Opsi seperti ukuran dan margin
        )->getDataUri();

        return back()
            ->with('success', 'Kendaraan berhasil ditambahkan! QR Code telah dibuat.')
            ->with('qrCode', $qrCodeDataUri)
            ->with('kodeUnik', $kode_unik);
    }
}