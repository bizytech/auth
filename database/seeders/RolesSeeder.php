<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        try {
            $roles = config("custom_data.roles");
            foreach ($roles as $role){
               if( !Role::query()->where("name" , "", $role)->exists()){
                   $thisRole = Role::query()->create([
                       "name" => $role,
                       "guard_name" => 'web'
                   ]);
               }
            }
        }catch (\Exception $exception){
            Log::error("An error occurred: ". $exception->getMessage());
        }
    }
}
