<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\Pembukuan;
use App\Models\Tagihan;
use Carbon\Carbon;
use App\Models\User;

class PembukuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public static function middleware(): array
    {
        return [

            new Middleware('permission:view pembukuan', ['only' => ['index']]),
            new Middleware('permission:show pembukuan', ['only' => ['show']]),
            new Middleware('permission:create pembukuan', ['only' => ['create', 'store']]),
            new Middleware('permission:update pembukuan', ['only' => ['update', 'edit']]),
            new Middleware('permission:delete pembukuan', ['only' => ['destroy']]),
        ];
    }

    public function index()
    {
        //
        $tagih = User::role('Penagihan')->get();
        //Pemasukan
        $total_transaksi_cash = Tagihan::where('tipe_tagihan', 'TUNAI')->sum('tarif');
        $total_transaksi_online = Tagihan::where('tipe_tagihan', 'ONLINE')->sum('tarif');
        $total_transaksi_lainnya1 = Pembukuan::where('tipe_pembukuan', 'setoran')->where('kategori_pembukuan', 'lain-lain')->sum('jumlah');
        $total_transaksi_lainnya2 = Pembukuan::where('tipe_pembukuan', 'pemasukan')->where('kategori_pembukuan', 'lain-lain')->sum('jumlah');
        $total_transaksi_lainnya = $total_transaksi_lainnya1 + $total_transaksi_lainnya2;
        $total_pemasukan = $total_transaksi_cash + $total_transaksi_online + $total_transaksi_lainnya;
        //Pengeluaran
        $total_pengeluaran_lisrtik_pdam_pulsa = Pembukuan::where('tipe_pembukuan', 'pengeluaran')->where('kategori_pembukuan', 'listrik-PDAM-pulsa')->sum('jumlah');
        $total_pengeluaran_gaji = Pembukuan::where('tipe_pembukuan', 'pengeluaran')->where('kategori_pembukuan', 'gaji')->sum('jumlah');
        $total_pengeluaran_pasang_baru = Pembukuan::where('tipe_pembukuan', 'pengeluaran')->where('kategori_pembukuan', 'pasang baru')->sum('jumlah');
        $total_pengeluaran_perbaikan_alat = Pembukuan::where('tipe_pembukuan', 'pengeluaran')->where('kategori_pembukuan', 'perbaikan alat')->sum('jumlah');
        $total_pengeluaran_bandwith = Pembukuan::where('tipe_pembukuan', 'pengeluaran')->where('kategori_pembukuan', 'bandwith')->sum('jumlah');
        $total_pengeluaran_penagihan = Pembukuan::where('tipe_pembukuan', 'pengeluaran')->where('kategori_pembukuan', 'penagihan')->sum('jumlah');
        $total_pengeluaran_marketing = Pembukuan::where('tipe_pembukuan', 'pengeluaran')->where('kategori_pembukuan', 'marketing')->sum('jumlah');
        $total_pengeluaran_lainnya = Pembukuan::where('tipe_pembukuan', 'pengeluaran')->where('kategori_pembukuan', 'lainnya')->sum('jumlah');


        $total_pengeluaran = $total_pengeluaran_lisrtik_pdam_pulsa + $total_pengeluaran_gaji + $total_pengeluaran_pasang_baru + $total_pengeluaran_perbaikan_alat + $total_pengeluaran_bandwith + $total_pengeluaran_penagihan + $total_pengeluaran_marketing + $total_pengeluaran_lainnya;

        $total_pendapatan = $total_pemasukan - $total_pengeluaran;

        return view('pembukuan.index', compact('tagih', 'total_pemasukan', 'total_pengeluaran', 'total_pendapatan', 'total_transaksi_cash', 'total_transaksi_online', 'total_transaksi_lainnya', 'total_pengeluaran_lisrtik_pdam_pulsa', 'total_pengeluaran_gaji', 'total_pengeluaran_pasang_baru', 'total_pengeluaran_perbaikan_alat', 'total_pengeluaran_bandwith', 'total_pengeluaran_penagihan', 'total_pengeluaran_marketing', 'total_pengeluaran_lainnya'));
    }


    public function getPemasukanLainnyaView()
    {
        //
        return view('pembukuan.pemasukan-lain');
    }

    public function getPemasukanLainnya(Request $request)
    {
        //
        if ($request->ajax()) {
            try {
                $data = Pembukuan::with('admin')
                    ->orWhere('tipe_pembukuan', 'pemasukan')
                    ->orWhere('tipe_pembukuan', 'setoran')
                    ->orWhere('kategori_pembukuan', 'lain-lain')
                    ->get();

                return datatables()
                    ->of($data)
                    ->addIndexColumn()
                    ->addColumn('tanggal', function ($data) {
                        return \Carbon\Carbon::parse($data->tanggal)->locale('id')->format('H:i:s d F Y');
                    })
                    ->addColumn('jumlah', function ($data) {
                        return 'Rp. ' . format_uang($data->jumlah ?? 0);
                    })
                    ->make(true);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }

    public function getPengeluaranGajiView()
    {
        //
        return view('pembukuan.detail-gaji');
    }

    public function getPengeluaranGaji(Request $request)
    {
        //
        if ($request->ajax()) {
            try {
                $data = Pembukuan::with('admin')
                    ->where('tipe_pembukuan', 'pengeluaran')
                    ->where('kategori_pembukuan', 'gaji')
                    ->get();

                return datatables()
                    ->of($data)
                    ->addIndexColumn()
                    ->addColumn('tanggal', function ($data) {
                        return \Carbon\Carbon::parse($data->tanggal)->locale('id')->format('H:i:s d F Y');
                    })
                    ->addColumn('jumlah', function ($data) {
                        return 'Rp. ' . format_uang($data->jumlah ?? 0);
                    })
                    ->make(true);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }

    public function getPengeluaranPerbaikanAlatView()
    {
        //
        return view('pembukuan.perbaikan-alat');
    }

    public function getPengeluaranPerbaikanAlat(Request $request)
    {
        //
        if ($request->ajax()) {
            try {
                $data = Pembukuan::with('admin')
                    ->where('tipe_pembukuan', 'pengeluaran')
                    ->where('kategori_pembukuan', 'perbaikan alat')
                    ->get();

                return datatables()
                    ->of($data)
                    ->addIndexColumn()
                    ->addColumn('tanggal', function ($data) {
                        return \Carbon\Carbon::parse($data->tanggal)->locale('id')->format('H:i:s d F Y');
                    })
                    ->addColumn('jumlah', function ($data) {
                        return 'Rp. ' . format_uang($data->jumlah ?? 0);
                    })
                    ->make(true);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }

    public function getPengeluaranPasangBaruView()
    {
        //
        return view('pembukuan.pasang-baru');
    }

    public function getPengeluaranPasangBaru(Request $request)
    {
        //
        if ($request->ajax()) {
            try {
                $data = Pembukuan::with('admin')
                    ->where('tipe_pembukuan', 'pengeluaran')
                    ->where('kategori_pembukuan', 'pasang baru')
                    ->get();

                return datatables()
                    ->of($data)
                    ->addIndexColumn()
                    ->addColumn('tanggal', function ($data) {
                        return \Carbon\Carbon::parse($data->tanggal)->locale('id')->format('H:i:s d F Y');
                    })
                    ->addColumn('jumlah', function ($data) {
                        return 'Rp. ' . format_uang($data->jumlah ?? 0);
                    })
                    ->make(true);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }

    public function getPengeluaranBandwithView()
    {
        //
        return view('pembukuan.bandwith');
    }

    public function getPengeluaranBandwith(Request $request)
    {
        //
        if ($request->ajax()) {
            try {
                $data = Pembukuan::with('admin')
                    ->where('tipe_pembukuan', 'pengeluaran')
                    ->where('kategori_pembukuan', 'bandwith')
                    ->get();

                return datatables()
                    ->of($data)
                    ->addIndexColumn()
                    ->addColumn('tanggal', function ($data) {
                        return \Carbon\Carbon::parse($data->tanggal)->locale('id')->format('H:i:s d F Y');
                    })
                    ->addColumn('jumlah', function ($data) {
                        return 'Rp. ' . format_uang($data->jumlah ?? 0);
                    })
                    ->make(true);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }

    public function getPengeluaranPenagihanView()
    {
        //
        return view('pembukuan.penagihan');
    }

    public function getPengeluaranPenagihan(Request $request)
    {
        //
        if ($request->ajax()) {
            try {
                $data = Pembukuan::with('admin')
                    ->where('tipe_pembukuan', 'pengeluaran')
                    ->where('kategori_pembukuan', 'penagihan')
                    ->get();

                return datatables()
                    ->of($data)
                    ->addIndexColumn()
                    ->addColumn('tanggal', function ($data) {
                        return \Carbon\Carbon::parse($data->tanggal)->locale('id')->format('H:i:s d F Y');
                    })
                    ->addColumn('jumlah', function ($data) {
                        return 'Rp. ' . format_uang($data->jumlah ?? 0);
                    })
                    ->make(true);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }

    public function getPengeluaranListrikPDAMPulsaView()
    {
        //
        return view('pembukuan.pdam');
    }

    public function getPengeluaranListrikPDAMPulsa(Request $request)
    {
        //
        if ($request->ajax()) {
            try {
                $data = Pembukuan::with('admin')
                    ->where('tipe_pembukuan', 'pengeluaran')
                    ->where('kategori_pembukuan', 'listrik-PDAM-pulsa')
                    ->get();

                return datatables()
                    ->of($data)
                    ->addIndexColumn()
                    ->addColumn('tanggal', function ($data) {
                        return \Carbon\Carbon::parse($data->tanggal)->locale('id')->format('H:i:s d F Y');
                    })
                    ->addColumn('jumlah', function ($data) {
                        return 'Rp. ' . format_uang($data->jumlah ?? 0);
                    })
                    ->make(true);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }

    public function getPengeluaranMarketingView()
    {
        //
        return view('pembukuan.marketing');
    }

    public function getPengeluaranMarketing(Request $request)
    {
        //
        if ($request->ajax()) {
            try {
                $data = Pembukuan::with('admin')
                    ->where('tipe_pembukuan', 'pengeluaran')
                    ->where('kategori_pembukuan', 'marketing')
                    ->get();

                return datatables()
                    ->of($data)
                    ->addIndexColumn()
                    ->addColumn('tanggal', function ($data) {
                        return \Carbon\Carbon::parse($data->tanggal)->locale('id')->format('H:i:s d F Y');
                    })
                    ->addColumn('jumlah', function ($data) {
                        return 'Rp. ' . format_uang($data->jumlah ?? 0);
                    })
                    ->make(true);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }

    public function getPengeluaranLainnyaView()
    {
        //
        return view('pembukuan.lainnya');
    }

    public function getPengeluaranLainnya(Request $request)
    {
        //
        if ($request->ajax()) {
            try {
                $data = Pembukuan::with('admin')
                    ->where('tipe_pembukuan', 'pengeluaran')
                    ->where('kategori_pembukuan', 'lainnya')
                    ->get();

                return datatables()
                    ->of($data)
                    ->addIndexColumn()
                    ->addColumn('tanggal', function ($data) {
                        return \Carbon\Carbon::parse($data->tanggal)->locale('id')->format('H:i:s d F Y');
                    })
                    ->addColumn('jumlah', function ($data) {
                        return 'Rp. ' . format_uang($data->jumlah ?? 0);
                    })
                    ->make(true);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
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

            $pembukuan = new Pembukuan();
            $pembukuan->keterangan = $request->keterangan;
            $pembukuan->jumlah = $request->jumlah;
            $pembukuan->tipe_pembukuan = $request->tipe_pembukuan;
            $pembukuan->admin = $request->admin;
            if ($request->tipe_pembukuan == 'pemasukan') {
                $pembukuan->kategori_pembukuan = 'lain-lain';
            } elseif ($request->tipe_pembukuan == 'pengeluaran') {
                $pembukuan->kategori_pembukuan = $request->kategori_pengeluaran;
            } elseif ($request->tipe_pembukuan == 'setoran') {
                $pembukuan->kategori_pembukuan = 'lain-lain';
            }

            $pembukuan->tanggal = Carbon::now();
            // $pembukuan->admin = auth()->id();

            $pembukuan->save();

            return response()->json([
                'status' => 200,
                'message' => 'Pembukuan berhasil ditambahkan'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => 404,
                'message' => 'Pembukuan tidak ditemukan'
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
