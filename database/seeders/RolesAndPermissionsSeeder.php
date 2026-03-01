<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        // manage courses, manage students, manage teachers, manage enrollments, view reports
        $permissions = [
            'manage courses',
            'manage students',
            'manage teachers',
            'manage enrollments',
            'view reports'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // create roles and assign existing permissions
        $roleAdmin = Role::create(['name' => 'admin']);
        // Admin gets all permissions
        $roleAdmin->givePermissionTo(Permission::all());

        $roleManager = Role::create(['name' => 'manager']);
        $roleManager->givePermissionTo([
            'manage courses',
            'manage students',
            'manage teachers',
            'manage enrollments',
            'view reports'
        ]);

        $roleTeacher = Role::create(['name' => 'teacher']);
        // Teacher might have specific permissions later, currently via Policies usually
        
        $roleStudent = Role::create(['name' => 'student']);
        
        $roleApiClient = Role::create(['name' => 'api_client']);

        // Create a default Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole($roleAdmin);

        // Create a default Manager User
        $manager = User::firstOrCreate(
            ['email' => 'manager@manager.com'],
            [
                'name' => 'Manager User',
                'password' => Hash::make('password'),
            ]
        );
        $manager->assignRole($roleManager);

        $this->command->info('Roles and Permissions seeded successfully.');
    }
}
