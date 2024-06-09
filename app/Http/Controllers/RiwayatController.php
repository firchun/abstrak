<?php

namespace App\Http\Controllers;

use App\Models\Abstrak;
use App\Models\FileAbstrak;
use App\Models\Pembayaran;
use App\Models\Pemeriksaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class RiwayatController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Riwayat File Pengajuan',
        ];
        return view('admin.riwayat.index', $data);
    }
    public function getRiwayatDataTable()
    {
        $riwayat = Abstrak::where('id_mahasiswa', Auth::id());
        // $riwayat = FileAbstrak::with(['abstrak'])->whereHas('abstrak', function ($query) {
        //     $query->where('id_mahasiswa', Auth::id());
        // })->orderByDesc('id');


        return DataTables::of($riwayat)
            ->addColumn('tanggal', function ($riwayat) {
                return $riwayat->created_at->format('d F Y');
            })
            ->addColumn('file_abstrak', function ($riwayat) {
                $file = FileAbstrak::where('id_abstrak', $riwayat->id)->latest()->first();
                $file_hasil = Pemeriksaan::where('id_abstrak', $riwayat->id)->where('hasil', 'Selesai')->latest()->first();
                $btn_file_pengajuan = '<a target="__blank" href="' . Storage::url($file->file) . '" class="btn btn-sm btn-success m-1">File diajukan</a>';
                $btn_file_hasil = '<a target="__blank" href="' . Storage::url($file_hasil->file) . '" class="btn btn-sm btn-primary m-1">File Hasil</a>';
                return $btn_file_pengajuan . ($file_hasil ? $btn_file_hasil : '');
            })
            ->addColumn('file_pembayaran', function ($riwayat) {
                $pembayaran = Pembayaran::where('id_abstrak', $riwayat->id)->latest()->first();
                return '<a target="__blank" href="' . Storage::url($pembayaran->file) . '" class="btn btn-sm btn-success">Lihat File</a>';
            })
            ->addColumn('file_pengesahan', function ($riwayat) {
                return '<a target="__blank" href="' . Storage::url($riwayat->file_lembar_pengesahan) . '" class="btn btn-sm btn-success">Lihat File</a>';
            })


            ->rawColumns(['status', 'tanggal', 'file_abstrak', 'file_pengesahan', 'file_pembayaran'])
            ->make(true);
    }
}
