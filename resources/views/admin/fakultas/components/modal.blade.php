<!-- Modal for Create and Edit -->
<div class="modal fade" id="UsersModal" tabindex="-1" aria-labelledby="UsersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">User Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
                        class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <!-- Form for Create and Edit -->
                <form id="fakultasForm">
                    <input type="hidden" id="formFakultasId" name="id">
                    <div class="mb-3">
                        <label for="formFakultas" class="form-label">Nama Fakultas</label>
                        <input type="text" class="form-control" id="formFakultas" name="fakultas" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveFakultasBtn">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="create" tabindex="-1" aria-labelledby="UsersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">User Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
                        class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <!-- Form for Create and Edit -->
                <form id="createFakultasForm">
                    <div class="mb-3">
                        <label for="formCreateFakultas" class="form-label">Nama Fakultas</label>
                        <input type="text" class="form-control" id="formCreateFakultas" name="fakultas" required>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="createFakultasBtn">Save</button>
            </div>
        </div>
    </div>
</div>
