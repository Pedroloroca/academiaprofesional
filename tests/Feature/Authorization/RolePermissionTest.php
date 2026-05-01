<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('seeder creates roles and permissions', function () {
    // Run the seeder (DatabaseSeeder calls RolesAndPermissionsSeeder)
    $this->seed();

    // Check Roles
    expect(Role::count())->toBe(5);
    expect(Role::where('name', 'admin')->exists())->toBeTrue();
    expect(Role::where('name', 'manager')->exists())->toBeTrue();
    expect(Role::where('name', 'teacher')->exists())->toBeTrue();
    expect(Role::where('name', 'student')->exists())->toBeTrue();
    expect(Role::where('name', 'api_client')->exists())->toBeTrue();

    // Check Permissions
    expect(Permission::where('name', 'manage courses')->exists())->toBeTrue();
});

test('admin user has all permissions', function () {
    $this->seed();

    $admin = User::where('email', 'admin@admin.com')->first();
    
    expect($admin)->not->toBeNull();
    expect($admin->hasRole('admin'))->toBeTrue();
    expect($admin->hasPermissionTo('manage courses'))->toBeTrue();
});
