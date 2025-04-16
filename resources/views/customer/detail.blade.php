@extends('layouts.master')

@section('title')
    Detail
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Detail Customer</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="float-end">
                        <button type="button" data-id="{{ $customer->id }}"
                            class="get-tagihan-customer btn btn-success waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#getTagihanModal">Bayar Tagihan</button>
                    </div>
                    <!-- sample modal content -->
                    <div id="getTagihanModal" class="modal fade" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title align-self-center" id="getTagihanModalLabel">
                                        Bayar Tagihan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form id="payTagihananCustomerForm">
                                    <div class="modal-body">
                                        <table class="table table-striped mb-0">
                                            <thead>
                                                <tr>
                                                    <th style="width: 30%;"></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Nama Pelanggan</td>
                                                    <td>{{ $customer->name }} </td>
                                                </tr>
                                                <tr>
                                                    <td>Paket</td>
                                                    <td>{{ $customer->user_detail->paket->nama_paket }} - Rp.
                                                        {{ format_uang($customer->user_detail->paket->harga_paket) }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <input type="hidden" id="edit_customer_id">
                                        <input type="hidden" name="layanan" id="edit_customer_harga_paket">
                                        <input type="hidden" name="paket"
                                            value="{{ $customer->user_detail->paket->nama_paket }}">
                                        <input id="tahun" type="hidden" name="tahun"
                                            value="{{ old('tahun', date('Y')) }}">
                                        <div class="mb-3">
                                            <label for="bulan" class="form-label">Bulan</label>
                                            <select name="bulan" id="bulan" class="form-control" required>
                                                <option value="">Pilih Bulan</option>
                                                <option value="1" {{ old('bulan') == '1' ? 'selected' : '' }}>Januari
                                                </option>
                                                <option value="2" {{ old('bulan') == '2' ? 'selected' : '' }}>Februari
                                                </option>
                                                <option value="3" {{ old('bulan') == '3' ? 'selected' : '' }}>Maret
                                                </option>
                                                <option value="4" {{ old('bulan') == '4' ? 'selected' : '' }}>April
                                                </option>
                                                <option value="5" {{ old('bulan') == '5' ? 'selected' : '' }}>Mei
                                                </option>
                                                <option value="6" {{ old('bulan') == '6' ? 'selected' : '' }}>Juni
                                                </option>
                                                <option value="7" {{ old('bulan') == '7' ? 'selected' : '' }}>Juli
                                                </option>
                                                <option value="8" {{ old('bulan') == '8' ? 'selected' : '' }}>Agustus
                                                </option>
                                                <option value="9" {{ old('bulan') == '9' ? 'selected' : '' }}>
                                                    September</option>
                                                <option value="10" {{ old('bulan') == '10' ? 'selected' : '' }}>Oktober
                                                </option>
                                                <option value="11" {{ old('bulan') == '11' ? 'selected' : '' }}>
                                                    November</option>
                                                <option value="12" {{ old('bulan') == '12' ? 'selected' : '' }}>
                                                    Desember</option>
                                            </select>
                                            <span class="error name_error"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="diskon" class="form-label">Diskon</label>
                                            <input type="number" class="form-control" id="edit_customer_diskon"
                                                name="diskon">
                                            <span class="error name_error"></span>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="tanggal_tagihan" class="form-label">Biaya Tambahan 1</label>
                                            <div class="col-lg-6  mo-b-15">
                                                <input class="form-control" type="text"
                                                    id="edit_customer_keterangan_tambahan_1" name="keterangan_tambahan_1"
                                                    placeholder="Rincian Biaya Tambahan 1">
                                            </div>
                                            <div class="col-lg-6">
                                                <input class="form-control" type="number" id="edit_customer_by_tambahan_1"
                                                    name="by_tambahan_1" placeholder="Biaya Tambahan 1">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="tanggal_tagihan" class="form-label">Biaya Tambahan 2</label>
                                            <div class="col-lg-6  mo-b-15">
                                                <input class="form-control" type="text"
                                                    id="edit_customer_keterangan_tambahan_2" name="keterangan_tambahan_2"
                                                    placeholder="Rincian Biaya Tambahan 2">
                                            </div>
                                            <div class="col-lg-6">
                                                <input class="form-control" type="number" id="edit_customer_by_tambahan_2"
                                                    name="by_tambahan_2" placeholder="Biaya Tambahan 2">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tarif" class="form-label">Total Pembayaran</label>
                                            <input type="number" class="form-control" id="tarif" name="tarif"
                                                readonly>
                                            <span class="error name_error"></span>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light waves-effect"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Bayar
                                            Tunai</button>
                                        <a class="btn btn-success waves-effect waves-light" href="#"
                                            onclick="$('#pay-xendit').submit()">Bayar
                                            Online</a>
                                    </div>
                                </form>
                                <form action="{{ route('customer.pay_xendit_tagihan') }}" method="post" id="pay-xendit"
                                    style="display: none;">
                                    @csrf
                                    <input type="hidden" value="{{ $customer->user_detail->user->id }}" name="id">
                                    <input type="hidden" name="paket"
                                        value="{{ $customer->user_detail->paket->nama_paket }}">
                                    <input type="hidden" name="name" value="{{ $customer->name }}">
                                    <input type="hidden" name="email" value="{{ $customer->email }}">
                                    <input type="hidden" name="nohp" value="{{ $customer->user_detail->nohp }}">
                                    <input type="hidden" id="edit_customer_harga_paket" name="harga_paket"
                                        value="{{ old('harga_paket', $customer->user_detail->paket->harga_paket ?? 0) }}">
                                    <input type="hidden" id="edit_customer_by_tambahan_1" name="by_tambahan_1"
                                        value="{{ old('by_tambahan_1', $customer->user_detail->by_tambahan_1 ?? 0) }}">
                                    <input type="hidden" id="edit_customer_by_tambahan_2" name="by_tambahan_2"
                                        value="{{ old('by_tambahan_2', $customer->user_detail->by_tambahan_2 ?? 0) }}">
                                    <input type="hidden" id="edit_customer_diskon" name="diskon"
                                        value="{{ old('diskon', $customer->user_detail->diskon ?? 0) }}">
                                    <input type="hidden" id="tarif" name="tarif"
                                        value="{{ old('tarif', $customer->user_detail->total ?? 0) }}">
                                </form>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                    <div class="d-flex align-items-center">
                        <a href="#">
                            <img src="{{ asset('img/' . auth()->user()->foto ?? '') }}" alt=""
                                class="avatar-sm  rounded-circle me-2" data-bs-toggle="tooltip" title=""
                                data-original-title="school project">
                        </a>
                        <div class="flex-1">
                            <h4 class="mb-0">{{ $customer->name }}</h4>
                            <h4 class="mb-0">{{ $customer->user_detail->nohp }}</h4>
                            <h6 class="mb-0">Alamat : {{ $customer->user_detail->alamat }}</h6>
                            <h6 class="mb-0">Mikrotik : {{ $customer->user_detail->mikrotik->name }} - Modem :
                                {{ $customer->user_detail->perangkat }}</h6>
                        </div>
                    </div>
                    <table class="table table-striped mb-0" id="tabel_ppn">
                        <thead>
                            <tr>
                                <th style="width: 30%;"></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tanggal Register</td>
                                <td>{{ tanggal_indonesia($customer->created_at, false) }} </td>
                            </tr>
                            <tr>
                                <td>Tanggal Tagihan</td>
                                <td>{{ \Carbon\Carbon::parse($customer->user_detail->tanggal_tagihan)->translatedFormat('d F') }}
                                </td>
                            </tr>
                            <tr>
                                <td>Paket</td>
                                <td>{{ $customer->user_detail->paket->nama_paket }}
                                    <br />
                                    <br />
                                    Rp. {{ format_uang($customer->user_detail->paket->harga_paket) }}
                                </td>
                            </tr>
                            <tr>
                                <td>PPN</td>
                                <td>{{ $ppn->ppn }} %
                                    <br />
                                    <br id="targetBr" />
                                </td>
                            </tr>
                            <tr>
                                <td>Area</td>
                                <td>{{ $customer->user_detail->area->nama_area }}</td>
                            </tr>
                            <tr>
                                <td>Biaya Tambahan</td>
                                <td>{{ $customer->user_detail->keterangan_tambahan_1 }}
                                    <br />
                                    <br />
                                    Rp. {{ format_uang($customer->user_detail->by_tambahan_1) }}
                                    <br />
                                    <br />
                                    {{ $customer->user_detail->keterangan_tambahan_2 }}
                                    <br />
                                    <br />
                                    Rp. {{ format_uang($customer->user_detail->by_tambahan_2) }}
                                </td>
                            </tr>
                            <tr>
                                <td>Diskon</td>
                                <td> Rp. {{ format_uang($customer->user_detail->diskon) }}</td>
                            </tr>
                            <tr>
                                <td>Catatan</td>
                                <td> Tidak ada Catatan</td>
                            </tr>
                            <tr>
                                <td>ODP</td>
                                <td> - Nomor ODP : undefined
                                    <br />
                                    - Nomor Kabel : undefined
                                    <br />
                                    - Nomor Port : undefined
                                    <br />
                                    - Teknisi Pemasang : undefined
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br />
                    <div>
                        <a class=" btn btn-danger waves-effect ms-1" href="{{ route('customer.index') }}">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!--end row-->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <h5 class="card-title">History Pembayaran</h5>
                    <p class="card-title-desc">
                    </p>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table1">
                            <thead>
                                <th>No</th>
                                <th>Tagihan Bulan</th>
                                <th>Paket</th>
                                <th>Tarif</th>
                                <th>Admin</th>
                                <th>Isolir</th>
                                <th width="15%"><i class="fa fa-cog"></i></th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
@push('scripts')
    <script>
        function resetModalState() {
            // Hapus modal dan backdrop
            $('.modal').modal('hide');

            // Tunggu proses modal hide selesai
            setTimeout(function() {
                // Hapus class modal-open dan backdrop
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();

                // Kembalikan overflow style ke auto/visible
                $('body').css('overflow', 'auto');
                $('body').css('padding-right', '');

                // Untuk Bootstrap 5, pastikan tidak ada style inline yang tersisa
                document.body.style.removeProperty('overflow');
                document.body.style.removeProperty('padding-right');
            }, 200);
        }
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // Load DataTable
            var table = $('#table1').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: "{{ route('customer.get_pembayaran_admin') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'tagihan'
                    },
                    {
                        data: 'paket'
                    },
                    {
                        data: 'tarif'
                    },
                    {
                        data: 'admin.name'
                    },
                    {
                        data: 'isolir'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false
                    },
                ],
            });

            // Clear error messages when modal is closed
            $('.modal').on('hidden.bs.modal', function() {
                $('.error').text('');
                $(this).find('form')[0].reset();
            });

            // Edit Customer - Show Modal
            $(document).on('click', '.get-tagihan-customer', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: "/dashboard/get-tagihan/customer/" + id,
                    type: "GET",
                    success: function(response) {
                        if (response.status == 404) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message,
                                showConfirmButton: true,
                                timer: 1500
                            });
                        } else {
                            $('#edit_customer_id').val(response.customer.id);
                            $('#edit_customer_name').val(response.customer.name);
                            $('#edit_customer_email').val(response.customer.email);
                            $('#edit_customer_ppoe').val(response.customer.user_detail.ppoe);
                            $('#edit_customer_mikrotik').val(response.customer.user_detail
                                .mikrotik_id);
                            $('#edit_customer_area').val(response.customer.user_detail
                                .area_id);
                            $('#edit_customer_paket').val(response.customer.user_detail
                                .paket_id);
                            $('#edit_customer_harga_paket').val(response.customer.user_detail
                                .harga_paket);
                            $('#edit_customer_nohp').val(response.customer.user_detail.nohp);
                            $('#edit_customer_tanggal_tagihan').val(response.customer
                                .user_detail.tanggal_tagihan);
                            $('#edit_customer_keterangan_tambahan_1').val(response.customer
                                .user_detail.keterangan_tambahan_1);
                            $('#edit_customer_by_tambahan_1').val(response.customer
                                .user_detail.by_tambahan_1);
                            $('#edit_customer_keterangan_tambahan_2').val(response.customer
                                .user_detail.keterangan_tambahan_2);
                            $('#edit_customer_by_tambahan_2').val(response.customer
                                .user_detail.by_tambahan_2);
                            $('#edit_customer_diskon').val(response.customer.user_detail
                                .diskon);
                            $('#getTagihanModal').modal('show');
                        }
                    }
                });
            });

            // Update Data Customer
            $('#payTagihananCustomerForm').on('submit', function(e) {
                e.preventDefault();
                var id = $('#edit_customer_id').val();

                $.ajax({
                    url: "/dashboard/pay-tunai-tagihan/customer/" + id,
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status == 404) {
                            $.each(response.errors, function(key, err_value) {
                                $('.edit_' + key + '_error').text(err_value[0]);
                            });
                        } else if (response.status == 404) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message
                            });
                        } else {
                            resetModalState();
                            table.ajax.reload();

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                showConfirmButton: true,
                                timer: 1500
                            });
                        }
                    }
                });
            });

            //Perhitungan
            // Inisialisasi nilai awal
            // $("#edit_customer_harga_paket").val({{ $customer->user_detail->paket->harga_paket }});
            // $("#edit_customer_by_tambahan_1").val({{ $customer->user_detail->by_tambahan_1 }});
            // $("#edit_customer_by_tambahan_2").val({{ $customer->user_detail->by_tambahan_2 }});
            // $("#edit_customer_diskon").val({{ $customer->user_detail->diskon }});

            // // Simpan nilai awal harga paket untuk referensi
            // var initialHargaPaket = {{ $customer->user_detail->paket->harga_paket }};

            // // Fungsi untuk menghitung dan memperbarui nilai tarif
            // function hitungTarif() {
            //     // Cek jika nilai layanan telah berubah menjadi 0 atau kosong dan kembalikan ke nilai awal jika perlu
            //     if ($("#edit_customer_harga_paket").val() === "" || $("#edit_customer_harga_paket").val() === "0") {
            //         $("#edit_customer_harga_paket").val(initialHargaPaket);
            //     }

            //     // Parse semua nilai input sebagai angka
            //     var layanan = parseInt($("#edit_customer_harga_paket").val()) || initialHargaPaket;
            //     var biaya1 = parseInt($("#edit_customer_by_tambahan_1").val()) || 0;
            //     var biaya2 = parseInt($("#edit_customer_by_tambahan_2").val()) || 0;
            //     var diskon = parseInt($("#edit_customer_diskon").val()) || 0;

            //     // console.log("Nilai input:", {
            //     //     layanan,
            //     //     biaya1,
            //     //     biaya2,
            //     //     diskon
            //     // });

            //     // Pastikan semua nilai terhitung dengan benar dalam total
            //     var totalBiaya = layanan + biaya1 + biaya2;
            //     //console.log("Total biaya sebelum diskon:", totalBiaya);

            //     // Kurangi diskon dari total
            //     var nilaiAkhir = totalBiaya - diskon;

            //     // Pastikan hasil tidak negatif
            //     if (nilaiAkhir < 0) {
            //         nilaiAkhir = 0;
            //     }

            //     //console.log("Nilai akhir setelah diskon:", nilaiAkhir);

            //     // Tampilkan hasil di field tarif
            //     $("#tarif").val(nilaiAkhir);
            // }

            // // Jalankan perhitungan awal saat dokumen siap
            // $(document).ready(function() {
            //     hitungTarif();
            // });

            // // Event handler untuk field biaya tambahan dan diskon
            // $("#edit_customer_by_tambahan_1, #edit_customer_by_tambahan_2, #edit_customer_diskon").on(
            //     'input change blur',
            //     function() {
            //         // Pastikan nilai layanan tidak hilang
            //         if ($("#edit_customer_harga_paket").val() === "" || $("#edit_customer_harga_paket")
            //             .val() === "0") {
            //             $("#edit_customer_harga_paket").val(initialHargaPaket);
            //         }
            //         hitungTarif();
            //     });

            // // Event handler khusus untuk harga paket
            // $("#edit_customer_harga_paket").on('input change blur', function() {
            //     // Update nilai awal jika pengguna mengubahnya secara manual
            //     var newValue = parseInt($(this).val()) || 0;
            //     if (newValue > 0) {
            //         initialHargaPaket = newValue;
            //     }
            //     hitungTarif();
            // });

            // // Pastikan field tarif menampilkan nilai yang benar saat mendapat fokus
            // $("#tarif").on('focus', function() {
            //     hitungTarif();
            // });


            // Inisialisasi nilai awal
            $("#edit_customer_harga_paket").val({{ $customer->user_detail->paket->harga_paket }});
            $("#edit_customer_by_tambahan_1").val({{ $customer->user_detail->by_tambahan_1 }});
            $("#edit_customer_by_tambahan_2").val({{ $customer->user_detail->by_tambahan_2 }});
            $("#edit_customer_diskon").val({{ $customer->user_detail->diskon }});
            $("#edit_customer_ppn").val({{ $ppn->ppn ?? 11 }});

            // Simpan nilai awal harga paket untuk referensi
            var initialHargaPaket = {{ $customer->user_detail->paket->harga_paket }};

            var defaultPpnRate = {{ $ppn->ppn ?? 11 }};

            // Fungsi untuk menghitung dan memperbarui nilai tarif
            function hitungTarif() {
                // Cek jika nilai layanan telah berubah menjadi 0 atau kosong dan kembalikan ke nilai awal jika perlu
                if ($("#edit_customer_harga_paket").val() === "" || $("#edit_customer_harga_paket").val() === "0") {
                    $("#edit_customer_harga_paket").val(initialHargaPaket);
                }

                // Parse semua nilai input sebagai angka
                var layanan = parseInt($("#edit_customer_harga_paket").val()) || initialHargaPaket;
                var biaya1 = parseInt($("#edit_customer_by_tambahan_1").val()) || 0;
                var biaya2 = parseInt($("#edit_customer_by_tambahan_2").val()) || 0;
                var diskon = parseInt($("#edit_customer_diskon").val()) || 0;
                var ppnRate = parseInt($("#edit_customer_ppn").val()) || defaultPpnRate;

                // Pastikan semua nilai terhitung dengan benar dalam total
                var totalBiaya = layanan + biaya1 + biaya2;

                // Kurangi diskon dari total
                //var nilaiAkhir = totalBiaya - diskon;

                // Pastikan hasil tidak negatif
                // if (nilaiAkhir < 0) {
                //     nilaiAkhir = 0;
                // }

                var subTotal = totalBiaya - diskon;

                // Pastikan hasil tidak negatif
                if (subTotal < 0) {
                    subTotal = 0;
                }

                // Hitung PPN
                var ppnValue = Math.round(layanan * (ppnRate / 100));
                console.log("ppnValue:", ppnValue);
                //let ppnValue = 11000;

                var nilaiAkhir = subTotal + ppnValue;

                // Tampilkan hasil di field tarif
                $("#tarif").val(nilaiAkhir);
                $("#ppn_value").val(ppnValue);

                let nilaiAngka = parseFloat(ppnValue);


                if (!isNaN(nilaiAngka)) {
                    let formatted = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(nilaiAngka);

                    $('#targetBr').after('<span>' + formatted + '</span>');
                }

                // Sinkronkan nilai ke form xendit
                updateXenditFormValues();

                return nilaiAkhir;
            }

            // Fungsi untuk memperbarui form xendit dengan nilai-nilai terbaru
            function updateXenditFormValues() {
                // Transfer nilai dari input modal ke form pay-xendit
                $('#pay-xendit input[name="harga_paket"]').val($('#edit_customer_harga_paket').val());
                $('#pay-xendit input[name="by_tambahan_1"]').val($('#edit_customer_by_tambahan_1').val());
                $('#pay-xendit input[name="by_tambahan_2"]').val($('#edit_customer_by_tambahan_2').val());
                $('#pay-xendit input[name="diskon"]').val($('#edit_customer_diskon').val());
                $('#pay-xendit input[name="tarif"]').val($('#tarif').val());
                $('#pay-xendit input[name="ppn_value"]').val($('#ppn_value').val());

                // Update bulan jika ada di kedua form
                if ($('#bulan').length) {
                    // Jika belum ada field bulan di form xendit, tambahkan
                    if (!$('#pay-xendit input[name="bulan"]').length) {
                        $('#pay-xendit').append('<input type="hidden" name="bulan" value="' + $('#bulan').val() +
                            '">');
                    } else {
                        $('#pay-xendit input[name="bulan"]').val($('#bulan').val());
                    }
                }

                // Update keterangan tambahan jika diperlukan
                if ($('#edit_customer_keterangan_tambahan_1').length) {
                    if (!$('#pay-xendit input[name="keterangan_tambahan_1"]').length) {
                        $('#pay-xendit').append('<input type="hidden" name="keterangan_tambahan_1" value="' +
                            $('#edit_customer_keterangan_tambahan_1').val() + '">');
                    } else {
                        $('#pay-xendit input[name="keterangan_tambahan_1"]').val($(
                            '#edit_customer_keterangan_tambahan_1').val());
                    }
                }

                if ($('#edit_customer_keterangan_tambahan_2').length) {
                    if (!$('#pay-xendit input[name="keterangan_tambahan_2"]').length) {
                        $('#pay-xendit').append('<input type="hidden" name="keterangan_tambahan_2" value="' +
                            $('#edit_customer_keterangan_tambahan_2').val() + '">');
                    } else {
                        $('#pay-xendit input[name="keterangan_tambahan_2"]').val($(
                            '#edit_customer_keterangan_tambahan_2').val());
                    }
                }
            }

            // Jalankan perhitungan awal saat dokumen siap
            $(document).ready(function() {
                if (!$('#ppn_value').length) {
                    $('#tarif').after('<input type="hidden" id="ppn_value" name="ppn_value">');
                }
                hitungTarif();

                // Override onclick handler untuk tombol Bayar Online
                $('a.btn-success[href="#"][onclick*="pay-xendit"]').attr('onclick', '').on('click',
                    function(e) {
                        e.preventDefault();

                        // Pastikan form xendit terupdate dengan nilai terbaru
                        updateXenditFormValues();

                        // Submit form
                        $('#pay-xendit').submit();
                    });
            });

            // Event handler untuk field biaya tambahan dan diskon
            $("#edit_customer_by_tambahan_1, #edit_customer_by_tambahan_2, #edit_customer_diskon").on(
                'input change blur',
                function() {
                    // Pastikan nilai layanan tidak hilang
                    if ($("#edit_customer_harga_paket").val() === "" || $("#edit_customer_harga_paket")
                        .val() === "0") {
                        $("#edit_customer_harga_paket").val(initialHargaPaket);
                    }
                    hitungTarif();
                });

            // Event handler khusus untuk harga paket
            $("#edit_customer_harga_paket").on('input change blur', function() {
                // Update nilai awal jika pengguna mengubahnya secara manual
                var newValue = parseInt($(this).val()) || 0;
                if (newValue > 0) {
                    initialHargaPaket = newValue;
                }
                hitungTarif();
            });

            // Event handler untuk field bulan
            $("#bulan").on('change', function() {
                updateXenditFormValues();
            });

            // Event handler untuk keterangan tambahan
            $("#edit_customer_keterangan_tambahan_1, #edit_customer_keterangan_tambahan_2").on('input change blur',
                function() {
                    updateXenditFormValues();
                });

            // Pastikan field tarif menampilkan nilai yang benar saat mendapat fokus
            $("#tarif").on('focus', function() {
                hitungTarif();
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bulanSelect = document.getElementById('bulan');
            const tahunInput = document.getElementById('tahun');
            const displayPeriode = document.getElementById('display-periode');

            // Set tahun default (tahun sekarang)
            const currentYear = new Date().getFullYear();
            tahunInput.value = currentYear;

            // Nama-nama bulan
            const namaBulan = [
                "", "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ];

            // Update display saat pertama kali
            updatePeriodeDisplay();

            // Event listener untuk perubahan bulan
            bulanSelect.addEventListener('change', function() {
                updatePeriodeDisplay();
            });

            function updatePeriodeDisplay() {
                const bulanValue = bulanSelect.value;
                if (bulanValue) {
                    displayPeriode.textContent = `${namaBulan[bulanValue]} ${tahunInput.value}`;
                } else {
                    displayPeriode.textContent = '-';
                }
            }
        });
    </script>
@endpush
