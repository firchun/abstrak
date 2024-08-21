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
        <a href="#" id="export-excel" class="btn btn-success" type="button">
            <span>
                <i class="bx bxs-file-export"></i> Export Execl
            </span>
        </a>
        <a href="#" id="export-pdf" class="btn btn-danger " type="button">
            <span>
                <i class="bx bxs-file-export"></i> Export PDF
            </span>
        </a>
    </div>
    <div class="widget-content widget-content-area br-6">
        <h3 class="">{{ $title ?? 'Title' }}</h3>
        <hr>
        <div class="my-2">
            <label>Filter :</label>
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <select class="form-control form-control-sm" name="status" id="selectStatus">
                        <option value="">Pilih Status</option>
                        <option value="menunggu">Menunggu Konfirmasi</option>
                        <option value="diterima">Diterima</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-primary" id="filter"><i class="bx bx-filter"></i>
                        Filter</button>
                </div>

            </div>
        </div>
        <hr>
        <div class="table-responsive mb-4 mt-4">
            <table id="datatable-pembayaran" class="table table-hover table-bordered display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Judul</th>
                        <th>Jumlah</th>
                        <th>File</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Judul</th>
                        <th>Jumlah</th>
                        <th>File</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(function() {
            table = $('#datatable-pembayaran').DataTable({
                processing: true,
                serverSide: false,
                responsive: true,
                ajax: {
                    url: '{{ url('pembayaran-datatable') }}',
                    data: function(d) {
                        d.selectStatus = $('#selectStatus').val();
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
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
                        data: 'file',
                        name: 'file'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },

                ]
            });
            $('.refresh').click(function() {
                table.ajax.reload();
            });
            $('#filter').click(function() {
                table.ajax.url('{{ url('pembayaran-datatable') }}?' + $.param({
                    status: $('#selectStatus').val(),
                })).load();
            });
            $('#export-pdf').click(function() {
                var queryParams = $.param({
                    status: $('#selectStatus').val(),
                });
                var exportUrl = '{{ route('laporan.pdf-pembayaran') }}?' + queryParams;
                window.open(exportUrl, '_blank');
            });
            $('#export-excel').click(function() {
                var queryParams = $.param({
                    status: $('#selectStatus').val(),
                });
                var exportUrl = '{{ route('laporan.excel-pembayaran') }}?' + queryParams;
                window.open(exportUrl, '_blank');
            });


        });
    </script>
@endpush
