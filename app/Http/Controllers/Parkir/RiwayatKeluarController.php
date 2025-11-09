<?php

namespace App\Http\Controllers\Parkir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiwayatKeluar;
use App\Models\KendaraanMasuk;
use App\Models\JenisKendaraan;
use Carbon\Carbon;

class RiwayatKeluarController extends Controller
{
    public function index()
    {
        $riwayatKeluar = RiwayatKeluar::with(['jenisKendaraan', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        $kendaraanMasuk = KendaraanMasuk::with(['jenisKendaraan'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('parkir.admin.KendaraanKeluar', compact('riwayatKeluar', 'kendaraanMasuk'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'kode_unik' => 'required|string'
            ]);

            $kendaraanMasuk = KendaraanMasuk::where('kode_unik', $request->kode_unik)->first();

            if (!$kendaraanMasuk) {
                return back()->with('error', 'Kode kendaraan tidak ditemukan!');
            }

            $waktuMasuk = Carbon::parse($kendaraanMasuk->waktu_masuk);
            $waktuKeluar = Carbon::now();
            $durasiMenit = $waktuMasuk->diffInMinutes($waktuKeluar);
            $durasiHari = $waktuMasuk->diffInDays($waktuKeluar);

            $jenisKendaraan = $kendaraanMasuk->jenisKendaraan;
            
            // Kalau durasi >= 1 hari, harga x 10
            if ($durasiHari >= 1) {
                $biaya = $jenisKendaraan->harga * 10;
            } else {
                // Kalau kurang dari 1 hari, pakai harga normal
                $biaya = $jenisKendaraan->harga;
            }

            RiwayatKeluar::create([
                'id_user' => $kendaraanMasuk->id_user,
                'id_jenisKendaraan' => $kendaraanMasuk->id_jeniskendaraan,
                'kode_unik' => $kendaraanMasuk->kode_unik,
                'nama_kendaraan' => $kendaraanMasuk->nama_kendaraan,
                'waktu_masuk' => $kendaraanMasuk->waktu_masuk,
                'waktu_keluar' => $waktuKeluar,
                'durasi_hari' => $durasiHari,
                'biaya' => $biaya,
            ]);

            $kendaraanMasuk->delete();

            return back()->with('success', 'Kendaraan berhasil checkout! Biaya: Rp ' . number_format($biaya, 0, ',', '.'));

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}