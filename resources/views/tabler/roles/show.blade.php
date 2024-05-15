@extends('layouts.app')
@section('content')
    <div class="">
        <!-- Main Wrapper -->
        <div id="wrapper">
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col">
                                <div class="hpanel">
                                    <div class="panel-body">
                                        <div style="display: flex; flex-direction: column; align-items: center;">
                                            <h3 class="p-0 m-0">{{ $role->name }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="hpanel">
                                <div class="panel-body">
                                    <div class="panel-title">ASSIGN PERMISSIONS</div>
                                    <div class="row" style="margin-top: 15px;">
                                        @if( $modules_permissions != null)
                                            @if(count($modules_permissions) > 0)
                                                @foreach($modules_permissions as $permission)
                                                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                                        <div class="permission_title margin-bottom">
                                                            <input type="checkbox" class="form-check m-r-n-sm" disabled/>
                                                            <span>{{ $permission->name }}</span>
                                                        </div>
                                                        @if(count($permission->permissions) > 0)
                                                            @foreach($permission->permissions as $perm)
                                                                <div class="a_permission" data-permission="{{ $perm->name }}">
                                                                    <input type="checkbox" class="form-check m-r-n-sm" {{ $role->hasPermissionTo($perm->name) ? 'checked' : '' }}/>
                                                                    <div class="nav-divider"></div>
                                                                    <span style="padding-left: 3px;">{{ $perm->name }}</span>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                        <hr/>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("scripts")
    <script type="text/javascript">
        $(function () {
            $(document).on("click", ".a_permission input[type='checkbox']", function () {
                const permission = $(this).closest('.a_permission').data("permission");
                const role_id = "{{ $role->id }}";
                const isChecked = $(this).prop('checked');

                const data = {
                    "permission": permission,
                    "role_id": role_id,
                    "isChecked": isChecked
                };

                $.ajax({
                    url: "{{ route('role.permissions') }}",
                    method: "POST",
                    dataType: "json",
                    data: JSON.stringify(data),
                    success: function (response) {
                        if(response.status === true){
                            toastr.success(response.message);
                        }
                    },
                    error: function (error) {
                        console.log(error);
                        const anError = error.responseJSON.message;
                        toastr.error(anError);
                    }
                })
            })
        });
    </script>
@endsection




