<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Mikrotik;
use App\Models\Area;
use App\Models\DataPaket;
use App\Models\Tagihan;
use App\Models\PPN;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Invoice\InvoiceApi;
use Xendit\Configuration;
use Illuminate\Support\Facades\Response;


class CustomerController extends Controller
{
    private $xenditInvoiceApi;

    public function __construct()
    {
        Configuration::setXenditKey(config('xendit.secret_key'));
        $this->xenditInvoiceApi = new InvoiceApi();
    }

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

            $ppn = PPN::first();

            //dd($customer);
            return view('customer.detail', compact('customer', 'ppn'));
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

    public function payTunaiTagihan(Request $request)
    {
        try {
            $find = UserDetail::where('user_id', $request->id)->first();
            if ($find == null) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Customer tidak ditemukan'
                ]);
            }

            // Default tahun ke tahun sekarang jika tidak ada
            $tahun = $request->has('tahun') ? $request->tahun : date('Y');

            // Membuat tanggal dari bulan dan tahun (tanggal 1)
            $tanggal = Carbon::createFromDate($tahun, $request->bulan, 1)->format('Y-m-d');

            $existingData = Tagihan::periode($request->bulan, $request->tahun)->first();

            if ($existingData) {
                return response()->json([
                    'status' => 409,
                    'message' => 'Data untuk periode ini sudah ada'
                ]);
            }

            $transaksi =  UserDetail::where('user_id', $request->id)->first();

            //dd($transaksi);

            $transaksi->update([
                'by_tambahan_1' =>  $request->by_tambahan_1,
                'by_tambahan_2' =>  $request->by_tambahan_2,
                'diskon' =>  $request->diskon,
                'total' =>  $request->tarif,
                'updated_at' => Carbon::now(),
            ]);

            Tagihan::create([
                'user_id' => $request->id,
                'no_invoice' => Uuid::uuid4(),
                'tanggal' => $tanggal,
                'bulan' => $request->bulan,
                'paket' => $request->paket,
                'tarif' => $request->tarif,
                'admin' => auth()->id(),
                'status' => 'PAID',
                'note' => 'Pembayaran Tunai',

            ]);

            // dd($request->all());

            return response()->json([
                'status' => 200,
                'message' => 'pembayaran tunai berhasil!',
                //'data' =>  $transaksi

            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
            // return response()->json([
            //     'status' => 500,
            //     'message' => 'Terjadi kesalahan sistem. 500'
            // ]);
        }
    }

    public function payTagihanXendit(Request $request)
    {

        $find = UserDetail::where('user_id', $request->id)->first();
        if ($find == null) {
            return response()->json([
                'status' => 404,
                'message' => 'Customer tidak ditemukan'
            ]);
        }


        // Default tahun ke tahun sekarang jika tidak ada
        $tahun = $request->has('tahun') ? $request->tahun : date('Y');

        // Membuat tanggal dari bulan dan tahun (tanggal 1)
        $tanggal = Carbon::createFromDate($tahun, $request->bulan, 1)->format('Y-m-d');

        $existingData = Tagihan::periode($request->bulan, $request->tahun)->first();

        if ($existingData) {
            return response()->json([
                'status' => 409,
                'message' => 'Data untuk periode ini sudah ada'
            ]);
        }

        $transaksi =  UserDetail::where('user_id', $request->id)->first();

        $transaksi->update([
            'by_tambahan_1' =>  $request->by_tambahan_1,
            'by_tambahan_2' =>  $request->by_tambahan_2,
            'diskon' =>  $request->diskon,
            'total' =>  $request->tarif,
            'updated_at' => Carbon::now(),
        ]);

        $apiInstance = new InvoiceApi();
        $invoice =  new CreateInvoiceRequest([
            'external_id' => (string) Uuid::uuid4(),
            'amount' => $request->tarif,
            'invoice_duration' => 900,
            'customer' => [
                'given_names' => $request->name,
                'email' => $request->email,
                'mobile_number' => $request->nohp,
            ],
            'success_redirect_url' => route('customer.show', $request->id),
            'failure_redirect_url' => route('dashboard'),
        ]);

        try {
            $result = $apiInstance->createInvoice($invoice);
            Tagihan::create([
                'user_id' => $request->id,
                'no_invoice' => $invoice['external_id'],
                'tanggal' => $tanggal,
                'bulan' => $request->bulan,
                'paket' => $request->paket,
                'tarif' => $invoice['amount'],
                'invoice_url' => $result['invoice_url'],
                'admin' => auth()->id(),
                'status' => 'UNPAID',
                'note' => 'Pembayaran Dengan Xendit',

            ]);

            return redirect($result['invoice_url']);
            // } catch (\Throwable $e) {
            //     return response()->json([
            //         'status' => 500,
            //         'message' => 'Terjadi kesalahan sistem. 500'
            //     ]);
            // }
        } catch (\Xendit\XenditSdkException $e) {
            echo 'Exception when calling InvoiceApi->createInvoice: ', $e->getMessage(), PHP_EOL;
            echo 'Full Error: ', json_encode($e->getFullError()), PHP_EOL;
        }
    }

    public function handleCallback(Request $request)
    {
        // Verifikasi callback token
        $callbackToken = $request->header('X-CALLBACK-TOKEN');
        if ($callbackToken !== config('xendit.callback_token')) {
            return response()->json(['error' => 'Invalid callback token'], 403);
        }

        $payload = $request->all();

        // Proses callback berdasarkan status
        switch ($payload['status']) {
            case 'PAID':
                // Update status pembayaran di database
                Tagihan::where('no_invoice', $payload['external_id'])->update(['status' => 'PAID']);
                break;
            case 'EXPIRED':
                Tagihan::where('no_invoice', $payload['external_id'])->update(['status' => 'EXPIRED']);
                break;
            default:
                return Response::json([
                    'status' => 500,
                    'message' => 'Terjadi kesalahan sistem. 500'
                ]);
                //break;
        }

        return response()->json([
            'status' => 200,
            'message' => 'callback berhasil!',
        ]);
    }

    public function viewHistoryPembayaranAdmin(Request $request)
    {
        //
        if ($request->ajax()) {

            //$user_id = $id;

            //$user_id = $request->id;
            // $user = User::findOrFail($user_id);
            $data =  Tagihan::with('user', 'admin')->orderBy('id', 'desc')->get();
            $user = auth()->user();
            return datatables()
                ->of($data)
                ->addIndexColumn()
                ->addColumn('tagihan', function ($data) {
                    $tanggal_tagihan = Carbon::parse($data->tanggal)->format('F Y');
                    $tanggal_bayar = tanggal_indonesia($data->created_at, false) ?? 'Data belum lengkap';

                    return '
                    <h7 class="title py-3 m-0 text-success text-uppercase ">' . $tanggal_tagihan . '</h7>
                    <p>
                        ' . $tanggal_bayar . '
                    ';
                })
                ->addColumn('tarif', function ($data) {
                    return  'Rp. ' . format_uang($data->tarif ?? 0);
                })
                ->addColumn('aksi', function ($row) use ($user) {
                    $btn = '';
                    if ($user->can("update customer")) {
                        $btn = '<button type="button" data-id="' . $row->id . '" class="edit-customer btn btn-primary btn-sm"><i class="fas fa-eye"></i></button>';
                    }
                    $btn = $btn . '</div>';
                    return $btn;
                })

                ->rawColumns(['aksi', 'tagihan'])
                ->make(true);
        }
    }
}
