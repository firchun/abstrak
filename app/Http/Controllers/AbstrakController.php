<?php

namespace App\Http\Controllers;

use App\Models\Abstrak;
use App\Models\FileAbstrak;
use App\Models\Pembayaran;
use App\Models\Pemeriksaan;
use App\Models\StatusAbstrak;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AbstrakController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Pengajuan Abstrak',
        ];
        return view('admin.abstrak.index', $data);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_mahasiswa' => 'required',
            'id_fakultas' => 'required',
            'judul' => 'required',
            'file' => 'required|file|mimes:pdf|max:2048',
            'file_lembar_pengesahan' => 'required|file|mimes:pdf|max:2048',
            'file_pembayaran' => 'required|file|mimes:pdf|max:2048',
        ]);
        // dd($request);

        if ($request->hasFile('file') && $request->hasFile('file_lembar_pengesahan')) {
            $file = $request->file('file');
            $file_lembar_pengesahan = $request->file('file_lembar_pengesahan');
            $file_pembayaran = $request->file('file_pembayaran');
            $filename = Str::random(32) . '.' . $file->getClientOriginalExtension();
            $filename2 = Str::random(32) . '.' . $file_lembar_pengesahan->getClientOriginalExtension();
            $filename3 = Str::random(32) . '.' . $file_pembayaran->getClientOriginalExtension();

            // Simpan file ke storage
            $path = $file->storeAs('public/file', $filename);
            $path2 = $file_lembar_pengesahan->storeAs('public/file', $filename2);
            $path3 = $file_pembayaran->storeAs('public/file', $filename3);

            // Simpan data ke database
            //abstrak
            $abstrak = new Abstrak();
            $abstrak->id_mahasiswa = $validatedData['id_mahasiswa'];
            $abstrak->id_fakultas = $validatedData['id_fakultas'];
            $abstrak->judul = $validatedData['judul'];
            $abstrak->file_lembar_pengesahan = $path2;
            $abstrak->save();

            $file = new FileAbstrak();
            $file->id_abstrak = $abstrak->id;
            $file->file = $path;
            $file->save();

            //pembayaran
            $pembayaran = new Pembayaran();
            $pembayaran->id_abstrak = $abstrak->id;
            $pembayaran->jumlah = 50000;
            $pembayaran->file = $path3;
            $pembayaran->save();

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
        $abstrak = Abstrak::with(['mahasiswa', 'fakultas', 'file', 'jurusan'])->orderByDesc('id');

        return DataTables::of($abstrak)
            ->addColumn('action', function ($abstrak) {
                return view('admin.abstrak.components.actions', compact('abstrak'));
            })

            ->addColumn('tanggal', function ($abstrak) {
                return $abstrak->created_at->format('d F Y');
            })
            ->addColumn('status', function ($abstrak) {
                $status = StatusAbstrak::where('id_abstrak', $abstrak->id)->latest()->first();
                return $status->status;
            })
            ->addColumn('mahasiswa', function ($abstrak) {
                return '<strong>' . $abstrak->mahasiswa->name . '</strong><br><small class="text-mutted">' . $abstrak->mahasiswa->identity . '</small>';
            })

            ->addColumn('file', function ($abstrak) {
                $latestFile = $abstrak->file()->latest()->first();
                return '<a target="__blank" href="' . Storage::url($latestFile) . '" class="btn btn-success">Lihat File</a>';
            })
            ->addColumn('whatsapp', function ($abstrak) {
                $status = StatusAbstrak::where('id_abstrak', $abstrak->id)->latest()->first()->status;
                $pemeriksaan = Pemeriksaan::where('id_abstrak', $abstrak->id)->latest()->count();
                $no_hp = User::find($abstrak->id_mahasiswa)->no_hp;
                $pembayaran = Pembayaran::where('id_abstrak', $abstrak->id)->latest()->count();
                //api wa
                $text_pembayaran = $pembayaran == 0 ? "Tagihan : Rp 50.000 (jika belum membayar)\n" : '';

                $pesan = "Judul : " . $abstrak->judul . "\n" .
                    "Tanggal Pengajuan : " . $abstrak->created_at->format('d F Y') . "\n" .
                    "Status Pengajuan : " . $status . "\n" .
                    $text_pembayaran;

                $pesan_encoded = urlencode($pesan);
                $url = 'https://api.whatsapp.com/send?phone=' . $no_hp . '&text=' . $pesan_encoded;
                //end
                $text_tagihan = $url;
                $text_kosong = 'https://api.whatsapp.com/send?phone=' . $no_hp;
                $link = $pemeriksaan == 0 ? $text_kosong : $text_tagihan;
                $tombol = '<a href="' . $link . '" class="btn btn-success"><i class="bx bxl-whatsapp"></i></a>';
                return $tombol;
            })

            ->rawColumns(['action', 'file', 'tanggal', 'mahasiswa', 'status', 'whatsapp'])
            ->make(true);
    }
    public function periksa($id)
    {
        $cek_status = StatusAbstrak::where('id_abstrak', $id)->where('status', 'Pemeriksaan oleh staff : ' . Auth::user()->name)->count();
        if ($cek_status == 0) {

            $status = new StatusAbstrak();
            $status->id_abstrak = $id;
            $status->id_staff = Auth::id();
            $status->status = 'Pemeriksaan oleh staff : ' . Auth::user()->name;
            $status->save();
        }
        $pemeriksaan = Pemeriksaan::where('id_abstrak', $id)->where('hasil', 'Selesai')->latest()->first();
        $abstrak = Abstrak::find($id);
        $latestFile = $abstrak->file()->latest()->first();
        $abstrak['status_file'] = $latestFile && $latestFile->status ? $latestFile->status : '';
        $abstrak['id_file'] = $latestFile && $latestFile->status ? $latestFile->id : '';
        $abstrak['file_url'] = $latestFile && $latestFile->status ?  Storage::url($latestFile->file) : '';
        $abstrak['file_url_staff'] = $pemeriksaan && $pemeriksaan->file ? Storage::url($pemeriksaan->file) : '';
        return response()->json($abstrak);
    }
    public function hasilPeriksa(Request $request)
    {
        $hasilValue = $request->input('hasil');
        $catatan = $request->input('catatan');
        $id_file = $request->input('id_file');
        //file
        $file = $request->file('file');
        $filename = Str::random(32) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('public/file', $filename);

        $file_abstrak = FileAbstrak::find($id_file);
        $file_abstrak->status = ($hasilValue == 'Selesai') ? 1 : 2;


        $fileAbstrakSaved = $file_abstrak->save();


        $pemeriksaan = new Pemeriksaan();
        $pemeriksaan->hasil = $hasilValue;
        $pemeriksaan->catatan = $catatan;
        $pemeriksaan->file = $path;
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
    public function uploadRevisi(Request $request)
    {
        $validatedData = $request->validate([
            'id_abstrak' => 'required',
            'file' => 'required|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = Str::random(32) . '.' . $file->getClientOriginalExtension();

            // Simpan file ke storage
            $path = $file->storeAs('public/file', $filename);

            $file = new FileAbstrak();
            $file->id_abstrak = $validatedData['id_abstrak'];
            $file->file = $path;
            $file->save();

            $status = new StatusAbstrak();
            $status->id_abstrak = $validatedData['id_abstrak'];
            $status->id_staff = Auth::id();
            $status->status = 'Pengajuan ulang file';
            $status->save();

            session()->flash('success', 'Berhasil mengajukan abstrak');
            return back();
        }

        session()->flash('error', 'Gagal menyimpan abstrak');
        return back()->withInput();
    }
}
