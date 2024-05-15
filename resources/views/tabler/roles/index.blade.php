@extends('layouts.app')

@section('content')
    <div class="">

        @include("nisimpo::roles.add_role_modal")

        <!-- Main Wrapper -->
        <div id="wrapper">

            <div class="content">
               <div class="bg-white col p-md">
                   <div class="row">
                       <div class="col-sm-6">
                           <h1 class="p-0 m-0">Roles</h1>
                       </div>
                       <div class="col-sm-6">
                           <button class="btn btn-success" id="roleAddBtn" style="float: right;">Add Role</button>
                       </div>
                   </div>
                   <div class="table-responsive w-100">
                       <table class="table table-striped" id="tableRoles">
                           <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Name</th>
                                <th>Guard</th>
                                <th>Action</th>
                            </tr>
                           </thead>
                           <tbody>

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

            const roleError = $("#role-error");
            const roleModal = $("#roleModal");

            roleError.hide();

            const tableUsers = $('#tableRoles').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("roles.index") }}',
                    type: 'GET'
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'guard_name', name: 'guard_name'},
                    {data: 'action', name: 'action'},
                    /* {
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

            $(document).on("click", "#roleAddBtn", function(){
                 method = "POST";
                 baseURL = "{{ route('role.add') }}";
                 roleModal.modal("show");
            });



            $(document).on("click", ".deleteRole" , function(){

                 alert("Data Delete");

                //const id = $(this).data("id");

                //method = "DELETE";

                //baseURL = "{{ route('role.destroy',['id']) }}".replace("id", id);

                //  swal({
                //     title: "Are you sure?",
                //     text: "Your will not be able to recover this!",
                //     type: "warning",
                //     showCancelButton: true,
                //     confirmButtonColor: "#DD6B55",
                //     confirmButtonText: "Yes, delete it!",
                //     cancelButtonText: "No, cancel plx!",
                //     closeOnConfirm: false,
                //     closeOnCancel: false
                //    },function (isConfirm) {
                //         if (isConfirm) {
                //             $.ajax({
                //                 url: baseURL,
                //                 method: method,
                //                 dataType: "json"
                //             }).done( response => {
                //                 if(response.status === true){
                //                     swal("Deleted!", "Role has been deleted.", "success");
                //                     tableUsers.draw();
                //                 }
                //             }).fail( error => {

                //             });

                //         } else {
                //             swal("Cancelled", "User is safe :)", "error");
                //         }
                //     }
                // );

              });



            $(document).on("click", ".editRole" , function(){
                 const id = $(this).data("id");
                 const url = "{{ route('role.edit',['id']) }}".replace("id", id);

                 method = "PUT";

                 baseURL = "{{ route('role.update',['id']) }}".replace("id", id);

                 $.ajax({
                       url: url,
                       method: "GET",
                       dataType: "json",
                       success: function (response){
                           console.log("response");
                           console.log(response);
                           if(response !== null){
                               roleModal.modal("show");
                               $("#role").val(response.name);
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


            $(document).on("click","#addRoleBtn", function (){
                 const name = $("input[name='role']");
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
                               roleModal.modal("hide");
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

            $(document).on("hidden.bs.modal", function(){
                 baseURL = "";
                 method = "";
                 $("#role").val(" ");
            });
        })
    </script>
@endsection



