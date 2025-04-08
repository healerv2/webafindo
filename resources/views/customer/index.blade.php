@extends('layouts.master')

@section('title')
    Customer
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Customer</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-responsive">
                    @can('create customer')
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="fa fa-plus-circle"></i>
                            Tambah Customer
                        </button>
                    @endcan
                    <p></p>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table1">
                            <thead>
                                <th>No</th>
                                <th>Nama</th>
                                <th>PPOE</th>
                                <th>Paket</th>
                                <th>Area</th>
                                <th>Biaya</th>
                                <th>Tanggal Register</th>
                                <th width="15%"><i class="fa fa-cog"></i></th>
                            </thead>
                        </table>
                    </div>
                </div>
                <!-- Add Modal -->
                <div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title align-self-center" id="myModalLabel">
                                    Tambah Customer</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="addCustomerForm">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ppoe" class="form-label">ID PPOE</label>
                                        <input type="text" class="form-control" id="ppoe" name="ppoe"
                                            step="0.01">
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="mikrotik" class="form-label">Mikrotik</label>
                                        <select name="mikrotik_id" id="mikrotik_id" class="form-control" required>
                                            <option value="">Pilih Mikrotik</option>
                                            @foreach ($mikrotik as $key => $item)
                                                <option value="{{ $key }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="area" class="form-label">Area</label>
                                        <select name="area_id" id="area_id" class="form-control" required>
                                            <option value="">Pilih Area</option>
                                            @foreach ($area as $key => $item)
                                                <option value="{{ $key }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="paket_id" class="form-label">Tarif</label>
                                        <select name="paket_id" id="paket_id" class="form-control" required>
                                            <option value="">Pilih Tarif</option>
                                            @foreach ($paket as $key => $item)
                                                <option value="{{ $key }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nohp" class="form-label">No WA</label>
                                        <input type="number" class="form-control" id="nohp" name="nohp" required>
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggal_tagihan" class="form-label">Tanggal Tagihan</label>
                                        <input type="date" class="form-control" id="tanggal_tagihan"
                                            name="tanggal_tagihan" required>
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="tanggal_tagihan" class="form-label">Biaya Tambahan 1</label>
                                        <div class="col-lg-6  mo-b-15">
                                            <input class="form-control" type="text" id="keterangan_tambahan_1"
                                                name="keterangan_tambahan_1" placeholder="Rincian Biaya Tambahan 1">
                                        </div>
                                        <div class="col-lg-6">
                                            <input class="form-control" type="number" id="by_tambahan_1"
                                                name="by_tambahan_1" placeholder="Biaya Tambahan 1">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="tanggal_tagihan" class="form-label">Biaya Tambahan 2</label>
                                        <div class="col-lg-6  mo-b-15">
                                            <input class="form-control" type="text" id="keterangan_tambahan_2"
                                                name="keterangan_tambahan_2" placeholder="Rincian Biaya Tambahan 2">
                                        </div>
                                        <div class="col-lg-6">
                                            <input class="form-control" type="number" id="by_tambahan_2"
                                                name="by_tambahan_2" placeholder="Biaya Tambahan 2">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="diskon" class="form-label">Diskon</label>
                                        <input type="number" class="form-control" id="diskon" name="diskon">
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <input type="text" class="form-control" id="alamat" name="alamat"
                                            step="0.01">
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col-lg-6  mo-b-15">
                                            <label for="latitude" class="form-label">Latitude (-8.xxxxxx)</label>
                                            <input class="form-control" type="text" id="latitude" name="latitude"
                                                placeholder="Latitude (-8.xxxxxx)">
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="longitude" class="form-label">Longitude (113.xxxxxx)</label>
                                            <input class="form-control" type="text" id="longitude" name="longitude"
                                                placeholder="Longitude (113.xxxxxx)">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="perangkat" class="form-label">Modem </label>
                                        <input type="text" class="form-control" id="perangkat" name="perangkat"
                                            step="0.01">
                                        <span class="error name_error"></span>
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
                <!-- end modal -->
                <!-- Edit Modal -->
                <div class="modal fade" id="editModalCustomer" tabindex="-1" aria-labelledby="editModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title align-self-center" id="myModalLabel">
                                    Customer</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="editCustomerForm">
                                <div class="modal-body">
                                    <input type="hidden" id="edit_customer_id">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="edit_customer_name"
                                            name="name" required>
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="edit_customer_email"
                                            name="email" required>
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ppoe" class="form-label">ID PPOE</label>
                                        <input type="text" class="form-control" id="edit_customer_ppoe"
                                            name="ppoe" step="0.01">
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="mikrotik" class="form-label">Mikrotik</label>
                                        <select name="mikrotik_id" id="edit_customer_mikrotik" class="form-control"
                                            required>
                                            <option value="">Pilih Mikrotik</option>
                                            @foreach ($mikrotik as $key => $item)
                                                <option value="{{ $key }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="area" class="form-label">Area</label>
                                        <select name="area_id" id="edit_customer_area" class="form-control" required>
                                            <option value="">Pilih Area</option>
                                            @foreach ($area as $key => $item)
                                                <option value="{{ $key }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="paket_id" class="form-label">Tarif</label>
                                        <select name="paket_id" id="edit_customer_paket" class="form-control" required>
                                            <option value="">Pilih Tarif</option>
                                            @foreach ($paket as $key => $item)
                                                <option value="{{ $key }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nohp" class="form-label">No WA</label>
                                        <input type="number" class="form-control" id="edit_customer_nohp"
                                            name="nohp" required>
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggal_tagihan" class="form-label">Tanggal Tagihan</label>
                                        <input type="date" class="form-control" id="edit_customer_tanggal_tagihan"
                                            name="tanggal_tagihan" required>
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
                                        <label for="diskon" class="form-label">Diskon</label>
                                        <input type="number" class="form-control" id="edit_customer_diskon"
                                            name="diskon">
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <input type="text" class="form-control" id="edit_customer_alamat"
                                            name="alamat" step="0.01">
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col-lg-6  mo-b-15">
                                            <label for="latitude" class="form-label">Latitude (-8.xxxxxx)</label>
                                            <input class="form-control" type="text" id="edit_customer_latitude"
                                                name="latitude" placeholder="Latitude (-8.xxxxxx)">
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="longitude" class="form-label">Longitude (113.xxxxxx)</label>
                                            <input class="form-control" type="text" id="edit_customer_longitude"
                                                name="longitude" placeholder="Longitude (113.xxxxxx)">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="perangkat" class="form-label">Modem</label>
                                        <input type="text" class="form-control" id="edit_customer_perangkat"
                                            name="perangkat" step="0.01">
                                        <span class="error name_error"></span>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- end modal -->
                <div id="showModalMikrotik" class="modal fade" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title align-self-center" id="myModalLabel">
                                    Mikrotik</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h5>Resource Mikrotik</h5>

                                <ul class="list-unstyled mb-0">
                                    <li class=""><i class="mdi mdi-clock me-2 text-success font-size-18"></i> <b>
                                            Uptime </b> : <span id="uptime"></span></li>
                                    <li class="mt-2"><i
                                            class="mdi mdi-email-outline text-success font-size-18 mt-2 me-2"></i>
                                        <b> Version </b> : <span id="version"></span>
                                    </li>
                                    <li class="mt-2"><i
                                            class="mdi mdi-map-marker text-success font-size-18 mt-2 me-2"></i>
                                        <b>Platform</b> : <span id="platform">
                                    </li>
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- end modal -->

            </div>
        </div>
    </div>
    <!--end row-->
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
                ajax: "{{ route('customer.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'Nama'
                    },
                    {
                        data: 'user_detail.mikrotik.name'
                    },
                    {
                        data: 'user_detail.paket.nama_paket'
                    },
                    {
                        data: 'user_detail.area.nama_area'
                    },
                    {
                        data: 'total'
                    },
                    {
                        data: 'created_at'
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

            // Add Mikrotik
            $('#addCustomerForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('customer.store') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status == 409) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Oops...',
                                text: response.message,
                                showConfirmButton: true,
                                timer: 1500
                            });
                        } else {
                            resetModalState();
                            $('#addCustomerForm')[0].reset();
                            table.ajax.reload();

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                showConfirmButton: true,
                                timer: 1500
                            });
                        }
                    },
                    error: function(response) {
                        // Cek jika error 500
                        if (response.status === 500) {
                            Swal.fire({
                                title: 'Oops...',
                                text: response.message,
                                icon: 'error',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message,
                                showConfirmButton: true,
                                timer: 1500
                            });
                        }
                    }
                });
            });

            // Edit Customer - Show Modal
            $(document).on('click', '.edit-customer', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: "/dashboard/customer/" + id + "/edit",
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
                            $('#edit_customer_alamat').val(response.customer.user_detail
                                .alamat);
                            $('#edit_customer_latitude').val(response.customer.user_detail
                                .latitude);
                            $('#edit_customer_longitude').val(response.customer.user_detail
                                .longitude);
                            $('#edit_customer_perangkat').val(response.customer.user_detail
                                .perangkat);
                            $('#editModalCustomer').modal('show');
                        }
                    }
                });
            });

            // Update Data Customer
            $('#editCustomerForm').on('submit', function(e) {
                e.preventDefault();
                var id = $('#edit_customer_id').val();

                $.ajax({
                    url: "/dashboard/customer/" + id,
                    type: "PUT",
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

            // Delete Customer
            $(document).on('click', '.delete-customer', function() {
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/dashboard/customer/" + id,
                            type: "DELETE",
                            success: function(response) {
                                if (response.status == 404) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: response.message
                                    });
                                } else {
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
                    }
                });
            });
            //Show Mikrotik
            $(document).on('click', '.show-mikrotik', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: "/dashboard/mikrotik/" + id,
                    type: "GET",
                    success: function(response) {
                        if (response.status == 404) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message
                            });
                        } else {
                            $('#uptime').text(response.mikrotik.uptime);
                            $('#version').text(response.mikrotik.version);
                            $('#platform').text(response.mikrotik.platform);
                            $('#showModalMikrotik').modal('show');
                        }
                    }
                });
            });
        });
    </script>
@endpush
