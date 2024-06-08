@extends('layouts.backend.admin')

@section('content')
    @include('layouts.backend.alert')
    <div class=" btn-group mb-3" role="group">
        <button class="btn btn-secondary refresh " type="button">
            <span>
                <i class="bx bx-sync "> </i>
                <span class="d-none d-sm-inline-block">Refresh Data</span>
            </span>
        </button>
        <a href="{{ route('laporan.excel-pembayaran') }}" class="btn btn-success" type="button">
            <span>
                <i class="bx bxs-file-export"></i> Export Execl
            </span>
        </a>
        <a target="__blank" href="{{ route('laporan.pdf-pembayaran') }}" class="btn btn-danger " type="button">
            <span>
                <i class="bx bxs-file-export"></i> Export PDF
            </span>
        </a>

    </div>
    <div class="widget-content widget-content-area br-6">
        <h3 class="">{{ $title ?? 'Title' }}</h3>
        <div class="table-responsive mb-4 mt-4">
            <table id="datatable-pembayaran" class="table table-hover table-bordered display table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Mahasiswa</th>
                        <th>Judul</th>
                        <th>Jumlah</th>
                        <th>Lunas</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Mahasiswa</th>
                        <th>Judul</th>
                        <th>Jumlah</th>
                        <th>Lunas</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(function() {
            var table = $('#datatable-pembayaran').DataTable({
                processing: true,
                serverSide: false,
                responsive: true,
                ajax: '{{ url('pembayaran-datatable') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'mahasiswa',
                        name: 'mahasiswa'
                    },
                    {
                        data: 'abstrak.judul',
                        name: 'abstrak.judul'
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah'
                    },
                    {
                        data: 'diterima',
                        name: 'diterima',
                        render: function(data) {
                            return data == 1 ? 'lunas' : 'menunggu';
                        }
                    }
                ],
                // dom: '<"row"<"col-md-6"B><"col-md-6"f>><"col-md-12"rt><"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>>',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="bx bxs-file-export"></i> Excel',
                    className: 'btn btn-primary',
                    exportOptions: {
                        columns: ':visible'
                    }
                }],

            });

            $('.refresh').click(function() {
                table.ajax.reload();
            });
            $('.export-excel').click(function() {
                console.log('cetak excel');
            });
            $('.export-pdf').click(function() {
                console.log('cetak pdf');

            });
        });
    </script>

    <!-- JS DataTables Buttons -->
@endpush
