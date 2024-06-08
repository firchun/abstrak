<?php

namespace App\Http\Controllers;

use App\Models\Abstrak;
use App\Models\Pembayaran;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

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
    public function exportPengajuan()
    {
        // Inisialisasi spreadsheet
        $spreadsheet = new Spreadsheet();

        // Ambil data Anda dari model atau sumber lain
        $data = Abstrak::with(['mahasiswa', 'fakultas'])->get();
        $collection = $data->map(function ($item) {
            return [
                'No ' => $item->id,
                'Tanggal' => $item->created_at->format('d F Y'),
                'Judul' => $item->judul,
                'Nama Mahasiswa' => $item->mahasiswa->name,
                'NPM Mahasiswa' => $item->mahasiswa->identity,
                'Fakultas' => $item->fakultas->fakultas,
            ];
        });
        $header = [
            'ID',
            'Tanggal',
            'Judul',
            'Nama Mahasiswa',
            'NPM Mahasiswa',
            'Fakultas',
        ];
        $spreadsheet->getActiveSheet()->getStyle('A1:F1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => 'ffffff'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0a6b41'],
            ],
        ]);

        $spreadsheet->getActiveSheet()->fromArray([$header]);
        $spreadsheet->getActiveSheet()->fromArray($collection->toArray(), null, 'A2');
        $writer = new Xlsx($spreadsheet);

        $response = response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment;filename=laporan_pengajuan_abstrak.xlsx',
            ]
        );

        return $response;
    }
    public function exportPembayaran()
    {

        $spreadsheet = new Spreadsheet();

        $data = Pembayaran::with(['abstrak'])->get();
        $collection = $data->map(function ($item) {
            return [
                'No ' => $item->id,
                'Tanggal' => $item->created_at->format('d F Y'),
                'Judul' => $item->abstrak->judul,
                'Nama Mahasiswa' => $item->abstrak->mahasiswa->name,
                'NPM Mahasiswa' => $item->abstrak->mahasiswa->identity,
                'Jumlah' => number_format($item->jumlah),
                'Lunas' => $item->diterima == 1 ? 'Lunas' : 'Belum',
            ];
        });
        $header = [
            'ID',
            'Tanggal',
            'Judul',
            'Nama Mahasiswa',
            'NPM Mahasiswa',
            'Jumlah',
            'Lunas',
        ];
        $spreadsheet->getActiveSheet()->getStyle('A1:G1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => 'ffffff'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0a6b41'],
            ],
        ]);

        $spreadsheet->getActiveSheet()->fromArray([$header]);
        $spreadsheet->getActiveSheet()->fromArray($collection->toArray(), null, 'A2');

        $writer = new Xlsx($spreadsheet);

        $response = response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment;filename=laporan_pembayaran_abstrak.xlsx',
            ]
        );

        return $response;
    }
    public function pdfPengajuan()
    {
        $data = Abstrak::with(['mahasiswa', 'fakultas'])->get();

        $pdf = \PDF::loadview('admin/laporan/pdf/pengajuan', [
            'data' => $data,
            'title' => 'Laporan Pengajuan Abstrak',
        ])
            ->setPaper('a4', 'potrait');
        return $pdf->stream('Laporan_pengajuan_abstrak_' . date('d F Y') . '.pdf');
    }
    public function pdfPembayaran()
    {
        $data = Pembayaran::with(['abstrak'])->get();

        $pdf = \PDF::loadview('admin/laporan/pdf/pembayaran', [
            'data' => $data,
            'title' => 'Laporan Pembayaran Abstrak',
        ])
            ->setPaper('a4', 'potrait');
        return $pdf->stream('Laporan_pengajuan_abstrak_' . date('d F Y') . '.pdf');
    }
}
