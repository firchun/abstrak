@push('js')
    <script>
        $(function() {
            table = $('#datatable-abstrak').DataTable({
                processing: true,
                serverSide: false,
                responsive: true,
                ajax: {
                    url: '{{ url('abstrak-datatable') }}',
                    data: function(d) {
                        d.selectJurusan = $('#selectJurusan').val();
                        d.selectFakultas = $('#selectFakultas').val();
                        d.selectStatus = $('#selectStatus').val();
                    }
                },
                order: [
                    [0, 'desc']
                ],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'whatsapp',
                        name: 'whatsapp'
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

                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });

            $('.refresh').click(function() {
                table.ajax.reload();
            });

            $('#filter').click(function() {
                table.ajax.url('{{ url('abstrak-datatable') }}?' + $.param({
                    id_jurusan: $('#selectJurusan').val(),
                    id_fakultas: $('#selectFakultas').val(),
                    status: $('#selectStatus').val(),
                })).load();
            });
            window.pembayaran = function(id) {
                $('#pembayaran').modal('show');

                if ($.fn.DataTable.isDataTable('#datatable-pembayaran')) {
                    $('#datatable-pembayaran').DataTable().clear().destroy();
                }

                $('#datatable-pembayaran').DataTable({
                    processing: true,
                    serverSide: false,
                    responsive: true,
                    ajax: {
                        url: '{{ url('pembayaran-datatable') }}' + '/' + id,
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
                            data: 'file',
                            name: 'file'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        }
                    ]
                });
            };
            window.pemeriksaanAbstrak = function(id) {
                $.ajax({
                    type: 'GET',
                    url: '/abstrak/periksa/' + id,
                    success: function(response) {
                        // console.log(response);

                        if (response.status_file == 2) {
                            $('#bukaFileAbstrak').show();
                            $('#textStatus').show();
                            $('#formulir').hide();
                        } else if (response.status_file == 1) {
                            $('#bukaFileAbstrak').attr('href', response.file_url);
                            $('#bukaFileAbstrakStaff').attr('href', response.file_url_staff);
                            $('#textStatus').hide();
                            $('#formulir').hide();
                        } else {
                            $('#bukaFileAbstrak').attr('href', response.file_url);
                            $('#textStatus').hide();
                            $('#formulir').show();
                        }
                        $('#bukaFileAbstrak').attr('href', response.file_url);
                        $('#idFile').val(response.id_file);
                        $('#periksa').modal('show');
                        $('#datatable-abstrak').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            };
            $('#updateHasil').click(function() {
                var id_file = $('#idFile').val();
                var hasil = $('#selectHasil').val();
                var catatan = $('#catatanHasil').val();
                var file = document.getElementById('fileHasilPemeriksaan').files[0];

                var formData = new FormData();


                formData.append('id_file', id_file);
                formData.append('hasil', hasil);
                formData.append('catatan', catatan);
                formData.append('file', file);

                $.ajax({
                    type: 'POST',
                    url: '/abstrak/hasil-periksa',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#datatable-abstrak').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
            $('#export-pdf').click(function() {
                var queryParams = $.param({
                    id_jurusan: $('#selectJurusan').val(),
                    id_fakultas: $('#selectFakultas').val(),
                    status: $('#selectStatus').val(),
                });
                var exportUrl = '{{ route('laporan.pdf-pengajuan') }}?' + queryParams;
                window.open(exportUrl, '_blank');
            });
            $('#export-excel').click(function() {
                var queryParams = $.param({
                    id_jurusan: $('#selectJurusan').val(),
                    id_fakultas: $('#selectFakultas').val(),
                    status: $('#selectStatus').val(),
                });
                var exportUrl = '{{ route('laporan.excel-pengajuan') }}?' + queryParams;
                window.open(exportUrl, '_blank');
            });


        });
    </script>
@endpush
