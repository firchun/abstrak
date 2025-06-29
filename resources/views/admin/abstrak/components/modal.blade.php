<!-- Modal pembayaran -->
<div class="modal fade" id="pembayaran" tabindex="-1" aria-labelledby="UsersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
                        class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive mb-4 mt-4">
                    <table id="datatable-pembayaran" class="table table-hover table-bordered display">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>File</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>File</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Create and Edit -->
<div class="modal fade" id="periksa" tabindex="-1" aria-labelledby="UsersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Pemeriksaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
                        class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <!-- Form for Create and Edit -->
                <div class="mb-3">
                    <label>File Pengajuan Abstrak</label><br>
                    <a href="" class="btn btn-success" id="bukaFileAbstrak" target="__blank">Buka File
                        Abstrak</a>
                    <span class="text-danger" id="textStatus" style="display: none;">Menunggu Upload Ulang</span>
                </div>
                <div class="mb-3">
                    <label>File Hasil Abstrak</label><br>
                    <a href="" class="btn btn-primary" id="bukaFileAbstrakStaff" target="__blank">Buka File
                        Abstrak</a>
                </div>
                <hr>
                <div class="" id="formulir">

                    <h5>Hasil pemeriksaan</h5>
                    <form enctype="multipart/form-data">
                        <input type="hidden" id="idFile" value="">
                        <div class="mb-3">
                            <label>File hasil pemeriksaan <span class="text-warning">(Upload jika hasil telah
                                    selesai )(2 MB)</span></label>
                            <input type="file" accept="aplication/pdf" name="file" class="form-control"
                                id="fileHasilPemeriksaan">
                        </div>
                        <div class="mb-3">
                            <label>Hasil</label>
                            <select id="selectHasil" name="hasil" class="form-control" required>
                                <option value="Selesai">Selesai</option>
                                <option value="Revisi">Revisi</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Catatan</label>
                            <textarea id="catatanHasil" name="catatan" class="form-control">-</textarea>
                        </div>
                        <button type="button" class="btn btn-primary" id="updateHasil">Update Hasil
                            Pemeriksaan</button>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
