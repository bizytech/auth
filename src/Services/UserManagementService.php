<?php

namespace Nisimpo\Auth\Services;

use Illuminate\Database\Eloquent\Collection;
use Nisimpo\Auth\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;


class UserManagementService
{
    public function findAllUsers(): Collection {
        return User::orderByDesc("id")->get();
    }

    public function findUser($id) {
        return User::find($id);
    }

    public function createUser($user)
    {
        return User::create([
            "full_name" => $user["full_name"],
            "email" => $user["email"] ,
            "gender" => $user["gender"],
            "is_active" => $user["is_active"] === "true",
            "is_app_user" => $user["is_app_user"] === "true",
            "password" => Hash::make($user["password"]),
            "username" => $user["username"],
            "user_type" => $user["user_type"],
            "userable_type" => "Entity",
            "userable_id" => 1
        ]);
    }

    public function RolesDatatable()
    {
        $perPage = \request()->input("length");
        $page = ($perPage !== 0)
            ? (\request()->input("start") / $perPage + 1)
            : 1;

        $searchValue = request()->input('search.value');

        $query = Role::query();

        $totalRecordsBeforeSearch = Role::count();

        if (!empty($searchValue)) {
            $query->where('name', 'like', '%' . $searchValue . '%')
                ->orWhere('guard_name', 'like', '%' . $searchValue . '%');
        }

        $totalRecordsAfterSearch = $query->count();

        $roles = $query->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        return response()->json([
            'draw' => \request()->input("draw"),
            "recordsTotal" => $totalRecordsBeforeSearch,
            'recordsFiltered' => $totalRecordsAfterSearch,
            'data' => $roles->map(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                    'guard_name' => $role->guard_name ,
                    'action' => '<div class="dropdown">
                                                <span class="glyphicon glyphicon-option-vertical" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" aria-hidden="true"></span>
                                                <ul class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenu1">
                                                    <li class="dropdown-header">Actions</li>
                                                    <li>
                                                        <a href="'. route("role.show",[ $role->id]).'">
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
                                            </div>',
                ];
            }),
            'input' => [
                'draw' => \request()->input("draw"),
                'columns' => \request()->input("columns"),
                'order' => \request()->input("order"),
                'start' => \request()->input("start"),
                'length' => \request()->input("length"),
                'search' => \request()->input("search"),
                '_' => \request()->input("_"),
            ],
        ]);

    }

    public function permissionsDatatable()
    {

        $perPage = \request()->input("length");
        $page = ($perPage !== 0)
            ? (\request()->input("start") / $perPage + 1)
            : 1;

        $searchValue = \request()->input('search.value');

        $query = Permission::query();

        $totalRecordsBeforeSearch = Permission::count();

        if (!empty($searchValue)) {
            $query->where('name', 'like', '%' . $searchValue . '%')
                ->orWhere('guard_name', 'like', '%' . $searchValue . '%');
        }

        $totalRecordsAfterSearch = $query->count();

        $permissions = $query->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        return response()->json([
            'draw' => \request()->input("draw"),
            "recordsTotal" => $totalRecordsBeforeSearch,
            'recordsFiltered' => $totalRecordsAfterSearch,
            'data' => $permissions->map(function ($permission) {
                return [
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'guard_name' => $permission->guard_name ,
                    'action' => '<div class="dropdown">
                                                <span class="glyphicon glyphicon-option-vertical" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" aria-hidden="true"></span>
                                                <ul class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenu1">
                                                    <li class="dropdown-header">Actions</li>
                                                    <li>
                                                        <a href="'. route("user.show",[ $permission->id]).'">
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
                                            </div>',
                ];
            }),
            'input' => [
                'draw' => \request()->input("draw"),
                'columns' => \request()->input("columns"),
                'order' => \request()->input("order"),
                'start' => \request()->input("start"),
                'length' => \request()->input("length"),
                'search' => \request()->input("search"),
                '_' => \request()->input("_"),
            ],
        ]);
    }

    public function usersDatatable()
    {

        $perPage = \request()->input("length");
        $page = ($perPage !== 0)
            ? (\request()->input("start") / $perPage + 1)
            : 1;

        $searchValue = request()->input('search.value');

        $query = User::query();

        $totalRecordsBeforeSearch = User::count();

        if (!empty($searchValue)) {
            $query->where('full_name', 'like', '%' . $searchValue . '%')
                ->orWhere('id', 'like', '%' . $searchValue . '%')
                ->orWhere('username', 'like', '%' . $searchValue . '%')
                ->orWhere('email', 'like', '%' . $searchValue . '%')
                ->orWhere('gender', 'like', '%' . $searchValue . '%')
                ->orWhere('is_app_user', 'like', '%' . $searchValue . '%')
                ->orWhere('is_active', 'like', '%' . $searchValue . '%');
        }

        $totalRecordsAfterSearch = $query->count();

        $users = $query->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        return response()->json([
            'draw' => \request()->input("draw"),
            "recordsTotal" => $totalRecordsBeforeSearch,
            'recordsFiltered' => $totalRecordsAfterSearch,
            'data' => $users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'full_name' => $user->full_name,
                    'name' => $user->name ,
                    'email' => $user->email,
                    'gender' => $user->gender,
                    'action' => '<div class="dropdown">
                                            <span class="glyphicon glyphicon-option-vertical" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" aria-hidden="true"></span>
                                                <ul class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenu1">
                                                    <li class="dropdown-header">Actions</li>
                                                    <li>
                                                        <a href="'. route("user.show",[ $user->id]).'">
                                                            <span class="glyphicon glyphicon-eye-open text-success" aria-hidden="true"></span> View
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="editUser" data-id="'.$user->id.'">
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
                                            </div>',
                ];
            }),
            'input' => [
                'draw' => \request()->input("draw"),
                'columns' => \request()->input("columns"),
                'order' => \request()->input("order"),
                'start' => \request()->input("start"),
                'length' => \request()->input("length"),
                'search' => \request()->input("search"),
                '_' => \request()->input("_"),
            ],
        ]);
    }
}
