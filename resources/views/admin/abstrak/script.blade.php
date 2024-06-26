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
                $('#datatable-abstrak').DataTable().ajax.reload();
            });
            window.pemeriksaanAbstrak = function(id) {
                $.ajax({
                    type: 'GET',
                    url: '/abstrak/periksa/' + id,
                    success: function(response) {
                        if (response.status_file == 2) {
                            $('#bukaFileAbstrak').hide();
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


        });
    </script>
@endpush
