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
        <a href="{{ route('laporan.excel-pengajuan') }}" class="btn btn-success" type="button">
            <span>
                <i class="bx bxs-file-export"></i> Export Execl
            </span>
        </a>
        <a target="__blank" href="{{ route('laporan.pdf-pengajuan') }}" class="btn btn-danger " type="button">
            <span>
                <i class="bx bxs-file-export"></i> Export PDF
            </span>
        </a>

    </div>
    <div class="widget-content widget-content-area br-6">
        <h3 class="">{{ $title ?? 'Title' }}</h3>
        <hr>
        <div class="my-2">
            <label>Filter Laporan :</label>
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <select class="form-control form-control-sm" name="id_fakultas" id="selectFakultas">
                        <option>Pilih Fakultas</option>
                        @foreach (App\Models\Fakultas::all() as $item)
                            <option value="{{ $item->id }}">{{ $item->fakultas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-control form-control-sm" name="id_jurusan" id="selectJurusan">
                        <option>Pilih Jurusan</option>
                        @foreach (App\Models\Jurusan::all() as $item)
                            <option value="{{ $item->id }}">{{ $item->jurusan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-control form-control-sm" name="status" id="selectStatus">
                        <option>Pilih Status</option>
                        <option value="diterima">Diterima</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-primary"><i class="bx bx-filter"></i> Filter</button>
                </div>

            </div>
        </div>
        <hr>
        <div class="table-responsive mb-4 mt-4">
            <table id="datatable-abstrak" class="table table-hover table-bordered display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Fakultas</th>
                        <th>Jurusan</th>
                        <th>Mahasiswa</th>
                        <th>Judul</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Fakultas</th>
                        <th>Jurusan</th>
                        <th>Mahasiswa</th>
                        <th>Judul</th>
                        <th>Status</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(function() {
            $('#datatable-abstrak').DataTable({
                processing: true,
                serverSide: false,
                responsive: true,
                ajax: '{{ url('abstrak-datatable') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'fakultas.fakultas',
                        name: 'fakultas.fakultas'
                    },
                    {
                        data: 'jurusan.jurusan',
                        name: 'jurusan.jurusan'
                    },
                    {
                        data: 'mahasiswa',
                        name: 'mahasiswa'
                    },
                    {
                        data: 'judul',
                        name: 'judul'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },

                ]
            });
            $('.refresh').click(function() {
                $('#datatable-abstrak').DataTable().ajax.reload();
            });
        });
    </script>
@endpush
