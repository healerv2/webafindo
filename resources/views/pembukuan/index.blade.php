@extends('layouts.master')

@section('title')
    Pembukuan
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Pembukuan</li>
@endsection

@section('content')
    <div class="row">
        <div class="card-body">
            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                data-bs-target="#myModal">Tambah Pembukuan</button>

            <!-- sample modal content -->
            <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title align-self-center" id="myModalLabel">
                                Tambah Pembukuan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="addPembukuanForm">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <input type="text" class="form-control" id="keterangan" name="keterangan" required>
                                    <span class="error name_error"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="jumlah" class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                                    <span class="error jumlah_error"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="tipe_pembukuan" class="form-label">Tipe</label>
                                    <select class="form-select" id="tipe_pembukuan" name="tipe_pembukuan"
                                        style="width: 100%; height:36px;">
                                        <option value="">-- Pilih Tipe --</option>
                                        <option value="pemasukan">Pemasukan</option>
                                        <option value="pengeluaran">Pengeluaran</option>
                                        <option value="setoran">Setoran</option>
                                    </select>
                                    <span class="error tipe_error"></span>
                                </div>

                                <input type="hidden" id="admin" name="admin" value="{{ Auth::id() }}">

                                <!-- Form Pengeluaran (awalnya disembunyikan) -->
                                <div id="form-pengeluaran" style="display: none;">
                                    <div class="mb-3">
                                        <label for="kategori_pengeluaran" class="form-label">Kategori Pengeluaran</label>
                                        <select class="form-select" id="kategori_pengeluaran" name="kategori_pengeluaran">
                                            <option value="">-- Pilih Kategori --</option>
                                            <option value="pasang baru">Pasang Baru</option>
                                            <option value="perbaikan alat">Pasang Baru</option>
                                            <option value="bandwith">Bandwith</option>
                                            <option value="penagihan">Penagihan</option>
                                            <option value="marketing">Marketing</option>
                                            <option value="listrik-PDAM-pulsa">Listrik / PDAM / Pulsa</option>
                                            <option value="gaji">Gaji</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Form Setoran (awalnya disembunyikan) -->
                                <div id="form-setoran" style="display: none;">
                                    <div class="mb-3">
                                        <label for="tagih" class="form-label">Penagihan</label>
                                        <select class="form-select" id="tagih" name="tagih">
                                            <option value="">-- Pilih Penagihan --</option>
                                            @foreach ($tagih as $t)
                                                <option value="{{ $t->id }}">{{ $t->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>
    </div>

    <div class="row">
        <h5 class="card-title">Pemasukkan</h5>
        <!-- end col -->
        <div class="col-sm-6 col-xl-3">
            <div class="card card-content">
                <div class="card-body row justify-content-center">
                    <div class="col-12 align-self-center">

                        <p class="mb-2 text-muted font-size-13 text-nowrap">Transaksi Cash</p>
                        <h1 class="my-4 text-success">{{ 'Rp. ' . format_uang($total_transaksi_cash) }}</h1>
                        <a href="#" class="text-black my-6">Detail<i class="mdi mdi-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card card-content">
                <div class="card-body row justify-content-center">
                    <div class="col-12 align-self-center">

                        <p class="mb-2 text-muted font-size-13 text-nowrap">Transaksi Online</p>
                        <h1 class="my-4 text-success">{{ 'Rp. ' . format_uang($total_transaksi_online) }}</h1>
                        <a href="#" class="text-black my-6">Detail<i class="mdi mdi-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
        <div class="col-sm-6 col-xl-3">
            <div class="card card-content">
                <div class="card-body row justify-content-center">
                    <div class="col-12 align-self-center">

                        <p class="mb-2 text-muted font-size-13 text-nowrap">Pemasukkan Lain-lain</p>
                        <h1 class="my-4 text-success">{{ 'Rp. ' . format_uang($total_transaksi_lainnya) }}</h1>
                        <a href="{{ route('pembukuan.pemasukan_lainnya_view') }}" class="text-black my-6">Detail
                            <i class="mdi mdi-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
    <div class="row">
        <h5 class="card-title">Pengeluaran</h5>
        <!-- end col -->
        <div class="col-sm-6 col-xl-3">
            <div class="card card-content">
                <div class="card-body row justify-content-center">
                    <div class="col-12 align-self-center">

                        <p class="mb-2 text-muted font-size-13 text-nowrap">Gaji Karyawan</p>
                        <h1 class="my-4 text-danger">{{ 'Rp. ' . format_uang($total_pengeluaran_gaji) }}</h1>
                        <a href="{{ route('pembukuan.get_gaji_view') }}" class="text-black my-6">Detail
                            <i class="mdi mdi-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card card-content">
                <div class="card-body row justify-content-center">
                    <div class="col-12 align-self-center">

                        <p class="mb-2 text-muted font-size-13 text-nowrap">Pasang Baru</p>
                        <h1 class="my-4 text-danger">{{ 'Rp. ' . format_uang($total_pengeluaran_pasang_baru) }}</h1>
                        <a href="{{ route('pembukuan.pasang_baru_view') }}" class="text-black my-6">Detail
                            <i class="mdi mdi-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
        <div class="col-sm-6 col-xl-3">
            <div class="card card-content">
                <div class="card-body row justify-content-center">
                    <div class="col-12 align-self-center">

                        <p class="mb-2 text-muted font-size-13 text-nowrap">Perbaikan Alat</p>
                        <h1 class="my-4 text-danger">{{ 'Rp. ' . format_uang($total_pengeluaran_perbaikan_alat) }}</h1>
                        <a href="{{ route('pembukuan.perbaikan_alat_view') }}" class="text-black my-6">Detail
                            <i class="mdi mdi-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card card-content">
                <div class="card-body row justify-content-center">
                    <div class="col-12 align-self-center">

                        <p class="mb-2 text-muted font-size-13 text-nowrap">Bandwith</p>
                        <h1 class="my-4 text-danger">{{ 'Rp. ' . format_uang($total_pengeluaran_bandwith) }}</h1>
                        <a href="{{ route('pembukuan.bandwith_view') }}" class="text-black my-6">Detail
                            <i class="mdi mdi-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card card-content">
                <div class="card-body row justify-content-center">
                    <div class="col-12 align-self-center">

                        <p class="mb-2 text-muted font-size-13 text-nowrap">Bayar Kang Tagih</p>
                        <h1 class="my-4 text-danger">{{ 'Rp. ' . format_uang($total_pengeluaran_penagihan) }}</h1>
                        <a href="{{ route('pembukuan.penagihan_view') }}" class="text-black my-6">Detail
                            <i class="mdi mdi-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card card-content">
                <div class="card-body row justify-content-center">
                    <div class="col-12 align-self-center">

                        <p class="mb-2 text-muted font-size-13 text-nowrap">Bayar Listrik / PDAM / Pulsa</p>
                        <h1 class="my-4 text-danger">{{ 'Rp. ' . format_uang($total_pengeluaran_lisrtik_pdam_pulsa) }}
                        </h1>
                        <a href="{{ route('pembukuan.lisrik_pdam_pulsa_view') }}" class="text-black my-6">Detail
                            <i class="mdi mdi-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card card-content">
                <div class="card-body row justify-content-center">
                    <div class="col-12 align-self-center">

                        <p class="mb-2 text-muted font-size-13 text-nowrap">Bayar Marketing</p>
                        <h1 class="my-4 text-danger">{{ 'Rp. ' . format_uang($total_pengeluaran_marketing) }}</h1>
                        <a href="{{ route('pembukuan.marketing_view') }}" class="text-black my-6">Detail
                            <i class="mdi mdi-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card card-content">
                <div class="card-body row justify-content-center">
                    <div class="col-12 align-self-center">

                        <p class="mb-2 text-muted font-size-13 text-nowrap">Lain lain</p>
                        <h1 class="my-4 text-danger">{{ 'Rp. ' . format_uang($total_pengeluaran_lainnya) }}</h1>
                        <a href="{{ route('pembukuan.lainnya_view') }}" class="text-black my-6">Detail
                            <i class="mdi mdi-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- end row -->
    <div class="row">
        <h5 class="card-title">Total Pendapatan</h5>
        <!-- end col -->
        <div class="col-sm-6 col-xl-3">
            <div class="card card-content">
                <div class="card-body row justify-content-center">
                    <div class="col-12 align-self-center">

                        <p class="mb-2 text-muted font-size-13 text-nowrap">Total Pemasukkan</p>
                        <h1 class="my-4 text-success">{{ 'Rp. ' . format_uang($total_pemasukan) }}</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card card-content">
                <div class="card-body row justify-content-center">
                    <div class="col-12 align-self-center">

                        <p class="mb-2 text-muted font-size-13 text-nowrap">Total Pengeluaran</p>
                        <h1 class="my-4 text-danger">{{ 'Rp. ' . format_uang($total_pengeluaran) }}</h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
        <div class="col-sm-6 col-xl-3">
            <div class="card card-content">
                <div class="card-body row justify-content-center">
                    <div class="col-12 align-self-center">

                        <p class="mb-2 text-muted font-size-13 text-nowrap">Pendapatan</p>
                        <h1 class="my-4 text-primary">{{ 'Rp. ' . format_uang($total_pendapatan) }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mendapatkan elemen select tipe pembukuan
            const tipePembukuan = document.getElementById('tipe_pembukuan');
            const formPengeluaran = document.getElementById('form-pengeluaran');
            const formSetoran = document.getElementById('form-setoran');
            const adminInput = document.getElementById('admin');
            const authId = "{{ Auth::id() }}"; // ID dari user yang sedang login

            // Menambahkan event listener untuk perubahan pada select
            tipePembukuan.addEventListener('change', function() {
                // Menyembunyikan semua form khusus terlebih dahulu
                formPengeluaran.style.display = 'none';
                formSetoran.style.display = 'none';

                // Reset admin ID ke default (auth ID)
                adminInput.value = authId;

                // Menampilkan form yang sesuai berdasarkan pilihan
                if (this.value === 'pengeluaran') {
                    formPengeluaran.style.display = 'block';
                } else if (this.value === 'setoran') {
                    formSetoran.style.display = 'block';
                }
            });

            // Mendapatkan elemen select penagihan
            const tagihSelect = document.getElementById('tagih');
            if (tagihSelect) {
                tagihSelect.addEventListener('change', function() {
                    // Update nilai admin dengan ID penagih saat dipilih
                    if (this.value) {
                        adminInput.value = this.value;
                    } else {
                        adminInput.value = authId; // Reset jika tidak dipilih
                    }
                });
            }
        });
    </script>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mendapatkan elemen select tipe pembukuan
            const tipePembukuan = document.getElementById('tipe_pembukuan');
            const formPengeluaran = document.getElementById('form-pengeluaran');
            const formSetoran = document.getElementById('form-setoran');

            // Menambahkan event listener untuk perubahan pada select
            tipePembukuan.addEventListener('change', function() {
                // Menyembunyikan semua form khusus terlebih dahulu
                formPengeluaran.style.display = 'none';
                formSetoran.style.display = 'none';

                // Menampilkan form yang sesuai berdasarkan pilihan
                if (this.value === 'pengeluaran') {
                    formPengeluaran.style.display = 'block';
                } else if (this.value === 'setoran') {
                    formSetoran.style.display = 'block';
                }
            });
        });
    </script> --}}
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

            // Clear error messages when modal is closed
            $('.modal').on('hidden.bs.modal', function() {
                $('.error').text('');
                $(this).find('form')[0].reset();
            });

            // Add 
            $('#addPembukuanForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('pembukuan.store') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status == 409) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message,
                                showConfirmButton: true,
                                timer: 1500
                            });
                        } else {
                            resetModalState();
                            $('#addPembukuanForm')[0].reset();

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                showConfirmButton: true,
                                timer: 1500
                            }).then((result) => {
                                // Reload halaman setelah SweetAlert ditutup
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        // Cek jika error 500
                        if (xhr.status == 500) {
                            const response = JSON.parse(xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message,
                                showConfirmButton: true,
                                timer: 1500
                            });
                        } else {
                            let message = 'Terjadi kesalahan pada sistem';
                            // Coba mendapatkan pesan error jika tersedia
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: message,
                                showConfirmButton: true,
                                timer: 1500
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush
