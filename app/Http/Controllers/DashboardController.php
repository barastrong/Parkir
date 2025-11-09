<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\KendaraanMasuk;
use App\Models\JenisKendaraan;
use App\Models\RiwayatKeluar;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    function index()
    {
        $jenisKendaraanData = JenisKendaraan::query()
            ->select(
                'jenis_kendaraan.*',
                DB::raw('COUNT(kendaraan_masuk.id) as kendaraan_masuk_count')
            )
            ->leftJoin('kendaraan_masuk', 'jenis_kendaraan.id', '=', 'kendaraan_masuk.id_jeniskendaraan')
            ->groupBy('jenis_kendaraan.id')
            ->get();

        $kendaraanParkir = KendaraanMasuk::query()
            ->join('jenis_kendaraan', 'kendaraan_masuk.id_jeniskendaraan', '=', 'jenis_kendaraan.id')
            ->select('kendaraan_masuk.*','jenis_kendaraan.jenis_kendaraan as nama_jenis_kendaraan')
            ->latest('kendaraan_masuk.waktu_masuk')
            ->paginate(6);

        foreach ($kendaraanParkir as $kendaraan) {
            $waktuMasuk = Carbon::parse($kendaraan->waktu_masuk);
            $sekarang = Carbon::now();
            $durasi = $sekarang->diff($waktuMasuk);

            $durasiString = [];
            if ($durasi->d > 0) $durasiString[] = $durasi->d . ' hari';
            if ($durasi->h > 0) $durasiString[] = $durasi->h . ' jam';
            if ($durasi->i > 0) $durasiString[] = $durasi->i . ' menit';

            $kendaraan->durasi_parkir = implode(' ', $durasiString) ?: 'Baru saja';
        }

        $totalKendaraan = KendaraanMasuk::count();

        return view('dashboard', [
            'jenisKendaraanData' => $jenisKendaraanData,
            'kendaraanParkir' => $kendaraanParkir,
            'totalKendaraan' => $totalKendaraan,
        ]);
    }

    public function dashboardParkir()
    {
        $user = Auth::user();

        $jenisKendaraanData = JenisKendaraan::query()
            ->select('jenis_kendaraan.*',DB::raw('COUNT(kendaraan_masuk.id) as kendaraan_masuk_count')
            )
            ->leftJoin('kendaraan_masuk', 'jenis_kendaraan.id', '=', 'kendaraan_masuk.id_jeniskendaraan')
            ->groupBy('jenis_kendaraan.id')
            ->get();

        return view('parkir.dashboard', [
            'user' => $user,
            'jenisKendaraanData' => $jenisKendaraanData,
        ]);
    }
}
