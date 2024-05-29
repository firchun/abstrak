<?php

namespace App\Http\Controllers;

use App\Models\Abstrak;
use App\Models\Customer;
use App\Models\Fakultas;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'admin' => User::where('role', 'Admin')->count(),
            'mahasiswa' => User::where('role', 'Mahasiswa')->count(),
            'upt' => User::where('role', 'UPT')->count(),
        ];
        return view('admin.dashboard', $data);
    }
    public function grafik()
    {
        // Mengambil data pengajuan dari model Abstrak
        $pengajuan = Abstrak::all();
        
        // Menginisialisasi array untuk menyimpan total pengajuan per bulan
        $total_pengajuan = [];
        
        // Mengumpulkan total pengajuan per bulan
        foreach ($pengajuan as $abstrak) {
            $bulan = $abstrak->created_at->format('F Y'); 
            if (!isset($total_pengajuan[$bulan])) {
                $total_pengajuan[$bulan] = 0; 
            }
            $total_pengajuan[$bulan]++; 
        }
        
        // Mengambil daftar fakultas dari model Fakultas
        $fakultas_list = Fakultas::all();
    
        // Inisialisasi array untuk menyimpan data fakultas
        $fakultas = [];
        
        // Iterasi setiap fakultas
        foreach ($fakultas_list as $fakultas_item) {
            // Mengambil data pengajuan untuk fakultas saat ini
            $abstrak = Abstrak::where('id_fakultas', $fakultas_item->id)->get();
            
            // Inisialisasi array untuk menyimpan data pengajuan abstrak per bulan untuk fakultas saat ini
            $data_fakultas = [];
            
            // Mengumpulkan data pengajuan abstrak per bulan untuk fakultas saat ini
            foreach ($total_pengajuan as $bulan => $jumlah_pengajuan) {
                $data_fakultas[$bulan] = 0; // Inisialisasi nilai 0 untuk bulan saat ini
                
                // Jika ada data pengajuan untuk fakultas saat ini pada bulan tertentu, update nilainya
                foreach ($abstrak as $abstrak_item) {
                    if ($abstrak_item->created_at->format('F Y') === $bulan) {
                        $data_fakultas[$bulan]++;
                    }
                }
            }
            
            // Menambahkan data fakultas ke dalam array fakultas
            $fakultas[] = [
                "name" => $fakultas_item->fakultas,
                "data" => array_values($data_fakultas)
            ];
        }
    
        // Mengambil label bulan dari data total pengajuan
        $labels = array_keys($total_pengajuan);
    
        // Data yang akan dikembalikan sebagai respons JSON
        $data = [
            "total_pengajuan" => array_values($total_pengajuan),
            "fakultas" => $fakultas,
            "labels" => $labels
        ];
    
        return response()->json($data);
    }
    

}
