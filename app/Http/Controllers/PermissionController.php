<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Permission::class);
        return Permission::all();
    }

    public function store(Request $request)
    {
        $this->authorize('create', Permission::class);

        $data = $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        $permission = Permission::create($data);
        return response()->json($permission, 201);
    }

    public function show(Permission $permission)
    {
        $this->authorize('view', $permission);
        return $permission;
    }

    public function update(Request $request, Permission $permission)
    {
        $this->authorize('update', $permission);

        $data = $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update($data);
        return response()->json($permission);
    }

    public function destroy(Permission $permission)
    {
        $this->authorize('delete', $permission);
        $permission->delete();

        return response()->noContent();
    }
}
