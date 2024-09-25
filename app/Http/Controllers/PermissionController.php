<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    //
    public function index()
    {
        $permissions = Permission::get();
        return view('admin.permission.index', ['permissions' => $permissions]);
    }

    public function create()
    {
        return view('admin.permission.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'  => ['required', 'string', 'unique:permissions,name'],
        ]);

        //create a permission
        Permission::create(['name' => $request->name]);

        return redirect('permissions')->with('success', 'Permission Created Successfully');
    }
    public function edit(Permission $permission)
    {
        return view('admin.permission.edit', ['permission' => $permission]);
    }
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name'  => ['required', 'string', 'unique:permissions,name,' . $permission->id],
        ]);

        //update permission
        $permission->update(['name' => $request->name]);

        return redirect('permissions')->with('success', 'Permission Updated Successfully');
    }
    public function destroy($permissionId)
    {
        $permission = Permission::find($permissionId);
        $permission->delete();
        return redirect('permissions')->with('error', 'Permission Deleted Successfully');
    }
}
