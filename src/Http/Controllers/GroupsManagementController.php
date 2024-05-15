<?php

namespace BizyTech\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthorizeUserTrait;
use BizyTech\Auth\Services\AuthorizationService;
use BizyTech\Auth\Services\GroupsManagementService;

class GroupsManagementController extends Controller {

    use AuthorizeUserTrait;

    public function __construct(protected GroupsManagementService $groupsManagementService,
    protected  AuthorizationService $authorizationService)
    {

    }

    public function index() {
        if (\request()->ajax()){
            return  $this->groupsManagementService->groupsDatatable();
        }
        return view("nisimpo::groups.index");
    }

    public function show($id) {
        $module = $this->groupsManagementService->findGroupWithPermissions($id);
        $permissions = $this->authorizationService->findAllPermissions();
        return view("nisimpo::groups.show", compact("module","permissions"));
    }

    public function create(Request $request)
    {
        $input = $request->validate([
            "name" => "required|string|unique:modules,name"
        ]);

        $isCreated = $this->groupsManagementService->createGroup($input);

        if($isCreated){
            return $this->successResponse();
        }
        return $this->failedResponse();
    }

    public function assignGroupPermissions() {
        $dataReceived  = file_get_contents("php://input");
        $data = json_decode($dataReceived , true);

        $permission = $this->authorizationService->findPermission($data["permission"])->first();

        if(!$permission){
            throw new ModelNotFoundException('Permission not found');
        }else{
            $permission =  $data["permission"];
            if ($data["isChecked"]  === true){
                $this->authorizationService->givePermissionsToGroup($data["module_id"], $permission);
            }else{
                $this->authorizationService->revokePermissionFromGroup($permission);
            }
        }
        return $this->successResponse();
    }


    public function successResponse() {
        return \response()->json([
            "status" => true,
            "message" => "Successfully Added !!"
        ]);
    }

    public function failedResponse() {
        return response()->json([
            "status" => false,
            "message" => "Failed to save changes !!"
        ]);
    }

}
