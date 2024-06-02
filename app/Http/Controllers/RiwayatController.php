<?php

namespace App\Http\Controllers;

use App\Models\Abstrak;
use App\Models\FileAbstrak;
use App\Models\Pembayaran;
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
                return '<a target="__blank" href="' . Storage::url($file->file) . '" class="btn btn-sm btn-success">Lihat File</a>';
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
