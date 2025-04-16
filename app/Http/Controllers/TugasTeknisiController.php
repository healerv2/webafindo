<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\TugasTeknisi;
use App\Models\User;
use Carbon\Carbon;
use App\Services\KodeTugasGenerator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TugasTeknisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $KodeTugasGenerator;

    public function __construct(KodeTugasGenerator $KodeTugasGenerator)
    {
        $this->KodeTugasGenerator = $KodeTugasGenerator;
    }
    public static function middleware(): array
    {
        return [

            new Middleware('permission:view tugas teknisi', ['only' => ['index', 'show']]),
            new Middleware('permission:create tugas teknisi', ['only' => ['create', 'store']]),
            new Middleware('permission:update tugas teknisi', ['only' => ['update', 'edit']]),
            new Middleware('permission:delete tugas teknisi', ['only' => ['destroy']]),
        ];
    }

    public function index(Request $request)
    {
        //
        $technicians = User::role('Teknisi')->get();
        $customers = User::role('Customer')->get();

        if ($request->ajax()) {
            $data =  TugasTeknisi::with('user', 'teknisi')->orderBy('id', 'desc')->get();
            $user = auth()->user();
            return datatables()
                ->of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) use ($user) {
                    $btn = '';
                    if ($user->can("update tugas teknisi")) {
                        $btn = '<button type="button" data-id="' . $row->id . '" class="edit-tugas-teknisi btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>';
                    }
                    if ($user->can('delete tugas teknisi')) {
                        $btn = $btn . ' <button type="button" data-id="' . $row->id . '" class="delete-tugas-teknisi btn btn-danger btn-sm"> <i class="far fa-trash-alt"></i></button>';
                    }
                    if ($user->can('view tugas teknisi')) {
                        $btn = $btn . ' <button type="button" data-id="' . $row->id . '" class="show-tugas-teknisi btn btn-success btn-sm"><i class="fas fa-eye"></i></button>';
                    }
                    $btn = $btn . '</div>';
                    return $btn;
                })

                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('tugas-teknisi.index', compact('technicians', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function getAllTeknisi()
    {
        $technicians = User::role('Teknisi')->get();
        return response()->json($technicians);
    }

    public function getTeknisiById($id)
    {
        $teknisi = User::findOrFail($id);
        return response()->json($teknisi);
    }

    public function getAllCustomers()
    {
        $customers = User::role('Customer')->get();
        return response()->json($customers);
    }

    public function getCustomerById($id)
    {
        $customer = User::findOrFail($id);
        return response()->json($customer);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {

            $tugas = new TugasTeknisi();
            $tugas->tugas_id = $this->KodeTugasGenerator->generate();;
            $tugas->tugas = $request->tugas;
            $tugas->user_id = $request->user_id;
            $tugas->teknisi = $request->teknisi;
            $tugas->pending = Carbon::now();
            $tugas->save();

            return response()->json([
                'status' => 200,
                'message' => 'Tugas Teknisi berhasil ditambahkan'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => 404,
                'message' => 'Tugas Teknisi tidak ditemukan'
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
            $tugas = TugasTeknisi::with('user', 'teknisi')->findOrFail($id);
            return response()->json([
                'status' => 200,
                'tugas' => $tugas,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'message' => 'Tugas Teknisi tidak ditemukan'
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
            $tugas = TugasTeknisi::with('user', 'teknisi')->findOrFail($id);
            return response()->json([
                'status' => 200,
                'tugas' => $tugas,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'message' => 'Tugas Teknisi tidak ditemukan'
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

            $tugas = TugasTeknisi::findOrFail($id);

            if (!$tugas) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Tugas Teknisi tidak ditemukan'
                ]);
            }
            // Update data
            $tugas->tugas = $request->tugas;
            $tugas->user_id = $request->user_id;
            $tugas->teknisi = $request->teknisi;
            $tugas->kerusakan = $request->kerusakan;
            $tugas->status = $request->status;

            if ($request->status == "PROSES") {

                $tugas->update([
                    'proses' => Carbon::now(),
                ]);
            }

            if ($request->status == "DONE") {

                $tugas->update([
                    'done' => Carbon::now(),
                ]);
            }

            // Proses foto jika ada
            if ($request->has('foto_data') && $request->foto_data) {
                // Hapus foto lama jika ada
                if ($tugas->foto && Storage::disk('public')->exists($tugas->foto)) {
                    Storage::disk('public')->delete($tugas->foto);
                }

                // Decode foto base64
                $image = $request->foto_data;
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);

                // Simpan foto baru
                $imageName = 'tugas_' . time() . '_' . Str::random(10) . '.png';
                Storage::disk('public')->put('tugas/' . $imageName, base64_decode($image));

                $tugas->foto = 'tugas/' . $imageName;
            }

            $tugas->save();

            return response()->json([
                'status' => 200,
                'message' => 'Tugas Teknisi berhasil diperbarui'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => 404,
                'message' => 'Tugas Teknisi tidak ditemukan'
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
            $tugas = TugasTeknisi::findOrFail($id);
            $tugas->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Tugas Teknisi berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'message' => 'Tugas Teknisi tidak ditemukan'
            ]);
        }
    }
}
