@extends('layouts.master')

@section('title')
    Profile
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Profile</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-3">
            <div class="card profile">
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset('img/' . auth()->user()->foto ?? '') }}" alt=""
                            class="rounded-circle img-thumbnail avatar-xl">
                        <div class="online-circle">
                            <i class="fa fa-circle text-success"></i>
                        </div>
                        <h4 class="mt-3">Mark Kearney</h4>
                        <p class="text-muted font-size-13">Project Manager</p>
                    </div>
                </div>
            </div>
            <!-- end card -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Contact</h5>
                    <ul class="list-unstyled mb-0">
                        <li class=""><i class="mdi mdi-phone me-2 text-success font-size-18"></i> <b>
                                phone </b> : +91 23456 78910</li>
                        <li class="mt-2"><i class="mdi mdi-email-outline text-success font-size-18 mt-2 me-2"></i>
                            <b> Email </b> : mannat.theme@gmail.com
                        </li>
                        <li class="mt-2"><i class="mdi mdi-map-marker text-success font-size-18 mt-2 me-2"></i>
                            <b>Location</b> : USA
                        </li>
                    </ul>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->

        <div class="col-xl-9">
            <div class="">
                <div class="custom-tab tab-profile">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ set_active('profile.index') }} pb-3 pt-0" data-bs-toggle="tab"
                                href="#data-paket" role="tab"><i class="fab fa-product-hunt me-2"></i>Data Paket</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pb-3 pt-0" data-bs-toggle="tab" href="#area" role="tab"><i
                                    class="fas fa-suitcase me-2"></i>Area</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pb-3 pt-0" data-bs-toggle="tab" href="#profil" role="tab"><i
                                    class="fas fa-cog me-2"></i>Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pb-3 pt-0" data-bs-toggle="tab" href="#password" role="tab"><i
                                    class="fas fa-key me-2"></i>Update Password</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pb-3 pt-0" data-bs-toggle="tab" href="#ppn" role="tab"><i
                                    class="fas fa-key me-2"></i>PPN</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content pt-4">
                        <div class="tab-pane {{ set_active('profile.index') }}" id="data-paket" role="tabpanel">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Data Paket</h5>
                                            @can('create data paket')
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#addModal">
                                                    <i class="fa fa-plus-circle"></i>
                                                    Tambah
                                                </button>
                                            @endcan
                                            <div class="card-body table-responsive">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="table1">
                                                        <thead>
                                                            <th>No</th>
                                                            <th>Nama Paket</th>
                                                            <th>Harga Paket</th>
                                                            <th width="15%"><i class="fa fa-cog"></i></th>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card -->
                                </div>
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- Create Modal Data Paket -->

                        <!-- Add Modal -->
                        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="addModalLabel">Tambah Paket</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form id="addDataPaketForm">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Nama Produk</label>
                                                <input type="text" class="form-control" id="nama_paket"
                                                    name="nama_paket">
                                                <span class="error name_error"></span>
                                            </div>

                                            <div class="mb-3">
                                                <label for="price" class="form-label">Harga</label>
                                                <input type="number" class="form-control" id="harga_paket"
                                                    name="harga_paket" step="0.01">
                                                <span class="error price_error"></span>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="editModalLabel">Edit Produk</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form id="editDataPaketForm">
                                        <div class="modal-body">
                                            <input type="hidden" id="edit_data_paket_id">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Nama Produk</label>
                                                <input type="text" class="form-control" id="edit_nama_paket"
                                                    name="nama_paket">
                                                <span class="error name_error"></span>
                                            </div>

                                            <div class="mb-3">
                                                <label for="price" class="form-label">Harga</label>
                                                <input type="number" class="form-control" id="edit_harga_paket"
                                                    name="harga_paket" step="0.01">
                                                <span class="error price_error"></span>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Perbarui</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- end modal -->

                        <div class="tab-pane {{ set_active('data-area.index') }}" id="area" role="tabpanel">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Data Area</h5>
                                            @can('create data area')
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#addModalArea">
                                                    <i class="fa fa-plus-circle"></i>
                                                    Tambah
                                                </button>
                                            @endcan
                                            <div class="card-body table-responsive">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="table2">
                                                        <thead>
                                                            <th>No</th>
                                                            <th>Nama Area</th>
                                                            <th width="15%"><i class="fa fa-cog"></i></th>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card -->
                                </div>
                            </div>
                            <!-- end row -->
                        </div>

                        <!-- Create Modal Data Paket -->

                        <!-- Add Modal -->
                        <div class="modal fade" id="addModalArea" tabindex="-1" aria-labelledby="addModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="addModalLabel">Tambah Area</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form id="addAreaForm">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Nama Area</label>
                                                <input type="text" class="form-control" id="nama_area"
                                                    name="nama_area">
                                                <span class="error name_error"></span>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModalArea" tabindex="-1" aria-labelledby="editModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="editModalLabel">Edit Area</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form id="editAreaForm">
                                        <div class="modal-body">
                                            <input type="hidden" id="edit_data_area_id">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Nama Area</label>
                                                <input type="text" class="form-control" id="edit_nama_area"
                                                    name="nama_area">
                                                <span class="error name_error"></span>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Perbarui</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- end modal -->
                        <!-- Profile -->
                        <div class="tab-pane" id="profil" role="tabpanel">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Profile</h5>
                                            <form id="profileForm">
                                                @csrf
                                                <div class="mb-3">
                                                    <label class="form-label">Nama</label>
                                                    <input type="text" class="form-control" id="name"
                                                        name="name" value="{{ $user->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email"
                                                        name="email" value="{{ $user->email }}" required>
                                                </div>
                                                <div class="mb-0">
                                                    <div>
                                                        <button type="submit"
                                                            class="btn btn-primary waves-effect waves-light">
                                                            Update Profil
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- end form -->
                                        </div>
                                    </div>
                                    <!-- end card -->
                                </div>
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- Update Password -->
                        <div class="tab-pane" id="password" role="tabpanel">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Update Password</h5>
                                            <form id="changePasswordForm">
                                                @csrf
                                                <div class="mb-3">
                                                    <label class="form-label" for="current_password">Password Saat
                                                        Ini</label>
                                                    <input type="password" class="form-control" id="current_password"
                                                        name="current_password" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="new_password">Password Baru</label>
                                                    <input type="password" class="form-control" id="new_password"
                                                        name="new_password" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="new_password_confirmation">Konfirmasi
                                                        Password Baru</label>
                                                    <input type="password" class="form-control"
                                                        id="new_password_confirmation" name="new_password_confirmation"
                                                        required>
                                                </div>
                                                <div class="mb-0">
                                                    <div>
                                                        <button type="submit"
                                                            class="btn btn-primary waves-effect waves-light">
                                                            Ubah Password
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- end form -->
                                        </div>
                                    </div>
                                    <!-- end card -->
                                </div>
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- Profile -->
                        <div class="tab-pane" id="ppn" role="tabpanel">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">PPN</h5>
                                            <form id="PPNForm">
                                                @csrf
                                                <input type="hidden" id="ppn_id" value="{{ $ppn->id }}">
                                                <div class="mb-3">
                                                    <label class="form-label">PPN</label>
                                                    <input type="number" class="form-control" id="ppn"
                                                        name="ppn" value="{{ $ppn->ppn ?? 0 }}" required>
                                                </div>
                                                <div class="mb-0">
                                                    <div>
                                                        <button type="submit"
                                                            class="btn btn-primary waves-effect waves-light">
                                                            Update PPN
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- end form -->
                                        </div>
                                    </div>
                                    <!-- end card -->
                                </div>
                            </div>
                            <!-- end row -->
                        </div>
                    </div>
                </div>
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
                ajax: "{{ route('data-paket.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'nama_paket'
                    },
                    {
                        data: 'harga_paket'
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

            // Add Paket
            $('#addDataPaketForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('data-paket.store') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status == 400) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message
                            });
                        } else {
                            resetModalState();
                            $('#addDataPaketForm')[0].reset();
                            table.ajax.reload();

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 1500
                            });
                        }
                    }
                });
            });

            // Edit Paket - Show Modal
            $(document).on('click', '.edit', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: "/dashboard/data-paket/" + id + "/edit",
                    type: "GET",
                    success: function(response) {
                        if (response.status == 404) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message
                            });
                        } else {
                            $('#edit_data_paket_id').val(response.layanan.id);
                            $('#edit_nama_paket').val(response.layanan.nama_paket);
                            $('#edit_harga_paket').val(response.layanan.harga_paket);
                            $('#editModal').modal('show');
                        }
                    }
                });
            });

            // Update Data Paket
            $('#editDataPaketForm').on('submit', function(e) {
                e.preventDefault();
                var id = $('#edit_data_paket_id').val();

                $.ajax({
                    url: "/dashboard/data-paket/" + id,
                    type: "PUT",
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status == 400) {
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
                            // $('#editModal').modal('hide');
                            resetModalState();
                            table.ajax.reload();

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 1500
                            });
                        }
                    }
                });
            });

            // Delete Data Paket
            $(document).on('click', '.delete', function() {
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
                            url: "/dashboard/data-paket/" + id,
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
                                        timer: 1500
                                    });
                                }
                            }
                        });
                    }
                });
            });


            // Data Area
            var table = $('#table2').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: "{{ route('data-area.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'nama_area'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false
                    },
                ],
            });

            // Add Area
            $('#addAreaForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('data-area.store') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status == 400) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message
                            });
                        } else {
                            resetModalState();
                            $('#addDataPaketForm')[0].reset();
                            table.ajax.reload();

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 1500
                            });
                        }
                    }
                });
            });
            // Edit Area - Show Modal
            $(document).on('click', '.edit-area', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: "/dashboard/data-area/" + id + "/edit",
                    type: "GET",
                    success: function(response) {
                        if (response.status == 404) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message
                            });
                        } else {
                            $('#edit_data_area_id').val(response.area.id);
                            $('#edit_nama_area').val(response.area.nama_area);
                            $('#editModalArea').modal('show');
                        }
                    }
                });
            });
            // Update Area
            $('#editAreaForm').on('submit', function(e) {
                e.preventDefault();
                var id = $('#edit_data_area_id').val();

                $.ajax({
                    url: "/dashboard/data-area/" + id,
                    type: "PUT",
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status == 400) {
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
                                timer: 1500
                            });
                        }
                    }
                });
            });
            $(document).on('click', '.delete-area', function() {
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
                            url: "/dashboard/data-area/" + id,
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
                                        timer: 1500
                                    });
                                }
                            }
                        });
                    }
                });
            });
        });

        //Profile
        $(document).ready(function() {
            $('#profileForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route('profile.update_profile') }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status === 200) {
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
                        if (xhr.status === 422) {
                            // Validasi error
                            let errors = xhr.responseJSON.errors;
                            let errorMessage = '';

                            $.each(errors, function(field, messages) {
                                errorMessage += messages[0] + '\n';
                            });

                            Swal.fire({
                                icon: 'error',
                                title: 'Validasi Gagal',
                                text: errorMessage
                            });
                        } else {
                            // Error server
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan. Silakan coba lagi.'
                            });
                        }
                    }
                });
            });
        });

        //Change password
        $(document).ready(function() {
            $('#changePasswordForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route('profile.password_update') }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status === 'success') {
                            // Reset form
                            $('#changePasswordForm')[0].reset();

                            // Tampilkan sweet alert sukses
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
                        if (xhr.status === 422) {
                            // Validasi error
                            let errors = xhr.responseJSON.errors;
                            let errorMessage = '';

                            $.each(errors, function(field, messages) {
                                errorMessage += messages[0] + '\n';
                            });

                            Swal.fire({
                                icon: 'error',
                                title: 'Validasi Gagal',
                                text: errorMessage
                            });
                        } else if (xhr.status === 400) {
                            // Error spesifik (misal password salah)
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: xhr.responseJSON.message
                            });
                        } else {
                            // Error server
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan. Silakan coba lagi.'
                            });
                        }
                    }
                });
            });
            //PPN
            $('#PPNForm').on('submit', function(e) {
                e.preventDefault();
                var id = $('#ppn_id').val();

                $.ajax({
                    url: "/dashboard/profile/update-ppn/" + id,
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status === 200) {
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
                        if (xhr.status === 422) {
                            // Validasi error
                            let errors = xhr.responseJSON.errors;
                            let errorMessage = '';

                            $.each(errors, function(field, messages) {
                                errorMessage += messages[0] + '\n';
                            });

                            Swal.fire({
                                icon: 'error',
                                title: 'Validasi Gagal',
                                text: errorMessage
                            });
                        } else {
                            // Error server
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan. Silakan coba lagi.'
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush
