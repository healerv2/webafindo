<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Mikrotik;
use App\Models\Area;
use App\Models\DataPaket;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public static function middleware(): array
    {
        return [

            new Middleware('permission:view customer', ['only' => ['index', 'show']]),
            new Middleware('permission:create customer', ['only' => ['create', 'store']]),
            new Middleware('permission:update customer', ['only' => ['update', 'edit']]),
            new Middleware('permission:delete customer', ['only' => ['destroy']]),
        ];
    }

    public function index(Request $request)
    {
        //
        $mikrotik = Mikrotik::all()->pluck('name', 'id');
        $area = Area::all()->pluck('nama_area', 'id');
        $paket = DataPaket::all()->pluck('nama_paket', 'id');

        if ($request->ajax()) {
            $data =  User::with('user_detail.user', 'user_detail.area', 'user_detail.mikrotik', 'user_detail.paket')->role('Customer')->orderBy('id', 'desc')->get();
            $user = auth()->user();
            return datatables()
                ->of($data)
                ->addIndexColumn()
                ->addColumn('Nama', function ($data) {
                    $identifier = $data->id;
                    $name = $data->name;
                    $nohp = $data->user_detail->nohp ?? 'Data belum lengkap';

                    return '
                        <a href="javascript:void(0)" class="text-info">
                            ( ' . $identifier . ' ) ' . $name . '
                        </a>
                        <br>
                        ' . $nohp . '
                    ';
                })
                ->addColumn('created_at', function ($data) {
                    return tanggal_indonesia($data->created_at, false);
                })
                ->addColumn('total', function ($data) {
                    return  'Rp. ' . format_uang($data->user_detail->total ?? 0);
                })
                ->addColumn('aksi', function ($row) use ($user) {
                    $btn = '';
                    if ($user->can("update customer")) {
                        $btn = '<button type="button" data-id="' . $row->id . '" class="edit-customer btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>';
                    }
                    if ($user->can('delete customer')) {
                        $btn = $btn . ' <button type="button" data-id="' . $row->id . '" class="delete-customer btn btn-danger btn-sm"> <i class="far fa-trash-alt"></i></button>';
                    }
                    if ($user->can('view customer')) {
                        $btn = $btn . ' <a class="btn btn-success btn-sm" href="' . route('customer.show', $row->id) . '"><i class="fas fa-eye"></i></a>';
                    }
                    $btn = $btn . '</div>';
                    return $btn;
                })

                ->rawColumns(['aksi', 'Nama'])
                ->make(true);
        }

        return view('customer.index', compact('mikrotik', 'area', 'paket'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Pilih kalimat
        $kalimatKe  = "1";
        $username   = implode(" ", array_slice(explode(" ", $request->name), 0, $kalimatKe)); // ambil kalimat

        try {
            $findUser = User::where('name', $request->name)->first();
            if ($findUser != null) {
                return response()->json([
                    'status' => 409,
                    'message' => 'Data customer sudah tersimpan'
                ]);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $username,
                'password' => Hash::make('12345678'),
                'foto'      => 'user.jpg',
            ]);

            $user->syncRoles('Customer');

            UserDetail::create([
                'user_id' => $user->id,
                'area_id' => $request->area_id,
                'paket_id' => $request->paket_id,
                'mikrotik_id' => $request->mikrotik_id,
                'ppoe' => $request->ppoe,
                'nohp' => $request->nohp,
                'by_tambahan_1' => $request->by_tambahan_1,
                'keterangan_tambahan_1' => $request->keterangan_tambahan_1,
                'by_tambahan_2' => $request->by_tambahan_2,
                'keterangan_tambahan_2' => $request->keterangan_tambahan_2,
                'diskon' => $request->diskon,
                //'total' => $request->total,
                'tanggal_tagihan' => $request->tanggal_tagihan,
                'alamat' => $request->alamat,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'perangkat' => $request->perangkat,
            ]);

            //$user->syncRoles('Customer');

            return response()->json([
                'status' => 'success',
                'message' => 'Customer berhasil dibuat'
            ]);
        } catch (\Throwable $e) {
            // return response()->json([
            //     'status' => 500,
            //     'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            // ], 500);
            return response()->json([
                'status' => 404,
                'message' => 'Customer tidak ditemukan'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        try {
            $customer = User::with('user_detail.user', 'user_detail.area', 'user_detail.mikrotik', 'user_detail.paket')->role('Customer')->findOrFail($id);

            //dd($customer);
            return view('customer.detail', compact('customer'));
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'message' => 'Data customer tidak ditemukan'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        try {
            $user = User::with('user_detail.user', 'user_detail.area', 'user_detail.mikrotik', 'user_detail.paket')->role('Customer')->findOrFail($id);
            return response()->json([
                'status' => 200,
                'customer' => $user,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'message' => 'Data customer tidak ditemukan'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::findOrFail($id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            UserDetail::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'area_id' => $request->area_id,
                    'paket_id' => $request->paket_id,
                    'mikrotik_id' => $request->mikrotik_id,
                    'ppoe' => $request->ppoe,
                    'nohp' => $request->nohp,
                    'by_tambahan_1' => $request->by_tambahan_1,
                    'keterangan_tambahan_1' => $request->keterangan_tambahan_1,
                    'by_tambahan_2' => $request->by_tambahan_2,
                    'keterangan_tambahan_2' => $request->keterangan_tambahan_2,
                    'diskon' => $request->diskon,
                    //'total' => $request->total,
                    'tanggal_tagihan' => $request->tanggal_tagihan,
                    'alamat' => $request->alamat,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'perangkat' => $request->perangkat,
                ]
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Customer berhasil diupdate'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Customer tidak ditemukan'
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
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Customer berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'message' => 'Customer tidak ditemukan'
            ]);
        }
    }

    public function getTagihan(string $id)
    {
        //
        try {
            $customer = User::with('user_detail.user', 'user_detail.area', 'user_detail.mikrotik', 'user_detail.paket')->role('Customer')->findOrFail($id);

            return response()->json([
                'status' => 200,
                'customer' => $customer,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'message' => 'Data customer tidak ditemukan'
            ]);
        }
    }
}
