@extends('nisimpo::layouts.app')

@section('content')
    <div class="">

        <!-- Header -->
        @include("nisimpo::common.navbar")

        <!-- Navigation -->

        @include("nisimpo::common.sidebar")

        <!-- Main Wrapper -->
        <div id="wrapper">

            <div class="content">
                <div class="bg-white p-sm">
                    <div class="row ">
                        <div class="col-sm-6">
                            <h1 class="p-0 m-0">Users</h1>
                        </div>
                        <div class="col-sm-6">
                            <button class="btn btn-success" style="float: right;">Add</button>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="table-responsive  mt-3">
                            <table  class="table  table-striped" id="tableUsers">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  {{--@foreach($users as $user)
                                    <tr>
                                        <td>{{$loop->iteration }}</td>
                                        <td>{{$user->full_name}}</td>
                                        <td>{{$user->gender}}</td>
                                        <td>{{$user->is_active ? "Active":"Inactive"}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <span class="glyphicon glyphicon-option-vertical" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" aria-hidden="true"></span>
                                                <ul class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenu1">
                                                    <li class="dropdown-header">Actions</li>
                                                    <li>
                                                        <a href="{{ route("user.show",[$user->id]) }}">
                                                            <span class="glyphicon glyphicon-eye-open text-success" aria-hidden="true"></span> View
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span class="glyphicon glyphicon-edit text-primary" aria-hidden="true"></span> Edit
                                                        </a>
                                                    </li>
                                                    <li role="separator" class="divider"></li>
                                                    <li>
                                                        <a href="#">
                                                            <span class="glyphicon glyphicon-trash text-danger" aria-hidden="true"></span> Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach--}}
                                </tbody>
                            </table>
                            <!--
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Full Name</th>
                                    <th>Gender</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Said Khamis</td>
                                    <td>Male</td>
                                    <td>=Active</td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
        -->
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection

@section("scripts")
     <script type="text/javascript">
          $(function (){
              const tableUsers = $('#tableUsers').DataTable({
                  processing: true,
                  serverSide: true,
                  ajax: {
                      url: '{{ route("users.index") }}',
                      type: 'GET'
                  },
                  columns: [
                      {data: 'id', name: 'id'},
                      {data: 'full_name', name: 'full_name'},
                      {data: 'email', name: 'email'},
                      {data: 'gender', name: 'gender'},
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
          })
     </script>
@endsection


