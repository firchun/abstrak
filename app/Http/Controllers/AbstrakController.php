<?php

namespace App\Http\Controllers;

use App\Models\Abstrak;
use App\Models\FileAbstrak;
use App\Models\Pemeriksaan;
use App\Models\StatusAbstrak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AbstrakController extends Controller
{
    public function index(){
        $data = [
            'title'=> 'Pengajuan Abstrak',
        ];
        return view('admin.abstrak.index',$data);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_mahasiswa' => 'required',
            'id_fakultas' => 'required',
            'judul' => 'required',
            'file' => 'required|file|mimes:pdf',
        ]);
    
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = Str::random(32) . '.' . $file->getClientOriginalExtension();
            
            // Simpan file ke storage
            $path = $file->storeAs('public/file', $filename);
    
            // Simpan data ke database
            $abstrak = new Abstrak();
            $abstrak->id_mahasiswa = $validatedData['id_mahasiswa'];
            $abstrak->id_fakultas = $validatedData['id_fakultas'];
            $abstrak->judul = $validatedData['judul'];
            // $abstrak->file = $path;
            $abstrak->save();

            $file = new FileAbstrak();
            $file->id_abstrak = $abstrak->id;
            $file->file = $path;
            $file->save();

            $status = new StatusAbstrak();
            $status->id_abstrak = $abstrak->id;
            $status->id_staff = Auth::id();
            $status->status = 'Pengajuan';
            $status->save();
    
            session()->flash('success', 'Berhasil mengajukan abstrak');
            return back();
        }
    
        session()->flash('error', 'Gagal menyimpan abstrak');
        return back()->withInput();
    }
    public function getAbstrakDataTable()
    {
        $abstrak = Abstrak::with(['mahasiswa','fakultas','file'])->orderByDesc('id');

        return DataTables::of($abstrak)
            ->addColumn('action', function ($abstrak) {
                return view('admin.abstrak.components.actions', compact('abstrak'));
            })
            
            ->addColumn('tanggal', function ($abstrak) {
                return $abstrak->created_at->format('d F Y');
            })
            ->addColumn('status', function ($abstrak) {
                $status = StatusAbstrak::where('id_abstrak',$abstrak->id)->latest()->first();
                return $status->status;
            })
            ->addColumn('mahasiswa', function ($abstrak) {
                return '<strong>'.$abstrak->mahasiswa->name.'</strong><br><small class="text-mutted">'.$abstrak->mahasiswa->identity.'</small>';
            })
            
            ->addColumn('file', function ($abstrak) {
                $latestFile = $abstrak->file()->latest()->first();
                return '<a target="__blank" href="'.Storage::url($latestFile).'" class="btn btn-success">Lihat File</a>';
            })
            
            ->rawColumns(['action', 'file','tanggal','mahasiswa','status'])
            ->make(true);
    }
    public function periksa($id){
        $cek_status = StatusAbstrak::where('id_abstrak',$id)->where('status','Pemeriksaan oleh staff : '.Auth::user()->name)->count();
        if($cek_status==0){

            $status = new StatusAbstrak();
            $status->id_abstrak = $id;
            $status->id_staff = Auth::id();
            $status->status = 'Pemeriksaan oleh staff : '.Auth::user()->name;
            $status->save();
        }

        $abstrak = Abstrak::find($id);
        $latestFile = $abstrak->file()->latest()->first();
        $abstrak['status_file'] = $latestFile->status;
        $abstrak['id_file'] = $latestFile->id;
        $abstrak['file_url'] = Storage::url($latestFile->file);
        return response()->json($abstrak);
    }
    public function hasilPeriksa(Request $request)
    {
        $hasilValue = $request->input('hasil');
        $catatan = $request->input('catatan');
        $id_file = $request->input('id_file');
    
        $file_abstrak = FileAbstrak::find($id_file);
        $file_abstrak->status = ($hasilValue == 'Selesai') ? 1 : 2;
    
        
        $fileAbstrakSaved = $file_abstrak->save();
    
       
        $pemeriksaan = new Pemeriksaan();
        $pemeriksaan->hasil = $hasilValue;
        $pemeriksaan->catatan = $catatan;
        $pemeriksaan->id_staff = Auth::user()->id;
        $pemeriksaan->id_abstrak = $file_abstrak->id_abstrak;
        $pemeriksaanSaved = $pemeriksaan->save();
    
        $status = new StatusAbstrak();
         $status->id_abstrak = $file_abstrak->id_abstrak;
       $status->id_staff = Auth::id();
       $status->status = 'Hasil pemeriksaan: ' . $hasilValue . ($hasilValue == 'Revisi' ? ', Silahkan Upload Ulang abstrak' : ', Selamat...');
        $status->save();

        if ($fileAbstrakSaved && $pemeriksaanSaved) {
            return response()->json(['message' => 'Sukses mengirim hasil']);
        } else {
            return response()->json(['message' => 'Gagal mengirim hasil']);
        }
    }
    
}
