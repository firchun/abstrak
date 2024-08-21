<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PembayaranController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Pembayaran Abstrak',
        ];
        return view('admin.pembayaran.index', $data);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_abstrak' => 'required',
            'jumlah' => 'required',
            'file' => 'required|file|mimes:pdf|max:2048',
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
    public function getPembayaranDataTable(Request $request)
    {
        $pembayaran = Pembayaran::with(['abstrak'])->orderByDesc('id');
        if ($request->has('status') && $request->input('status') != '') {
            $status = $request->input('status');
            if ($status == 'menunggu') {
                $pembayaran->where('diterima', 0);
            } elseif ($status == 'diterima') {
                $pembayaran->where('diterima', 1);
            } else {
                $pembayaran->where('diterima', '>=', 2);
            }
        }
        return DataTables::of($pembayaran)
            ->addColumn('action', function ($pembayaran) {
                $terima = '<a href="' . url('pembayaran/terima', $pembayaran->id) . '" class="btn btn-sm btn-success m-1">terima</a>';
                $tolak = '<a href="' . url('pembayaran/tolak', $pembayaran->id) . '" class="btn btn-sm btn-danger m-1">tolak</a>';
                $status =  $pembayaran->diterima == 1 ? 'Telah diterima' : 'Ditolak';
                return $pembayaran->diterima == 0 ? $terima . $tolak : $status;
            })

            ->addColumn('jumlah', function ($pembayaran) {
                return 'Rp ' . number_format($pembayaran->jumlah);
            })
            ->addColumn('tanggal', function ($pembayaran) {
                return $pembayaran->created_at->format('d F Y');
            })
            ->addColumn('file', function ($pembayaran) {
                return '<a target="__blank" href="' . Storage::url($pembayaran->file) . '" class="btn btn-success">Lihat File</a>';
            })
            ->addColumn('mahasiswa', function ($pembayaran) {
                return '<strong>' . $pembayaran->abstrak->mahasiswa->name . '</strong><br><span class="text-primary">' . $pembayaran->abstrak->mahasiswa->identity . '</span>';
            })

            ->rawColumns(['action', 'file', 'tanggal', 'mahasiswa', 'jumlah'])
            ->make(true);
    }
    public function terima($id)
    {
        $pembayaran = Pembayaran::find($id);
        $pembayaran->diterima = 1;
        $pembayaran->save();
        session()->flash('success', 'Pembayaran diterima');
        return back();
    }
    public function tolak($id)
    {
        $pembayaran = Pembayaran::find($id);
        $pembayaran->diterima = 2;
        $pembayaran->save();
        session()->flash('success', 'Pembayaran ditolak');
        return back();
    }
}
