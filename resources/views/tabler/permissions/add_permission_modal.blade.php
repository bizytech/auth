<div class="modal fade" id="permissionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="color-line"></div>
            <div class="modal-header text-center">
                <h4 class="modal-title">Add Permission</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="permission">Name</label>
                        <input type="text" name="permission" class="form-control" id="permission"/>
                        <span class="error-message" id="permission-error">Permission Name is required !!</span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addPermissionBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>
