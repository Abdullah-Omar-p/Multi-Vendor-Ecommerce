<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = auth('sanctum')->user();
        if (!$this->user || !$this->user->hasRole('super-admin')) {
            abort(403, 'Unauthorized access - Super-admin role required');
        }
    }

    public function permissions()
    {
        $permissions = Permission::all();
        return Helper::responseData('Permissions found', true, $permissions, 200);
    }

    public function roles()
    {
        $roles = Role::all();
        return Helper::responseData('Roles found', true, $roles, 200);

    }

    public function createRole(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles',
        ]);

        $role = Role::create(['name' => $request->name]);

        return Helper::responseData('Role Created Successfully', true, $role, 200);
    }

    public function assignPermissionsToRole(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission' => 'required|exists:permissions,name',
        ]);

        $role = Role::findById($request->role_id);
        $role->syncPermissions($request->permissions);

        return Helper::responseData('Permissions Assigned To Role Successfully',true, null , 200);
    }

    public function assignRoleToUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->assignRole($request->role);

        return Helper::responseData('Role Assigned To User Successfully', true, null, 200);
    }

    public function removeRoleFromUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->removeRole($request->role);

        return Helper::responseData('Role removed from user successfully', true, null, 200);
    }

    public function revokePermissionsFromRole(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission' => 'required|exists:permissions,name',
        ]);

        $role = Role::findById($request->role_id);
        $role->revokePermissionTo($request->permissions);

        return Helper::responseData('Permissions revoked from role successfully', true, null, 200);
    }

    public function checkUserRolesPermissions($userId)
    {
        $user = User::findOrFail($userId);
        $roles = $user->getRoleNames();
        $permissions = $user->getAllPermissions();

        return Helper::responseData('Permissions and Roes Found', true, [$permissions,$roles], 200);

    }

    public function listUsersByRole($roleName)
    {
        $users = User::role($roleName)->get();
        return Helper::responseData('role users found successfully', true , [$roleName,$users], 200);
    }

}
