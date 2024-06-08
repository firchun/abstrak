<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <meta http-equiv="Content-Type" content="charset=utf-8" />
    <link rel="stylesheet" href="{{ public_path('css') }}/pdf/bootstrap.min.css" media="all" />
    <style>
        body {
            font-family: 'times new roman';
            font-size: 16px;
        }

        .page_break {
            page-break-before: always;
        }

        table.table_custom th,
        table.table_custom td {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid;
            padding: 5px;
        }
    </style>
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css"> --}}
</head>

<body>
    <main class="mt-0">
        <table class="" style="font-size: 18px; padding:5px; width:100%; border:0px;">
            <tr>
                <td style="width: 20%">
                    <img style="width: 100px;" src="{{ public_path('img') }}/musamus.png">
                </td>
                <td class="text-center" style="width: 80%">
                    <span style="font-size: 14px;">KEMENTRIAN RISET, TEKNOLOGI DAN PENDIDIKAN</span><br>
                    <span style="font-size: 14px;">UNIVERSITAS MUSAMUS (UNMUS)</span><br>
                    <b style="font-size: 14px;">UNIT PELAKSANA TEKNIS (UPT_ BAHASA)</b><br>
                    <b style="font-size: 12px;">Jln. Kamizaun Mupah Lama Merauke 99611</b><br>
                    <b style="font-size: 12px;">Telp (0971)325923 Fax (0971)</b><br>
                    <b style="font-size: 12px;">Fax (0971) E-mail: info@unmus.ac.id</b><br>
                </td>
                <td style="width: 20%"></td>
            </tr>
        </table>
        <hr style="border: 1px solid black;">
        <table class="table-borderless mb-3">
            <tr>
                <td>Laporan</td>
                <td style="width: 15px" class="text-center">:</td>
                <td><b>Pembayaran Abstrak</b></td>
            </tr>
            <tr>
                <td>Tanggal Cetak</td>
                <td style="width: 15px" class="text-center">:</td>
                <td>{{ date('d F Y') }}</td>
            </tr>

        </table>
        <div class="table-responsive">
            <table class="table_custom" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 15px;">ID</th>
                        <th>Tanggal</th>
                        <th>Mahasiswa</th>
                        <th>Judul</th>
                        <th>Jumlah</th>
                        <th>Lunas</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->created_at->format('d F Y') }}</td>
                            <td>{{ $item->abstrak->mahasiswa->name }}<br>
                                <small>{{ $item->abstrak->mahasiswa->identity }}</small>
                            </td>
                            <td>{{ $item->abstrak->judul }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ $item->diterima == 1 ? 'Lunas' : 'Belum' }}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>

    </main>

</body>

</html>
