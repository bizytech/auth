<?php

namespace Database\Seeders;

use BizyTech\Auth\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $aModule = config("custom_data.modules_and_permissions");
            foreach ($aModule as $key => $module){
                $mod = Module::query()->where("name" , "=", $key);
                if($mod->exists()){
                    foreach ($module as $permission){
                       Permission::query()->updateOrCreate(
                           ["name" => $permission],
                           [
                               "name" => $permission,
                               "guard_name" => "web",
                               "module_id" => $mod->first()["id"]
                           ]
                       );
                   }
                }
            }
        }catch (\Exception $exception){
            Log::error("An error occurred: ". $exception->getMessage());
        }
    }
}
