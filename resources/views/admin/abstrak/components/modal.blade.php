<!-- Modal for Create and Edit -->
<div class="modal fade" id="periksa" tabindex="-1" aria-labelledby="UsersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Pemeriksaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
                        class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <!-- Form for Create and Edit -->
                <div class="mb-3">
                    <label>File Astrak</label><br>
                    <a href="" class="btn btn-success" id="bukaFileAbstrak" target="__blank">Buka File Abstrak</a>
                    <span class="text-danger" id="textStatus" style="display: none;">Menunggu Upload Ulang</span>
                </div>
                <hr>
                <div class="" id="formulir">

                    <h5>Hasil pemeriksaan</h5>
                    <form>
                        <input type="hidden" id="idFile" value="">
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
                        <button type="button" class="btn btn-primary" id="updateHasil">Update Hasil Pemeriksaan</button>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

