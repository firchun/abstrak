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

    </div>
    <div class="widget-content widget-content-area br-6">
        <h3 class="">{{ $title ?? 'Title' }}</h3>
        <div class="table-responsive mb-4 mt-4">
            <table id="datatable-riwayat" class="table table-hover table-bordered display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Judul</th>
                        <th>File Abstrak</th>
                        <th>File Pembayaran</th>
                        <th>File Pengesahan</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Judul</th>
                        <th>File Abstrak</th>
                        <th>File Pembayaran</th>
                        <th>File Pengesahan</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(function() {
            $('#datatable-riwayat').DataTable({
                processing: true,
                serverSide: false,
                responsive: true,
                ajax: '{{ url('riwayat-datatable') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'judul',
                        name: 'judul'
                    },
                    {
                        data: 'file_abstrak',
                        name: 'file_abstrak'
                    },
                    {
                        data: 'file_pembayaran',
                        name: 'file_pembayaran'
                    },
                    {
                        data: 'file_pengesahan',
                        name: 'file_pengesahan'
                    },


                ]
            });
            $('.refresh').click(function() {
                $('#datatable-riwayat').DataTable().ajax.reload();
            });


        });
    </script>
@endpush
