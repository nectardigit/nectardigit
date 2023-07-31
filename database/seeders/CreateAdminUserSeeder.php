<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' =>  [
                'np' => 'Nectar Digit',
                'en' => 'Nectar Digit'
            ],
            'slug' => 'nectar-digit',
            'email' => 'nectardigit@gmail.com',
            'password' => Hash::make('admin123'),
        ]);

        $role = Role::create(['name' => 'Super Admin']);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);

        $adminuser = User::create([
            'name' => [
                'np' => 'News Portal Admin',
                "en" => 'News Portal Admin'
            ],
            'slug' => 'news-portal-admin',
            'email' => 'admin@newsportal.com',
            'password' => Hash::make('admin123'),
        ]);
        $roleadmin = Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Reporter']);
        $adminuser->assignRole([$roleadmin->id]);
    }
}
