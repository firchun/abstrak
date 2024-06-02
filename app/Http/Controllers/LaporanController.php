<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function pengajuan()
    {
        $data = [
            'title' => 'Laporan Pengajuan Abstrak',
        ];
        return view('admin.laporan.pengajuan', $data);
    }
    public function pembayaran()
    {
        $data = [
            'title' => 'Laporan Pembayaran Abstrak',
        ];
        return view('admin.laporan.pembayaran', $data);
    }
}
