<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" id="errorAlert">
                   <strong>Error</strong>
                </div>
                <form>
                     <div class="row">
                         <div class="col-sm-6">
                             <div class="form-group">
                                 <label for="full_name">Full Name</label>
                                 <input type="text" name="full_name" class="form-control" id="full_name"/>
                                 <span class="error-message" id="full-name-error">Full Name is required !!</span>
                             </div>
                         </div>
                         <div class="col-sm-6">
                             <div class="form-group">
                                 <label for="gender">Gender</label>
                                 <select class="form-control" name="gender" id="gender">
                                     <option value="" selected> Select Gender </option>
                                     <option value="MALE">Male</option>
                                     <option value="FEMALE">Female</option>
                                 </select>
                                 <span class="error-message" id="gender-error">Gender Name is required !!</span>
                             </div>
                         </div>
                     </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="user_type">User Type</label>
                                <select class="form-control" name="user_type" id="user_type">
                                    <option value="" selected>Select Type</option>
                                    <option value="AMCOS">AMCOS</option>
                                    <option value="SSF">SSF</option>
                                    <option value="BANK">BANK</option>
                                    <option value="UNION">UNION</option>
                                    <option value="BANK BRANCH">BANK BRANCH </option>
                                    <option value="SYSTEM">SYSTEM</option>
                                </select>
                                <span class="error-message" id="user-type-error">User Type is required !!</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" class="form-control" id="email"/>
                                <span class="error-message" id="email-error">Email is required !!</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group check_inputs">
                                <input type="checkbox" class="form-check m-r-n-sm" id="is_active"/>
                                <span> Active </span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group check_inputs">
                                <input type="checkbox" class="form-check m-r-n-sm" id="is_app_user"/>
                                <span> App User </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" id="username"/>
                                <span class="error-message" id="username-error">Username is required !!</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" id="password"/>
                                <span class="error-message" id="password-error">Password is required !!</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button class="ladda-button ladda-button-demo btn btn-primary"  data-style="zoom-in">Submit</button>
{{--                <button type="button" class="btn btn-primary" id="addUserBtn">Save changes</button>--}}
            </div>
        </div>
    </div>
</div>
