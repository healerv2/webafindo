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
                                        <div class="mb-3">
                                            <label for="paket_id" class="form-label">Bulan</label>
                                            <select name="bulan" id="edit_customer_paket" class="form-control" required>
                                                <option value="">Pilih Bulan</option>
                                                <option value="1">Januari</option>
                                                <option value="2">Februari</option>
                                                <option value="3">Maret</option>
                                                <option value="4">April</option>
                                                <option value="5">Mei</option>
                                                <option value="6">Juni</option>
                                                <option value="7">Juli</option>
                                                <option value="8">Agustus</option>
                                                <option value="9">September</option>
                                                <option value="10">Oktober</option>
                                                <option value="11">November</option>
                                                <option value="12">Desember</option>
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
                                    </div>
                                </form>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light waves-effect"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary waves-effect waves-light">Save
                                        changes</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                    <div class="d-flex align-items-center">
                        <a href="#">
                            <img src="assets/images/project-logo/project2.jpg" alt=""
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
                    <table class="table table-striped mb-0">
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
                                <td>{{ tanggal_indonesia($customer->user_detail->tanggal_tagihan, false) }}</td>
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
                                <td>0%
                                    <br />
                                    <br />
                                    0
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

                </div>
            </div>
        </div>
        <!-- end col -->
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
        });
    </script>
@endpush
