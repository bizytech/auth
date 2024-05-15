<div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
               {{-- <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true"><i class="fa fa-close" aria-hidden="true"></i></span>
                    <span class="sr-only">Close</span>
                </button>--}}
                <h4 class="modal-title">Add Role</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="role">Name</label>
                        <input type="text" name="role" class="form-control" id="role"/>
                        <span class="error-message" id="role-error">Role Name is required !!</span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addRoleBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>
