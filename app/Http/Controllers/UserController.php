<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\User;
use App\Models\UserDetail;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public static function middleware(): array
    {
        return [

            new Middleware('permission:view user', ['only' => ['index']]),
            new Middleware('permission:create user', ['only' => ['create', 'store']]),
            new Middleware('permission:update user', ['only' => ['update', 'edit']]),
            new Middleware('permission:delete user', ['only' => ['destroy']]),
        ];
    }

    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data =  User::orderBy('id', 'desc')->get();
            $user = auth()->user();
            return datatables()
                ->of($data)
                ->addColumn('role', function ($data) {
                    return '<span class="badge bg-success">' . ucfirst($data->roles->first()->name) . '</span>';
                })
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) use ($user) {
                    $btn = '';
                    if ($user->can("update user")) {
                        $btn = '<div class="">
                        <a class="btn btn-primary btn-sm" href="' . route('users.edit', encrypt($row->id)) . '">
                        <i class="fa fa-edit"></i></a>
                        ';
                    }
                    if ($user->can('delete user')) {
                        $btn = $btn . ' <button onclick="deleteData(`' . route('users.destroy', encrypt($row->id)) . '`)" class="btn btn-danger btn-sm"> 
                        <i class="far fa-trash-alt"></i></button>
                        ';
                    }
                    $btn = $btn . '</div>';
                    return $btn;
                })

                ->rawColumns(['aksi', 'role'])
                ->make(true);
        }

        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $roles = Role::pluck('name', 'name')->all();
        return view('user.add', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|string|min:8|max:20',
                'roles' => 'required'
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('P@5SW0rD'),
                'foto'      => 'user.jpg',
            ]);

            UserDetail::create([
                'user_id' => $user->id,
            ]);

            $user->syncRoles($request->roles);

            return redirect()->route('users.index')->with('message', 'User created successfully!');
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
            $user = User::findOrFail($ID);
            $roles = Role::pluck('name', 'name')->all();
            $userRoles = $user->roles->pluck('name', 'name')->all();

            return view('user.edit', compact('user', 'roles', 'userRoles'));
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
                'name' => 'required|string|max:255',
                'password' => 'nullable|string|min:8|max:20',
                'roles' => 'required'
            ]);

            $data = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if (!empty($request->password)) {
                $data += [
                    'password' => Hash::make($request->password),
                ];
            }

            $ID = decrypt($id);
            $user = User::where('id', $ID)->first();

            $user->update($data);
            $user->syncRoles($request->roles);

            return redirect()->route('users.index')->with('message', 'User updated successfully!');
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
            $user = User::findOrFail($ID);
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => 'User berhasil dihapus!'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. code 500'
            ]);
        }
    }
}
