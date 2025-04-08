@extends('layouts.master')

@section('title')
    Mikrotik
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Mikrotik</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-responsive">
                    @can('create mikrotik')
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="fa fa-plus-circle"></i>
                            Tambah Mikrotik
                        </button>
                    @endcan
                    <p></p>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table1">
                            <thead>
                                <th>No</th>
                                <th>Nama Mikrotik</th>
                                <th>IP Address</th>
                                <th>Status</th>
                                <th width="15%"><i class="fa fa-cog"></i></th>
                            </thead>
                        </table>
                    </div>
                </div>
                <!-- Add Modal -->
                <div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title align-self-center" id="myModalLabel">
                                    Mikrotik</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="addMikrotikForm">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Mikrotik</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">IP Mikrotik</label>
                                        <input type="text" class="form-control" id="ip_address" name="ip" required>
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Port Mikrotik</label>
                                        <input type="number" class="form-control" id="port" name="port"
                                            step="0.01">
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="price" class="form-label">User Mikrotik</label>
                                        <input type="text" class="form-control" id="username" name="username"
                                            step="0.01">
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Password Mikrotik</label>
                                        <input type="password" class="form-control" id="password" name="password"
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
                <div class="modal fade" id="editModalMikrotik" tabindex="-1" aria-labelledby="editModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title align-self-center" id="myModalLabel">
                                    Mikrotik</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="editMikrotikForm">
                                <div class="modal-body">
                                    <input type="hidden" id="edit_mikrotik_id">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Mikrotik</label>
                                        <input type="text" class="form-control" id="edit_mikrotik_name"
                                            name="name" required>
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">IP Mikrotik</label>
                                        <input type="text" class="form-control" id="edit_mikrotik_ip_address"
                                            name="ip" required>
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Port Mikrotik</label>
                                        <input type="number" class="form-control" id="edit_mikrotik_port"
                                            name="port" step="0.01">
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="price" class="form-label">User Mikrotik</label>
                                        <input type="text" class="form-control" id="edit_mikrotik_username"
                                            name="username" step="0.01">
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Password Mikrotik</label>
                                        <input type="password" class="form-control" id="edit_mikrotik_passsword"
                                            name="password" step="0.01">
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Status Mikrotik</label>
                                        <select class="form-select" id="edit_mikrotik_is_active" name="is_active"
                                            required>
                                            <option value="">Pilih Status</option>
                                            <option value="1">Aktif</option>
                                            <option value="0">Tidak Aktif</option>
                                        </select>
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

            //Data Paket
            // Load DataTable
            var table = $('#table1').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: "{{ route('mikrotik.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'ip'
                    },
                    {
                        data: 'status'
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
            $('#addMikrotikForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('mikrotik.store') }}",
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
                            $('#addMikrotikForm')[0].reset();
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

            // Edit Paket - Show Modal
            $(document).on('click', '.edit-mikrotik', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: "/dashboard/mikrotik/" + id + "/edit",
                    type: "GET",
                    success: function(response) {
                        if (response.status == 404) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message
                            });
                        } else {
                            $('#edit_mikrotik_id').val(response.mikrotik.id);
                            $('#edit_mikrotik_name').val(response.mikrotik.name);
                            $('#edit_mikrotik_ip_address').val(response.mikrotik.ip);
                            $('#edit_mikrotik_port').val(response.mikrotik.port);
                            $('#edit_mikrotik_username').val(response.mikrotik.username);
                            $('#edit_mikrotik_passsword').val(response.mikrotik.password);
                            $('#edit_mikrotik_is_active').val(response.mikrotik.is_active);
                            $('#editModalMikrotik').modal('show');
                        }
                    }
                });
            });

            // Update Data Mikrotik
            $('#editMikrotikForm').on('submit', function(e) {
                e.preventDefault();
                var id = $('#edit_mikrotik_id').val();

                $.ajax({
                    url: "/dashboard/mikrotik/" + id,
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

            // Delete Data Paket
            $(document).on('click', '.delete-mikrotik', function() {
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
                            url: "/dashboard/mikrotik/" + id,
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
