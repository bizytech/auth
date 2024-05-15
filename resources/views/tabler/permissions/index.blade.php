@extends('layouts.app')

@section('content')
    <div class="">
        <!-- Main Wrapper -->
        <div id="wrapper">

            @include("nisimpo::permissions.add_permission_modal")

            <div class="content">
                <div class="bg-white p-md col">
                    <div class="row">
                        <div class="col-sm-6">
                            <h1 class="p-0 m-0">Permissions</h1>
                        </div>
                        <div class="col-sm-6">
                            <button class="btn btn-success" style="float: right;" id="btnAddPermissions">Add</button>
                        </div>
                    </div>
                    <div class="table-responsive w-100">
                        <table class="table table-striped" id="tablePermissions">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Name</th>
                                <th>Guard</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{--@if(count($permissions) > 0)
                              @foreach($permissions as $permission)
                                  <tr>
                                      <td>{{ $loop->iteration }}</td>
                                      <td>{{ $permission->name }}</td>
                                      <td>{{ $permission->guard_name }}</td>
                                      <td>
                                          <div class="dropdown">
                                              <span class="glyphicon glyphicon-option-vertical" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" aria-hidden="true"></span>
                                              <ul class="dropdown-menu " aria-labelledby="dropdownMenu1">
                                                  <li class="dropdown-header">Actions</li>
                                                  <li>
                                                      <a href="">
                                                          <span class="glyphicon glyphicon-eye-open text-success" aria-hidden="true"></span> View
                                                      </a>
                                                  </li>
                                                  <li><a href="#">Edit</a></li>
                                                  <li role="separator" class="divider"></li>
                                                  <li><a href="#">Delete</a></li>
                                              </ul>
                                          </div>
                                      </td>
                                  </tr>
                              @endforeach
                          @endif--}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection

@section("scripts")
    <script type="text/javascript">
        $(function (){

            const roleError = $("#permission-error");
            const permissionModal = $("#permissionModal");
            const name = $("input[name='permission']");

            roleError.hide();
            const tableUsers = $('#tablePermissions').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("permissions.index") }}',
                    type: 'GET'
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'guard_name', name: 'guard_name'},
                    {data: 'action', name: 'action'},
                    /*   {
                           data: 'action',
                           name: 'action',
                           orderable: false,
                           searchable: false,
                           render: function(data, type, row) {
                               return data;
                           }
                       },*/
                ],
            });

            let baseURL , method = "";

            $(document).on("keyup", "#permission", function (){
                 const permission = $(this).val();
                 if(permission !== ""){
                     roleError.hide();
                 }
            });

            $(document).on("click", "#btnAddPermissions", function(){
                 permissionModal.modal("show");
                 baseURL = '{{ route("permissions.add") }}';
                 method = "POST";
            });

            $(document).on("click", ".editPermission", function(){
                 permissionModal.modal("show");

                 const id = $(this).data("id");
                 const url = "{{ route('permission.edit',['id']) }}".replace("id", id);

                 method = "PUT";

                 baseURL = "{{ route('permission.update',['id']) }}".replace("id", id);

                 $.ajax({
                       url: url,
                       method: "GET",
                       dataType: "json",
                       success: function (response){
                           console.log("response");
                           console.log(response);
                           if(response !== null){
                               permissionModal.modal("show");
                               $("#permission").val(response.name);
                           }
                       },
                       error: function (error){
                           console.log("error");
                           console.log(error);
                           const anError = error.responseJSON.message;
                           console.log(anError);
                           toastr.error(anError);
                       }
                   });

            });

            $(document).on("click","#addPermissionBtn", function (){
                if(name.val() === ""){
                    roleError.show();
                }else{

                    $.ajax({
                        url: baseURL,
                        method: method,
                        dataType: "json",
                        data: {
                            "name" : name.val()
                        },
                        success: function (response){
                            console.log("response");
                            console.log(response);
                            if(response.status === true){
                                tableUsers.draw();
                                permissionModal.modal("hide");
                                toastr.success(response.message);
                            }
                        },
                        error: function (error){
                            console.log("error");
                            console.log(error);
                            const anError = error.responseJSON.message;
                            console.log(anError);
                            toastr.error(anError);
                        }
                    });
                }
            });

            $(document).on("click",".deletePermission", function(){
                const id = $(this).data("id");

                method = "DELETE";

                baseURL = "{{ route('permission.destroy',['id']) }}".replace("id", id);

                 swal({
                    title: "Are you sure?",
                    text: "Your will not be able to recover this!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                   },function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: baseURL,
                                method: method,
                                dataType: "json"
                            }).done( response => {
                                if(response.status === true){
                                    swal("Deleted!", "Role has been deleted.", "success");
                                    tableUsers.draw();
                                }
                            }).fail( error => {

                            });

                        } else {
                            swal("Cancelled", "User is safe :)", "error");
                        }
                    }
                );
            });

            $(document).on("hidden.bs.modal", function(){
               baseURL = " ";
               method = " ";
               name.val(" ");
            });

        });
    </script>
@endsection


