<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view permission', ['only' => ['index']]),
            new Middleware('permission:create permission', ['only' => ['create', 'store']]),
            new Middleware('permission:update permission', ['only' => ['update', 'edit']]),
            new Middleware('permission:delete permission', ['only' => ['destroy']]),
        ];
    }

    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data =  Permission::orderBy('id', 'desc')->get();
            return datatables()
                ->of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($data) {
                    return '
                 <div class="">
                    <a class="btn btn-primary btn-sm" href="' . route('permissions.edit', encrypt($data->id)) . '"> <i class="fa fa-edit"></i></a>
                    <button onclick="deleteData(`' . route('permissions.destroy', encrypt($data->id)) . '`)" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
                </div>
                ';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('permissions.add');
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
                    'unique:permissions,name'
                ]
            ]);

            Permission::create([
                'name' => $request->name
            ]);

            return redirect()->route('permissions.index')->with('message', 'Permission Created Successfully');
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
            $$ID = decrypt($id);
            $permission = Permission::findOrFail($ID);

            return view('permissions.edit', compact('permission'));
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
                    'unique:permissions,name,'
                ]
            ]);

            $ID = decrypt($id);
            $permission = Permission::where('id', $ID)->first();

            $permission->update([
                'name' => $request->name
            ]);

            return redirect()->route('permissions.index')->with('message', 'Permission Updated Successfully');
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
            $permission = Permission::findOrFail($ID);
            $permission->delete();
            return response()->json([
                'success' => true,
                'message' => 'permission berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. code 500'
            ]);
        }
    }
}
