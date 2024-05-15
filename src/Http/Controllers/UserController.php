<?php

namespace BizyTech\Auth\Http\Controllers;

use BizyTech\Auth\Models\Module;
use http\Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\AuthorizeUserTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use BizyTech\Auth\Models\User;
use BizyTech\Auth\Services\AuthorizationService;
use BizyTech\Auth\Services\UserManagementService;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Models\Role;



class UserController extends Controller
{
    use AuthorizeUserTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

     public function __construct(protected AuthorizationService $authorizationService,
        protected UserManagementService $userManagementService) {
        $this->middleware('auth');
    }


    public function users(): View
    {
        $users = $this->userManagementService->findAllUsers();
        return view('nisimpo::users.index',compact('users'));
    }


    public function edit(string $id)
    {
       $user = $this->userManagementService->findUser($id);
       return $user;
    }


    public function delete($id)
    {
      try{
        $user = $this->userManagementService->deleteUser($id);
        if ($user){
            return $this->successResponse();
        }
      }catch(\Exception $exception){
        return $this->failedResponse($exception);
      }
      return null;
    }


    public function update(Request $request , string $id)
    {
        $inputs = $request->validate([
            "full_name" => "required|string",
            "email" => "required|string|unique:users,email",
            "gender" => "required|string",
            "is_active" => "required|string",
            "is_app_user" => "required|string",
            "password" => "required|string",
            "username" => "required|string",
            "user_type" => "required|string",
        ]);

        try {
            $isUpdated = $this->userManagementService->updateUser($inputs , $id);
            if ($isUpdated){
                return $this->successResponse();
            }
        }catch (\Exception $exception){
            return $this->failedResponse($exception);
            //Log::error("An error occurred :" . $exception->getMessage());
        }
        return null;
    }


    public function index()
    {
        $users = $this->userManagementService->findAllUsers();
        if (\request()->ajax()){
            return  $this->userManagementService->usersDatatable();
        }
        return view('nisimpo::users.index', compact('users'));
    }


    public function roles()
    {
        $roles = $this->findAllRoles();
        if (\request()->ajax()){
            return  $this->userManagementService->rolesDatatable();
        }
        return view('nisimpo::roles.index', compact('roles'));
    }



    public function updatePermission(Request $request , string $id)
    {
        $inputs = $request->validate([
            "name" => "required|string"
        ]);

        try {
            $isUpdated = $this->userManagementService->updatePermission($inputs , $id);
            if ($isUpdated){
                return $this->successResponse();
            }
        }catch (\Exception $exception){
            return $this->failedResponse($exception);
            //Log::error("An error occurred :" . $exception->getMessage());
        }
        return null;
    }


    public function updateRole(Request $request , string $id)
    {
        $inputs = $request->validate([
            "name" => "required|string"
        ]);

        try {
            $isUpdated = $this->userManagementService->updateRole($inputs , $id);
            if ($isUpdated){
                return $this->successResponse();
            }
        }catch (\Exception $exception){
            return $this->failedResponse($exception);
            //Log::error("An error occurred :" . $exception->getMessage());
        }
        return null;
    }

    public function deleteRole($id)  {
        try{
            $role = $this->userManagementService->deleteRole($id);
            if ($role){
                return $this->successResponse();
            }
          }catch(\Exception $exception){
            return $this->failedResponse($exception);
          }
          return null;
    }


    public function deletePermission($id) {
        try{
            $role = $this->userManagementService->deletePermission($id);
            if ($role){
                return $this->successResponse();
            }
          }catch(\Exception $exception){
            return $this->failedResponse($exception);
          }
          return null;
    }

    public function editRole($id) {
        return $this->userManagementService->findRole($id);
    }

    public function editPermission($id) {
        return $this->userManagementService->findPermission($id);
    }

    public function permissions()
    {
        $permissions = $this->findAllPermissions();
        if (\request()->ajax()){
            return  $this->userManagementService->permissionsDatatable();
        }
        return view('nisimpo::permissions.index', compact('permissions'));
    }

    /**
     * Assign some permissions to a role
     * @param Request $request a user input request
     * @return RedirectResponse
     */
    public function givePermissionsToRole(Request $request)
    {
        $dataReceived  = file_get_contents("php://input");
        $data = json_decode($dataReceived , true);

        $role = Role::find($data["role_id"]);

        if(!$role){
            throw RoleDoesNotExist::withId($data["role_id"],'');
        }else{
            if ($data["isChecked"]  === true){
                $this->authorizationService->givePermissionsToRole($role, $data["permission"]);
            }else{
                $this->authorizationService->revokePermissionFromRole($role,  $data["permission"]);
            }
        }
        return $this->successResponse();
    }


    public function givePermissionsToUser(Request $request)
    {
        $dataReceived  = file_get_contents("php://input");
        $data = json_decode($dataReceived , true);

        $user = $this->userManagementService->findUser($data["user_id"]);

        if(!$user){
            throw new ModelNotFoundException('User not found');
        }else{
            $permission =  $data["permission"];
            if ($data["isChecked"]  === true){
                $this->authorizationService->assignDirectPermissionToUser($user, $permission);
            }else{
              $this->authorizationService->revokePermissionFromUser($user, $permission);
            }
        }
        return $this->successResponse();
    }


    public function assignUserRole(Request $request)
    {
        $dataReceived  = file_get_contents("php://input");
        $data = json_decode($dataReceived , true);

        $user = User::find($data["user_id"]);

        if(!$user){
            throw new ModelNotFoundException('User not found');
        }else{
            if($data["isChecked"]  === true){
                $this->authorizationService->assignRoleToUser($user,$data["role"]);
            }else{
                $this->authorizationService->revokeRoleFromUser($user, $data["role"]);
            }
        }

        return $this->successResponse();
    }


    public function createNewPermissions(Request $request)
    {
        $input = $request->validate([
            "name" => "required|string"
        ]);

        $this->createPermissions($input["name"]);

        return $this->successResponse();
    }


    public function createNewRole(Request $request)
    {
        //Role should be an array
        $input = $request->validate([
            "name" => "required|string"
        ]);

        $this->createRoles($input["name"]);

        return $this->successResponse();
    }


    public function showUser(string $id)
    {
        $roles = $this->findAllRoles();
        $user = $this->userManagementService->findUser($id);
        $modules_permissions = Module::query()->with("permissions")->get();
        return view('nisimpo::users.show',compact("user","roles","modules_permissions"));
    }


    public function showRole(string $id)
    {
        $roles = $this->findAllRoles();
        $role = $this->authorizationService->findRole($id);
        $modules_permissions = Module::query()->with("permissions")->get();
        return view('nisimpo::roles.show',compact("role","roles","modules_permissions"));
    }


    public function createUser(Request $request)
    {

        $inputs = $request->validate([
            "full_name" => "required|string",
            "email" => "required|string|unique:users,email",
            "gender" => "required|string",
            "is_active" => "required|string",
            "is_app_user" => "required|string",
            "password" => "required|string",
            "username" => "required|string",
            "user_type" => "required|string",
        ]);

        try {
            $isCreate = $this->userManagementService->createUser($inputs);
            if ($isCreate){
                return $this->successResponse();
            }
        }catch (\Exception $exception){
            return $this->failedResponse($exception);
            //Log::error("An error occurred :" . $exception->getMessage());
        }
        return null;
    }


    public function successResponse()
    {
        return \response()->json([
            "status" => true,
            "message" => "Successfully Added !!"
        ]);
    }


    public function failedResponse($error)
    {
        return \response()->json([
            "status" => false,
            "message" => $error->getMessage()
        ]);
    }
}
