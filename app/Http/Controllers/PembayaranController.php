<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PembayaranController extends Controller
{
    public function index(){
        $data = [
            'title'=> 'Data Pembayaran Abstrak',
        ];
        return view('admin.pembayaran.index',$data);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_abstrak' => 'required',
            'jumlah' => 'required',
            'file' => 'required|file|mimes:pdf',
        ]);
    
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = Str::random(32) . '.' . $file->getClientOriginalExtension();
            
            // Simpan file ke storage
            $path = $file->storeAs('public/file', $filename);
    
            // Simpan data ke database
            $pembayaran = new Pembayaran();
            $pembayaran->id_abstrak = $validatedData['id_abstrak'];
            $pembayaran->jumlah = $validatedData['jumlah'];
            $pembayaran->file = $path;
            $pembayaran->save();

            session()->flash('success', 'Berhasil mengirim bukti pembayaran');
            return back();
        }
    
        session()->flash('error', 'Gagal mengirim bukti pembayaran');
        return back()->withInput();
    }
    public function getPembayaranDataTable()
    {
        $pembayaran = Pembayaran::with(['abstrak'])->orderByDesc('id');

        return DataTables::of($pembayaran)
            ->addColumn('action', function ($pembayaran) {
                $terima = '<a href="'.url('pembayaran/terima',$pembayaran->id).'" class="btn btn-success mx-1">terima</a>';
                $tolak = '<a href="'.url('pembayaran/tolak',$pembayaran->id).'" class="btn btn-danger mx-1">tolak</a>';
                $status =  $pembayaran->diterima == 1 ? 'Telah diterima' : 'Ditolak';
                return $pembayaran->diterima == 0 ? $terima.$tolak : $status;
            })
            
            ->addColumn('tanggal', function ($pembayaran) {
                return $pembayaran->created_at->format('d F Y');
            })
            ->addColumn('file', function ($pembayaran) {
                return '<a target="__blank" href="'.Storage::url($pembayaran->file).'" class="btn btn-success">Lihat File</a>';
            })
            
            ->rawColumns(['action', 'file','tanggal'])
            ->make(true);
    }
    public function terima($id){
        $pembayaran = Pembayaran::find($id);
        $pembayaran->diterima = 1;
        $pembayaran->save();
        session()->flash('success', 'Pembayaran diterima');
        return back();
    }
    public function tolak($id){
        $pembayaran = Pembayaran::find($id);
        $pembayaran->diterima = 2;
        $pembayaran->save();
        session()->flash('success', 'Pembayaran ditolak');
        return back();
    }
}
