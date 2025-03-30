<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\Area;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public static function middleware(): array
    {
        return [

            new Middleware('permission:view data area', ['only' => ['index']]),
            new Middleware('permission:create data area', ['only' => ['create', 'store']]),
            new Middleware('permission:update data area', ['only' => ['update', 'edit']]),
            new Middleware('permission:delete data area', ['only' => ['destroy']]),
        ];
    }

    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data =  Area::orderBy('id', 'desc')->get();
            $user = auth()->user();
            return datatables()
                ->of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) use ($user) {
                    $btn = '';
                    if ($user->can("update data area")) {
                        $btn = '<button type="button" data-id="' . $row->id . '" class="edit-area btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>';
                    }
                    if ($user->can('delete data area')) {
                        $btn = $btn . ' <button type="button" data-id="' . $row->id . '" class="delete-area btn btn-danger btn-sm"> <i class="far fa-trash-alt"></i></button>';
                    }
                    $btn = $btn . '</div>';
                    return $btn;
                })

                ->rawColumns(['aksi'])
                ->make(true);
        }
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
        try {
            $findArea = Area::where('nama_area', $request->nama_area)->first();
            if ($findArea != null) {
                return response()->json([
                    'success' => 409,
                    'message' => 'Data Paket sudah tersimpan!'
                ]);
            }

            $area = new Area();
            $area->nama_area = $request->nama_area;

            $area->save();

            return response()->json([
                'status' => 200,
                'message' => 'Data Area berhasil ditambahkan'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => 400,
                'message' => 'Data Paket tidak ditemukan'
            ]);
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
            $area = Area::findOrFail($id);
            return response()->json([
                'status' => 200,
                'area' => $area,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'message' => 'Data Area tidak ditemukan'
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
            $area = Area::findOrFail($id);
            $area->update([
                'nama_area' => $request->nama_area,
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Data Area berhasil diperbarui'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'message' => 'Data Area tidak ditemukan'
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
            $area = Area::findOrFail($id);
            $area->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Data Area berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'message' => 'Data Area tidak ditemukan'
            ]);
        }
    }
}
