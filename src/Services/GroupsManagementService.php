<?php

namespace BizyTech\Auth\Services;

use BizyTech\Auth\Models\Module;
use BizyTech\Auth\Models\User;

class GroupsManagementService {

    public function findAllGroups(): \Illuminate\Database\Eloquent\Collection
    {
        return Module::all();
    }

    public function findGroup($id) {
        return Module::find($id);
    }

    public function createGroup($data): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        return Module::query()->create([
            "name" => $data["name"]
        ]);
    }

    public function findGroupWithPermissions($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|null
    {
        return Module::query()
            ->where("id","=", $id)
            ->with("permissions")
            ->first();
    }

    public function groupsDatatable()
    {
        $perPage = \request()->input("length");
        $page = ($perPage !== 0)
            ? (\request()->input("start") / $perPage + 1)
            : 1;

        $searchValue = \request()->input('search.value');

        $query = Module::query();

        $totalRecordsBeforeSearch = Module::count();

        if (!empty($searchValue)) {
            $query->where('name', 'like', '%' . $searchValue . '%');
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
                    'action' => '<div class="dropdown">
                                                <span class="glyphicon glyphicon-option-vertical" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" aria-hidden="true"></span>
                                                <ul class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenu1">
                                                    <li class="dropdown-header">Actions</li>
                                                    <li>
                                                        <a href="'. route("group.show",[ $role->id]).'">
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

}
