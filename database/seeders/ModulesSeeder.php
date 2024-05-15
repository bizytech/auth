<?php

namespace Database\Seeders;

use BizyTech\Auth\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        try {
            $modules = config("custom_data.modules");
            foreach ($modules as $module){
               if (!Module::query()->where("name" ,'=',$module)->exists()){
                   Module::query()->updateOrCreate([
                       "name" => $module
                   ]);
               }
            }
        }catch (\Exception $exception){
            Log::error("An error occurred: ". $exception->getMessage());
        }
    }
}
