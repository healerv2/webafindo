<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view role', ['only' => ['index']]),
            new Middleware('permission:create role', ['only' => ['create', 'store', 'addPermissionToRole', 'givePermissionToRole']]),
            new Middleware('permission:update role', ['only' => ['update', 'edit']]),
            new Middleware('permission:delete role', ['only' => ['destroy']])
        ];
    }

    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data =  Role::orderBy('id', 'desc')->get();
            return datatables()
                ->of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($data) {
                    return '
                 <div class="">
                    <a class="btn btn-success btn-sm" href="' . route('give.permission.role', $data->id) . '"> <i class="fas fa-key"></i></a>
                    <a class="btn btn-primary btn-sm" href="' . route('roles.edit', encrypt($data->id)) . '"> <i class="fa fa-edit"></i></a>
                    <button onclick="deleteData(`' . route('roles.destroy', encrypt($data->id)) . '`)" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
                </div>
                ';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('role.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('role.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            $request->validate([
                'name' => [
                    'required',
                    'string',
                    'unique:roles,name'
                ]
            ]);

            Role::create([
                'name' => $request->name
            ]);

            return redirect()->route('roles.index')->with('message', 'Role Created Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem. code 500');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        try {
            $ID = decrypt($id);
            $role = Role::findOrFail($ID);

            return view('role.edit', compact('role'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem. code 500');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        try {
            $request->validate([
                'name' => [
                    'required',
                    'string',
                    'unique:roles,name,'
                ]
            ]);

            $ID = decrypt($id);
            $role = Role::where('id', $ID)->first();

            $role->update([
                'name' => $request->name
            ]);

            return redirect()->route('roles.index')->with('message', 'Role Updated Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem. code 500');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            $ID = decrypt($id);
            $role = Role::find($ID);
            $role->delete();
            return response()->json([
                'success' => true,
                'message' => 'role berhasil dihapus!'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. code 500'
            ]);
        }
    }

    public function addPermissionToRole($roleId)
    {
        //$ID = decrypt($roleId);
        $permissions = Permission::get();
        $role = Role::findOrFail($roleId);
        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id', $role->id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('role.add-permissions', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function givePermissionToRole(Request $request, $roleId)
    {
        $request->validate([
            'permission' => 'required'
        ]);

        // $ID = decrypt($roleId);

        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permission);
        //return redirect('roles')->with('message', ' Permissions added to role');
        return redirect()->back()->with('message', 'Permissions added to role');
    }
}
