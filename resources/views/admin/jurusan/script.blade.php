@push('js')
    <script>
        $(function() {
            $('#datatable-fakultas').DataTable({
                processing: true,
                serverSide: false,
                responsive: false,
                ajax: '{{ url('jurusan-datatable') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'fakultas.fakultas',
                        name: 'fakultas.fakultas'
                    },
                    {
                        data: 'jurusan',
                        name: 'jurusan'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });
            $('.create-new').click(function() {
                $('#create').modal('show');
            });
            window.editFakultas = function(id) {
                $.ajax({
                    type: 'GET',
                    url: '/jurusan/edit/' + id,
                    success: function(response) {
                        $('#UsersModalLabel').text('Edit User');
                        $('#formFakultasId').val(response.id);
                        $('#formIdFakultas').val(response.id_fakultas);
                        $('#formJurusan').val(response.jurusan);
                        $('#UsersModal').modal('show');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            };
            $('#saveFakultasBtn').click(function() {
                var formData = $('#fakultasForm').serialize();

                $.ajax({
                    type: 'POST',
                    url: '/jurusan/store',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        // Refresh DataTable setelah menyimpan perubahan
                        $('#datatable-fakultas').DataTable().ajax.reload();
                        $('#usersModal').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
            $('#createFakultasBtn').click(function() {
                var formData = $('#createFakultasForm').serialize();

                $.ajax({
                    type: 'POST',
                    url: '/jurusan/store',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);

                        $('#datatable-fakultas').DataTable().ajax.reload();
                        $('#create').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });

            window.deleteFakultas = function(id) {
                if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/jurusan/delete/' + id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            alert(response.message);
                            // Refresh DataTable setelah menghapus pengguna
                            $('#datatable-fakultas').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            alert('Terjadi kesalahan: ' + xhr.responseText);
                        }
                    });
                }
            };
        });
    </script>
@endpush
