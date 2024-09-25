<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    //
    public function index()
    {
        $roles = Role::get();
        return view('admin.role.index', ['roles' => $roles]);
    }

    public function create()
    {
        return view('admin.role.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'  => ['required', 'string', 'unique:roles,name'],
        ]);

        //create a permission
        Role::create(['name' => $request->name]);

        return redirect('roles')->with('success', 'Role Created Successfully');
    }
    public function edit(Role $role)
    {
        return view('admin.role.edit', ['role' => $role]);
    }
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name'  => ['required', 'string', 'unique:roles,name,' . $role->id],
        ]);

        //update permission
        $role->update(['name' => $request->name]);

        return redirect('roles')->with('success', 'Role Updated Successfully');
    }
    public function destroy($roleId)
    {
        $role = Role::find($roleId);
        $role->delete();
        return redirect('roles')->with('error', 'Role Deleted Successfully');
    }
    public function addPermissionToRole($roleId)
    {

        $permissions = Permission::get();
        $role = Role::findOrFail($roleId);
        $rolePermission = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id', $role->id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('admin.role.add-role', ['role' => $role, 'permissions' => $permissions, 'rolePermissions' => $rolePermission]);
    }
    public function updatePermissionToRole(Request $request, $roleId)
    {
        $request->validate([
            'permission' => 'required'
        ]);

        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permission);


        return redirect()->back()->with('success', 'Permissions added to role');
    }
}
