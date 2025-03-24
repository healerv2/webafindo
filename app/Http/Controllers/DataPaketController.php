<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\DataPaket;

class DataPaketController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public static function middleware(): array
    {
        return [

            new Middleware('permission:view data paket', ['only' => ['index']]),
            new Middleware('permission:create data paket', ['only' => ['create', 'store']]),
            new Middleware('permission:update data paket', ['only' => ['update', 'edit']]),
            new Middleware('permission:delete data paket', ['only' => ['destroy']]),
        ];
    }


    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data =  DataPaket::orderBy('id', 'desc')->get();
            $user = auth()->user();
            return datatables()
                ->of($data)
                ->addIndexColumn()
                ->addColumn('harga_paket', function ($data) {
                    return format_uang($data->harga_paket);
                })
                ->addColumn('aksi', function ($row) use ($user) {
                    $btn = '';
                    if ($user->can("update data paket")) {
                        $btn = '<button type="button" data-id="' . $row->id . '" class="edit btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>';
                    }
                    if ($user->can('delete data paket')) {
                        $btn = $btn . ' <button type="button" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm"> <i class="far fa-trash-alt"></i></button>';
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
            $findLayanan = DataPaket::where('nama_paket', $request->nama_paket)->first();
            if ($findLayanan != null) {
                return response()->json([
                    'success' => 400,
                    'message' => 'Data Paket sudah tersimpan!'
                ]);
            }

            $layanan = new DataPaket();
            $layanan->nama_paket = $request->nama_paket;
            $layanan->harga_paket = $request->harga_paket;

            $layanan->save();

            return response()->json([
                'status' => 200,
                'message' => 'Data Paket berhasil ditambahkan'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => 400,
                'message' => 'Terjadi kesalahan sistem. code 500'
            ]);
            //return redirect()->back()->with('error', 'Terjadi kesalahan sistem. code 500');
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
            $layanan = DataPaket::findOrFail($id);
            return response()->json([
                'status' => 200,
                'layanan' => $layanan,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'message' => 'Data Paket tidak ditemukan'
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
            $layanan = DataPaket::findOrFail($id);
            $layanan->update([
                'nama_paket' => $request->nama_paket,
                'harga_paket' => $request->harga_paket,
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Data Paket berhasil diperbarui'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'message' => 'Data Paket tidak ditemukan'
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
            //$ID = decrypt($id);
            $layanan = DataPaket::findOrFail($id);
            $layanan->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Data Paket berhasil dihapus!'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'message' => 'Data Paket tidak ditemukan'
            ]);
        }
    }
}
