<?php

namespace App\Http\Controllers;

use App\Models\Abstrak;
use App\Models\FileAbstrak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class RiwayatController extends Controller
{
    public function index(){
        $data = [
            'title'=> 'Riwayat File Pengajuan',
        ];
        return view('admin.riwayat.index',$data);
    }
    public function getRiwayatDataTable()
    {
        $abstrak = Abstrak::where('id_mahasiswa',Auth::id())->first();
        $riwayat = FileAbstrak::where('id_abstrak',$abstrak->id)->orderByDesc('id');


        return DataTables::of($riwayat)
            ->addColumn('tanggal', function($riwayat){
                return $riwayat->created_at->format('d F Y');
            })
            ->addColumn('file', function ($riwayat) {
                return '<a target="__blank" href="'.Storage::url($riwayat->file).'" class="btn btn-success">Lihat File</a>';
            })
            ->addColumn('status', function ($riwayat) {
                if($riwayat->status == 0){
                    $text ='Menunggu Pemeriksaan';
                }elseif($riwayat->status == 1){
                    $text ='Abstrak diterima';
                    
                }else{
                    $text ='Revisi';

                }
                return $text;
            })

            ->rawColumns(['status','tanggal','file'])
            ->make(true);
    }
}
