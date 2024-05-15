@extends('layouts.app')

@section('content')
    <div class="">

        @include("bizytech::groups.add_group_modal")

        <!-- Main Wrapper -->
        <div id="wrapper">

            <div class="content">
                <div class="bg-white col p-md">
                    <div class="row">
                        <div class="col-sm-6">
                            <h1 class="p-0 m-0">Groups (Modules) </h1>
                        </div>
                        <div class="col-sm-6">
                            <button class="btn btn-success" data-toggle="modal" data-target="#groupsModel" style="float: right;">Add</button>
                        </div>
                    </div>
                    <div class="table-responsive w-100 m-t-n-sm">
                        <table class="table table-striped" id="tableRoles">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Name</th>
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
            const groupsModel = $("#groupsModel");

            roleError.hide();
            const tableUsers = $('#tableRoles').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("groups.index") }}',
                    type: 'GET'
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
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

            $(document).on("click","#addGroupBtn", function (){
                const name = $("input[name='group']");
                if(name.val() === ""){
                    roleError.show();
                }else{
                    const url = "{{ route("group.create") }}";

                    $.ajax({
                        url: url,
                        method: "POST",
                        dataType: "json",
                        data: {
                            "name" : name.val()
                        },
                        success: function (response){
                            console.log("response");
                            console.log(response);
                            if(response.status === true){
                                tableUsers.draw();
                                groupsModel.modal("hide");
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
        })
    </script>
@endsection



