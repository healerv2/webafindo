<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Mikrotik;
use App\Models\LoginLog;
use App\Services\MikrotikMonitorService;
use Carbon\Carbon;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;

class MikrotikController extends Controller
{
    protected $monitorService;

    public function __construct(MikrotikMonitorService $monitorService)
    {
        $this->monitorService = $monitorService;
    }

    public static function middleware(): array
    {
        return [

            new Middleware('permission:view mikrotik', ['only' => ['index']]),
            new Middleware('permission:show mikrotik', ['only' => ['show']]),
            new Middleware('permission:create mikrotik', ['only' => ['create', 'store']]),
            new Middleware('permission:update mikrotik', ['only' => ['update', 'edit']]),
            new Middleware('permission:delete mikrotik', ['only' => ['destroy']]),
        ];
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data =  Mikrotik::orderBy('id', 'desc')->get();
            $user = auth()->user();
            return datatables()
                ->of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row->is_active === 1) {
                        return "<span class='badge bg-success'>Aktif</span>";
                    } elseif ($row->is_active === 0) {
                        return "<span class='badge bg-danger'>Tidak Aktif</span>";
                    } else {
                        return "<span class='badge bg-secondary'>Tidak Diketahui</span>";
                    }
                })
                ->addColumn('aksi', function ($row) use ($user) {
                    $btn = '';

                    if ($user->can("update mikrotik")) {
                        $btn = '<button type="button" data-id="' . $row->id . '" class="edit-mikrotik btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>';
                    }
                    if ($user->can('delete mikrotik')) {
                        $btn = $btn . ' <button type="button" data-id="' . $row->id . '" class="delete-mikrotik btn btn-danger btn-sm"> <i class="far fa-trash-alt"></i></button>';
                    }
                    if ($user->can('view mikrotik')) {
                        $btn = $btn . ' <button type="button" data-id="' . $row->id . '" class="show-mikrotik btn btn-success btn-sm"><i class="fas fa-eye"></i></button>';
                    }
                    $btn = $btn . '</div>';
                    return $btn;
                })

                ->rawColumns(['aksi', 'status'])
                ->make(true);
        }

        return view('mikrotik.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'ip' => 'required|string|max:255',
            'port' => 'nullable|integer',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255'
        ]);

        // Set default port if not provided
        if (!isset($validated['port'])) {
            $validated['port'] = 8728;
        }

        $connection = $this->monitorService->connect(
            $validated['ip'],
            $validated['username'],
            $validated['password'],
            $validated['port']
        );

        if (!$connection) {
            return response()->json([
                'status' => 404,
                'message' => 'Mikrotik tidak ditemukan atau gagal connect cek credentials'
            ]);
            //return back()->withErrors(['connection' => 'Could not connect to the device with provided credentials'])->withInput();
        }

        $validated['is_active'] = true;
        $validated['last_check'] = now();

        try {

            $mikrotik = new Mikrotik();
            $mikrotik->name = $request->name;
            $mikrotik->ip = $request->ip;
            $mikrotik->port = $request->port;
            $mikrotik->username = $request->username;
            $mikrotik->password = $request->password;
            $mikrotik->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Mikrotik berhasil ditambahkan'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => '500',
                'message' => 'Maximum execution time of 30 seconds exceeded'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $mikrotik = Mikrotik::findOrFail($id);
        $resources = $this->monitorService->getSystemResources($mikrotik);
        return response()->json([
            'status' => 'success',
            'mikrotik' => $resources,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        try {
            $mikrotik = Mikrotik::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'mikrotik' => $mikrotik,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'message' => 'Mikrotik tidak ditemukan'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        try {
            $mikrotik = Mikrotik::findOrFail($id);
            $mikrotik->update([
                'name' => $request->name,
                'ip' => $request->ip,
                'port' => $request->port,
                'username' => $request->username,
                'password' => $request->password,
                'is_active' => $request->is_active,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Mikrotik berhasil diperbarui'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'message' => 'Mikrotik tidak ditemukan'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            $mikrotik = Mikrotik::findOrFail($id);
            $mikrotik->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Mikrotik berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'message' => 'Mikrotik tidak ditemukan'
            ]);
        }
    }
}
