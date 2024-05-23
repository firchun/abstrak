@push('js')
    <script>
        $(function() {
            $('#datatable-fakultas').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ url('fakultas-datatable') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'fakultas',
                        name: 'fakultas'
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
                    url: '/fakultas/edit/' + id,
                    success: function(response) {
                        $('#UsersModalLabel').text('Edit User');
                        $('#formFakultasId').val(response.id);
                        $('#formFakultas').val(response.fakultas);
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
                    url: '/fakultas/store',
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
                    url: '/fakultas/store',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#userssModalLabel').text('Edit User');
                        $('#formCreateFakultas').val('');
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
                        url: '/fakultas/delete/' + id,
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
