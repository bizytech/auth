@extends('layouts.app')

@section('content')
    <div class="container">
       <div class="row">
           <div class="col-sm-3">
               <div class="col">
                  <div class="card">
                      <div class="card-body">
                          <div style="display: flex; flex-direction: column; align-items: center;">
                              <img src="{{ asset('vendor/homer/images/profile.jpg') }}" class="img-circle" alt="logo">
                              <h3 class="p-0 m-0 text-center">{{ $user->full_name }}</h3>
                              <h4 class="p-0 m-0 text-success">{{ $user->is_active ? "ACTIVE" : "INACTIVE" }} </h4>
                              <div class="row mt-3">
                                  <a class="btn btn-primary" href="{{ $user->id }}">Edit</a>
                                  <a class="btn btn-danger" href="{{ $user->id }}">Delete</a>
                              </div>
                          </div>
                      </div>
                  </div>
               </div>
           </div>
           <div class="col-sm-9">
               <div class="card">
                   <div class="card-header">ASSIGN ROLE</div>
                   <div class="card-body">
                       <div class="row">
                           @if(count($roles) > 0)
                               @foreach($roles as $role)
                                   <div class="col-sm-4">
                                       <div class="a_role" data-role="{{ $role->name }}">
                                           <input type="checkbox" {{ $user->hasRole($role->name) ? 'checked' : '' }} class="form-check m-r-n-sm"/>
                                           <div class="nav-divider"></div>
                                           <span>{{ $role->name }}</span>
                                       </div>
                                   </div>
                               @endforeach
                           @endif
                       </div>
                   </div>
               </div>
               <div class="card">
                   <div class="card-header">ASSIGN PERMISSIONS</div>
                   <div class="card-body">
                       <div class="row">
                          @if( $modules_permissions != null)
                              @if(count($modules_permissions) > 0)
                                  @foreach($modules_permissions as $permission)
                                      <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                          <div class="permission_title margin-bottom" data-id="{{ $permission->id }}">
                                              <input type="checkbox" class="form-check m-r-n-md" disabled/>
                                              <span style="margin-left: 2px;;">{{ $permission->name }}</span>
                                          </div>
                                          @if(count($permission->permissions) > 0)
                                              @foreach($permission->permissions as $perm)
                                                  <div class="a_permission" data-permission="{{ $perm->name }}">
                                                      <input type="checkbox" class="form-check m-r-n-md" {{ $user->hasPermissionTo($perm->name) ? 'checked' : '' }}/>
                                                      <span style="margin-left: 2px;;">{{ $perm->name }}</span>
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
@endsection

@section("scripts")
     <script type="text/javascript">
         $(function () {

             $(document).on("click", ".a_permission input[type='checkbox']", function () {
                 const permission = $(this).closest('.a_permission').data("permission");
                 const user_id = "{{ $user->id }}";
                 const isChecked = $(this).prop('checked');

                 const data = {
                     "permission": permission,
                     "user_id": user_id,
                     "isChecked": isChecked
                 };

                 $.ajax({
                     url: '{{ route("user.permissions") }}',
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
                 });

             })


             $(document).on("click", ".a_role input[type='checkbox']", function () {
                 const permission = $(this).closest('.a_role').data("role");
                 const user_id = "{{ $user->id }}";
                 const isChecked = $(this).prop('checked');

                 const data = {
                     "role": permission,
                     "user_id": user_id,
                     "isChecked": isChecked
                 };

                 $.ajax({
                     url: '{{ route("user.role") }}',
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
                 });

             })
         });

     </script>
@endsection


