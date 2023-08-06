<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::factory()->create([
            'name' => 'Admin'
        ]);

        $editor = Role::factory()->create([
            'name' => 'Editor'
        ]);

        $viewer = Role::factory()->create([
            'name' => 'Viewer'
        ]);

        $permission = Permission::all();
        
        /* 1st way */
        // foreach($permissions as $permission){
        //     DB::table('role_permissions')->insert([
        //         'permission_id' => $permission->id,
        //         'role_id' => $admin->id
        //     ]);
        // }

         /**
          * $permission is from Role Model 
          * pluck will return id array
         */

        $admin->permissions()->attach($permission->pluck('id'));
        $editor->permissions()->attach($permission->pluck('id'));
        $editor->permissions()->detach(4);
        $viewer->permissions()->attach([1,3,5,7]);


    }
}
