@extends('layouts.master')

@section('title')
    Tugas Teknisi
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"> Tugas Teknisi</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-responsive">
                    @can('create tugas teknisi')
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="fa fa-plus-circle"></i>
                            Tambah Tugas Teknisi
                        </button>
                    @endcan
                    <p></p>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table1">
                            <thead>
                                <th>No</th>
                                <th>Tugas</th>
                                <th>Pelanggan</th>
                                <th>Job</th>
                                <th>Teknisi</th>
                                <th>Status</th>
                                <th>Kerusakan</th>
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
                                    Tugas Teknisi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="addTugasTeknisiForm">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="tugas" class="form-label">Tugas</label>
                                        <input type="text" class="form-control" id="tugas" name="tugas" required>
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Teknisi</label>
                                        <select name="teknisi" id="teknisi" class="form-select">
                                            <option value="">-- Pilih Teknisi --</option>
                                            @foreach ($technicians as $technician)
                                                <option value="{{ $technician->id }}">{{ $technician->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Customer</label>
                                        <select name="user_id" id="user_id" class="form-select">
                                            <option value="">-- Pilih Customer --</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
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
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- end modal -->
                <!-- Edit Modal -->
                <div class="modal fade" id="editModalTugasTeknisi" tabindex="-1" aria-labelledby="editModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title align-self-center" id="myModalLabel">
                                    Detail Tugas <span id="edit_tugas_kode"></span> </h5>
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="editTugasTeknisiForm">
                                @csrf
                                <input type="hidden" id="edit_tugas_id">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="tugas" class="form-label">Tugas</label>
                                        <input type="text" class="form-control" id="edit_tugas" name="tugas" required>
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_teknisi_id" class="form-label">Teknisi</label>
                                        <div class="input-group">
                                            <input type="text" id="edit_teknisi_id" class="form-control" readonly>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-success pilih-teknisi-btn">
                                                    Pilih Teknisi
                                                </button>
                                            </div>
                                        </div>
                                        <input type="hidden" id="edit_teknisi_id_hidden"name="teknisi">
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Customer</label>
                                        {{-- <input type="text" name="user_id" id="edit_user_id" class="form-control"
                                            readonly> --}}
                                        <div class="input-group">
                                            <input type="text" id="edit_user_id" class="form-control" readonly>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-success pilih-customer-btn">
                                                    Pilih Customer
                                                </button>
                                            </div>
                                        </div>
                                        <input type="hidden" id="edit_user_id_hidden" name="user_id">
                                        <span class="error name_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_status" class="form-label">Status</label>
                                        <select class="form-control" id="edit_status" name="status">
                                            <option value="PENDING">PENDING</option>
                                            <option value="PROSES">PROSES</option>
                                            <option value="DONE">DONE</option>
                                        </select>
                                        <span class="text-danger error-text edit_status_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kerusakan" class="form-label">Kerusakan</label>
                                        <input type="text" class="form-control" id="edit_kerusakan" name="kerusakan"
                                            required>
                                        <span class="error name_error"></span>
                                    </div>

                                    {{-- <div class="mb-3">
                                        <label for="kerusakan" class="form-label">Foto</label>
                                        <div id="edit_camera-container" class="camera-container">
                                            <video id="edit_camera" class="camera-video" autoplay playsinline></video>
                                            <div class="camera-controls mt-2">
                                                <button type="button" id="capture-btn" class="btn btn-primary"
                                                    onclick="capturePhotoEdit()">
                                                    <i class="fas fa-camera"></i> Capture Photo
                                                </button>
                                                <button type="button" id="toggle-camera-btn" class="btn btn-secondary"
                                                    onclick="toggleCamera()">
                                                    <i class="fas fa-sync"></i> Switch to Back Camera
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Preview Container -->
                                        <div id="edit_preview-container" class="preview-container"
                                            style="display: none;">
                                            <img id="edit_photo-preview" class="img-fluid mb-2" alt="Captured Photo" />
                                            <input type="hidden" id="edit_photo-data" name="photo" />
                                            <div class="preview-controls">
                                                <button type="button" class="btn btn-secondary"
                                                    onclick="clearPhotoEdit()">
                                                    <i class="fas fa-redo"></i> Take Another Photo
                                                </button>
                                            </div>
                                        </div>

                                        <span class="error name_error"></span>
                                    </div> --}}


                                    <div class="mb-3">
                                        <label class="form-label">Foto</label>
                                        <div id="edit_camera-container"
                                            style="width: 320px; height: 240px; border: 1px solid #ccc; margin-bottom: 10px; position: relative;">
                                            <video id="edit_camera" width="100%" height="100%" autoplay
                                                playsinline></video>
                                        </div>
                                        <div id="edit_preview-container"
                                            style="width: 320px; height: 240px; border: 1px solid #ccc; margin-bottom: 10px; position: relative; display: none;">
                                            <img id="edit_photo-preview" src="" alt="Preview"
                                                style="width: 100%; height: 100%; object-fit: cover;">
                                            <button type="button" class="clear-photo"
                                                style="position: absolute; top: 5px; right: 5px; background: rgba(255,255,255,0.7); border: none; border-radius: 50%; width: 30px; height: 30px; font-size: 18px; cursor: pointer; display: flex; align-items: center; justify-content: center;">&times;</button>
                                        </div>
                                        <div class="camera-actions mt-2">
                                            <button type="button" class="btn btn-secondary btn-sm"
                                                id="edit_start-camera">Start Camera</button>
                                            <button type="button" class="btn btn-primary btn-sm"
                                                id="edit_capture">Capture</button>
                                        </div>
                                        <input type="hidden" id="edit_photo-data" name="foto_data">
                                        <span class="text-danger error-text edit_foto_data_error"></span>
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
                <div id="showModalTugasTeknisi" class="modal fade" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title align-self-center" id="myModalLabel">
                                    Detail Tugas <span id="show-tugas-id"></span> </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form>
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
                                                <td>Tugas</td>
                                                <td>
                                                    <span id="show-tugas"></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Teknisi</td>
                                                <td>
                                                    <span id="show-teknisi"></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Status</td>
                                                <td>
                                                    <span id="show-status"></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Jam & Tanggal</td>
                                                <td> - Pending : <span id="show-pending"></span>
                                                    <br />
                                                    - Proses : <span id="show-proses"></span>
                                                    <br />
                                                    - Done : <span id="show-done"></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Kerusakan</td>
                                                <td>
                                                    <span id="show-kerusakan"></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Foto</td>
                                                <td>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </form>
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
                ajax: "{{ route('tugas-teknisi.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'tugas_id'
                    },
                    {
                        data: 'user.name'
                    },
                    {
                        data: 'tugas'
                    },
                    {
                        data: 'teknisi.name'
                    },
                    // {
                    //     data: 'status'
                    // },
                    {
                        data: null,
                        className: "text-center",
                        mRender: function(data, type, full) {
                            if (data.status == "PENDING") {
                                return '<span class="badge bg-warning">PENDING</span>';
                            }
                            if (data.status == "PROSES") {
                                return '<span class="badge bg-primary">PROSES</span>';
                            }
                            if (data.status == "DONE") {
                                return '<span class="badge bg-success">DONE</span>';
                            }
                        }
                    },
                    {
                        data: 'kerusakan'
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

            // Add Tugas Teknisi
            $('#addTugasTeknisiForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('tugas-teknisi.store') }}",
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
                            $('#addTugasTeknisiForm')[0].reset();
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
            // Definisikan variabel global untuk stream kamera
            let streamEdit = null;

            // Function untuk mengelola kamera pada modal edit
            function startCameraEdit() {
                // Pastikan elemen video sudah tersedia
                const videoElement = document.getElementById('edit_camera');

                if (!videoElement) {
                    //console.error("Video element 'edit_camera' not found");
                    Swal.fire({
                        title: 'Error!',
                        text: 'Elemen video tidak ditemukan',
                        icon: 'error'
                    });
                    return;
                }

                // Hentikan stream yang sedang berjalan jika ada
                if (streamEdit) {
                    stopCameraEdit();
                }

                // Konfigurasi untuk video dari kamera
                const constraints = {
                    video: {
                        width: {
                            ideal: 320
                        },
                        height: {
                            ideal: 240
                        },
                        facingMode: "user" // Gunakan kamera depan
                    },
                    audio: false
                };

                // Debug Info
                //console.log("Requesting camera access...");

                // Coba akses kamera dengan error handling yang lebih baik
                navigator.mediaDevices.getUserMedia(constraints)
                    .then(function(videoStream) {
                        //console.log("Camera access granted");
                        streamEdit = videoStream;

                        // Tampilkan video stream
                        videoElement.srcObject = streamEdit;
                        videoElement.onloadedmetadata = function(e) {
                            // console.log("Video metadata loaded");
                            videoElement.play();
                        };
                    })
                    .catch(function(error) {
                        //console.error("Error accessing camera:", error);
                        let errorMessage = "Tidak dapat mengakses kamera: ";

                        switch (error.name) {
                            case 'NotFoundError':
                            case 'DevicesNotFoundError':
                                errorMessage += 'Kamera tidak ditemukan.';
                                break;
                            case 'NotAllowedError':
                            case 'PermissionDeniedError':
                                errorMessage += 'Izin kamera ditolak.';
                                break;
                            case 'NotReadableError':
                            case 'TrackStartError':
                                errorMessage += 'Kamera sedang digunakan aplikasi lain.';
                                break;
                            case 'OverconstrainedError':
                            case 'ConstraintNotSatisfiedError':
                                errorMessage += 'Kamera tidak memenuhi persyaratan yang diminta.';
                                break;
                            default:
                                errorMessage += error.message;
                        }

                        Swal.fire({
                            title: 'Error!',
                            text: errorMessage,
                            icon: 'error'
                        });
                    });

                $('#edit_camera-container').show();
                $('#edit_preview-container').hide();
            }

            function stopCameraEdit() {
                if (streamEdit) {
                    streamEdit.getTracks().forEach(track => track.stop());
                    streamEdit = null;
                }
            }

            function capturePhotoEdit() {
                const video = document.getElementById('edit_camera');

                // Validasi yang lebih baik
                if (!streamEdit || !video.srcObject) {
                    //console.error("Camera stream not available");
                    Swal.fire({
                        title: 'Error!',
                        text: 'Kamera tidak aktif. Silakan klik "Start Camera" terlebih dahulu.',
                        icon: 'error'
                    });
                    return;
                }

                try {
                    // Pastikan video sedang berjalan dan memiliki dimensi
                    if (video.readyState !== 4 || video.videoWidth === 0 || video.videoHeight === 0) {
                        //console.error("Video not ready yet");
                        Swal.fire({
                            title: 'Error!',
                            text: 'Video belum siap. Tunggu sebentar.',
                            icon: 'error'
                        });
                        return;
                    }

                    //console.log("Capturing photo...");
                    //console.log("Video dimensions:", video.videoWidth, "x", video.videoHeight);

                    const canvas = document.createElement('canvas');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;

                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                    const dataURL = canvas.toDataURL('image/png');
                    $('#edit_photo-data').val(dataURL);

                    $('#edit_photo-preview').attr('src', dataURL);
                    $('#edit_camera-container').hide();
                    $('#edit_preview-container').show();

                    stopCameraEdit();
                    //console.log("Photo captured successfully");
                } catch (error) {
                    // console.error("Error capturing photo:", error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Gagal mengambil foto: ' + error.message,
                        icon: 'error'
                    });
                }
            }

            function clearPhotoEdit() {
                $('#edit_photo-data').val('');
                $('#edit_photo-preview').attr('src', '');
                $('#edit_camera-container').show();
                $('#edit_preview-container').hide();

                startCameraEdit();
            }

            function resetModalState() {
                // Reset form errors
                $('.error-text').text('');

                // Reset camera
                stopCameraEdit();
                $('#edit_photo-data').val('');
                $('#edit_camera-container').show();
                $('#edit_preview-container').hide();

                startCameraEdit();
            }

            $(document).ready(function() {
                // Tambahkan deteksi dukungan getUserMedia
                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    //console.warn('Browser tidak mendukung getUserMedia API');
                    $('#edit_start-camera').prop('disabled', true).attr('title',
                        'Browser Anda tidak mendukung akses kamera');
                } else {
                    // Auto-start camera when document is ready and modal is shown
                    $(document).on('shown.bs.modal', '#editModalTugasTeknisi', function() {
                        startCameraEdit();
                    });

                    // Stop camera when modal is hidden
                    $(document).on('hidden.bs.modal', '#editModalTugasTeknisi', function() {
                        stopCameraEdit();
                    });
                }
            });


            // let streamEdit = null;
            // let currentFacingMode = "user"; // Start with front camera by default

            // // Function untuk mengelola kamera pada modal edit
            // function startCameraEdit() {
            //     // Pastikan elemen video sudah tersedia
            //     const videoElement = document.getElementById('edit_camera');

            //     if (!videoElement) {
            //         Swal.fire({
            //             title: 'Error!',
            //             text: 'Elemen video tidak ditemukan',
            //             icon: 'error'
            //         });
            //         return;
            //     }

            //     // Hentikan stream yang sedang berjalan jika ada
            //     if (streamEdit) {
            //         stopCameraEdit();
            //     }

            //     // Konfigurasi untuk video dari kamera dengan facing mode dinamis
            //     const constraints = {
            //         video: {
            //             width: {
            //                 ideal: 320
            //             },
            //             height: {
            //                 ideal: 240
            //             },
            //             facingMode: currentFacingMode // Gunakan mode kamera yang aktif
            //         },
            //         audio: false
            //     };

            //     // Coba akses kamera dengan error handling yang lebih baik
            //     navigator.mediaDevices.getUserMedia(constraints)
            //         .then(function(videoStream) {
            //             streamEdit = videoStream;

            //             // Tampilkan video stream
            //             videoElement.srcObject = streamEdit;
            //             videoElement.onloadedmetadata = function(e) {
            //                 videoElement.play();
            //             };
            //         })
            //         .catch(function(error) {
            //             let errorMessage = "Tidak dapat mengakses kamera: ";

            //             switch (error.name) {
            //                 case 'NotFoundError':
            //                 case 'DevicesNotFoundError':
            //                     errorMessage += 'Kamera tidak ditemukan.';
            //                     break;
            //                 case 'NotAllowedError':
            //                 case 'PermissionDeniedError':
            //                     errorMessage += 'Izin kamera ditolak.';
            //                     break;
            //                 case 'NotReadableError':
            //                 case 'TrackStartError':
            //                     errorMessage += 'Kamera sedang digunakan aplikasi lain.';
            //                     break;
            //                 case 'OverconstrainedError':
            //                 case 'ConstraintNotSatisfiedError':
            //                     errorMessage += 'Kamera tidak memenuhi persyaratan yang diminta.';
            //                     break;
            //                 default:
            //                     errorMessage += error.message;
            //             }

            //             Swal.fire({
            //                 title: 'Error!',
            //                 text: errorMessage,
            //                 icon: 'error'
            //             });
            //         });

            //     $('#edit_camera-container').show();
            //     $('#edit_preview-container').hide();
            // }

            // // Function untuk mengganti kamera depan dan belakang
            // function toggleCamera() {
            //     // Switch the facing mode
            //     currentFacingMode = currentFacingMode === "user" ? "environment" : "user";

            //     // Update button text
            //     $("#toggle-camera-btn").text(currentFacingMode === "user" ? "Switch to Back Camera" :
            //         "Switch to Front Camera");

            //     // Restart camera with new facing mode
            //     startCameraEdit();
            // }

            // function stopCameraEdit() {
            //     if (streamEdit) {
            //         streamEdit.getTracks().forEach(track => track.stop());
            //         streamEdit = null;
            //     }
            // }

            // function capturePhotoEdit() {
            //     const video = document.getElementById('edit_camera');

            //     // Validasi yang lebih baik
            //     if (!streamEdit || !video.srcObject) {
            //         Swal.fire({
            //             title: 'Error!',
            //             text: 'Kamera tidak aktif. Silakan klik "Start Camera" terlebih dahulu.',
            //             icon: 'error'
            //         });
            //         return;
            //     }

            //     try {
            //         // Pastikan video sedang berjalan dan memiliki dimensi
            //         if (video.readyState !== 4 || video.videoWidth === 0 || video.videoHeight === 0) {
            //             Swal.fire({
            //                 title: 'Error!',
            //                 text: 'Video belum siap. Tunggu sebentar.',
            //                 icon: 'error'
            //             });
            //             return;
            //         }

            //         const canvas = document.createElement('canvas');
            //         canvas.width = video.videoWidth;
            //         canvas.height = video.videoHeight;

            //         const ctx = canvas.getContext('2d');
            //         ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            //         const dataURL = canvas.toDataURL('image/png');
            //         $('#edit_photo-data').val(dataURL);

            //         $('#edit_photo-preview').attr('src', dataURL);
            //         $('#edit_camera-container').hide();
            //         $('#edit_preview-container').show();

            //         stopCameraEdit();
            //     } catch (error) {
            //         Swal.fire({
            //             title: 'Error!',
            //             text: 'Gagal mengambil foto: ' + error.message,
            //             icon: 'error'
            //         });
            //     }
            // }

            // function clearPhotoEdit() {
            //     $('#edit_photo-data').val('');
            //     $('#edit_photo-preview').attr('src', '');
            //     $('#edit_camera-container').show();
            //     $('#edit_preview-container').hide();

            //     // Auto-start camera when clearing photo
            //     startCameraEdit();
            // }

            // function resetModalState() {
            //     // Reset form errors
            //     $('.error-text').text('');

            //     // Reset camera
            //     stopCameraEdit();
            //     $('#edit_photo-data').val('');
            //     $('#edit_camera-container').show();
            //     $('#edit_preview-container').hide();

            //     // Reset to front camera as default
            //     currentFacingMode = "user";

            //     // Update button text if exists
            //     if ($("#toggle-camera-btn").length) {
            //         $("#toggle-camera-btn").text("Switch to Back Camera");
            //     }

            //     // Auto-start camera when resetting modal
            //     startCameraEdit();
            // }

            // // Document ready function - setup event handlers
            // $(document).ready(function() {
            //     // Tambahkan deteksi dukungan getUserMedia
            //     if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            //         $('#edit_start-camera').prop('disabled', true).attr('title',
            //             'Browser Anda tidak mendukung akses kamera');

            //         // Disable toggle button as well if it exists
            //         $('#toggle-camera-btn').prop('disabled', true).attr('title',
            //             'Browser Anda tidak mendukung akses kamera');

            //         Swal.fire({
            //             title: 'Warning!',
            //             text: 'Browser Anda tidak mendukung akses kamera',
            //             icon: 'warning'
            //         });
            //     } else {
            //         // Auto-start camera when document is ready and modal is shown
            //         $(document).on('shown.bs.modal', '#editModalTugasTeknisi', function() {
            //             startCameraEdit();
            //         });

            //         // Stop camera when modal is hidden
            //         $(document).on('hidden.bs.modal', '#editModalTugasTeknisi', function() {
            //             stopCameraEdit();
            //         });
            //     }
            // });


            // Edit Data Tugas Teknisi
            $(document).on('click', '.edit-tugas-teknisi', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: "/dashboard/tugas-teknisi/" + id + "/edit",
                    type: "GET",
                    success: function(response) {
                        if (response.status == 404) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message
                            });
                        } else {
                            // Reset foto preview dan camera state
                            stopCameraEdit();
                            // Isi form dengan data yang ada
                            $('#edit_camera-container').show();
                            $('#edit_preview-container').hide();

                            // Isi form dengan data yang ada
                            $('#edit_tugas_id').val(response.tugas.id);
                            $('#edit_tugas_kode').text(response.tugas.tugas_id);
                            $('#edit_teknisi_id').val(response.tugas.teknisi.name);
                            $('#edit_teknisi_id_hidden').val(response.tugas.teknisi.id);
                            $('#edit_user_id').val(response.tugas.user
                                .name);
                            $('#edit_user_id_hidden').val(response.tugas.user.id);
                            $('#edit_tugas').val(response.tugas.tugas);
                            $('#edit_status').val(response.tugas.status);
                            $('#edit_pending').val(response.tugas.pending);
                            $('#edit_proses').val(response.tugas.proses);
                            $('#edit_done').val(response.tugas.done);
                            $('#edit_kerusakan').val(response.tugas.kerusakan);

                            // Jika ada foto, tampilkan di preview
                            if (response.tugas.foto) {
                                $('#edit_photo-preview').attr('src', '/storage/' +
                                    response.tugas.foto);
                                $('#edit_camera-container').hide();
                                $('#edit_preview-container').show();
                            }

                            $('#editModalTugasTeknisi').modal('show');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat mengambil data'
                        });
                    }
                });
            });

            // Handler untuk tombol "Pilih Teknisi"
            $(document).on('click', '.pilih-teknisi-btn', function() {
                // Ambil data teknisi via AJAX
                $.ajax({
                    url: "/dashboard/teknisi/get-all",
                    type: "GET",
                    dataType: "json",
                    success: function(technicians) {
                        // Siapkan HTML untuk dropdown
                        let optionsHtml = '';
                        technicians.forEach(teknisi => {
                            optionsHtml +=
                                `<option value="${teknisi.id}">${teknisi.name}</option>`;
                        });

                        // Tampilkan SweetAlert dengan dropdown
                        Swal.fire({
                            title: 'Pilih Teknisi',
                            html: `
                        <select id="teknisi-dropdown" class="form-control">
                            <option value="">-- Pilih Teknisi --</option>
                            ${optionsHtml}
                        </select>
                    `,
                            showCancelButton: true,
                            confirmButtonText: 'Pilih',
                            cancelButtonText: 'Batal',
                            preConfirm: () => {
                                const teknisiId = document
                                    .getElementById('teknisi-dropdown')
                                    .value;
                                if (!teknisiId) {
                                    Swal.showValidationMessage(
                                        'Silakan pilih teknisi');
                                    return false;
                                }
                                return teknisiId;
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const teknisiId = result.value;

                                // Fetch data teknisi berdasarkan ID
                                $.ajax({
                                    url: `/dashboard/teknisi/${teknisiId}`,
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(data) {
                                        // Isi form dengan data teknisi yang dipilih
                                        $('#edit_teknisi_id')
                                            .val(data.name);
                                        $('#edit_teknisi_id_hidden')
                                            .val(data.id);

                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Teknisi terpilih',
                                            text: `Anda telah memilih ${data.name}`,
                                            timer: 1500
                                        });
                                    },
                                    error: function(xhr) {
                                        console.error(xhr
                                            .responseText);
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Terjadi kesalahan',
                                            text: 'Gagal mengambil data teknisi'
                                        });
                                    }
                                });
                            }
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Gagal mengambil daftar teknisi'
                        });
                    }
                });
            });

            // Handler untuk tombol "Pilih Customer"
            $(document).on('click', '.pilih-customer-btn', function() {
                // Ambil data customer via AJAX
                $.ajax({
                    url: "/dashboard/customers/get-all",
                    type: "GET",
                    dataType: "json",
                    success: function(customers) {
                        // Siapkan HTML untuk dropdown
                        let optionsHtml = '';
                        customers.forEach(customer => {
                            optionsHtml +=
                                `<option value="${customer.id}">${customer.name}</option>`;
                        });

                        // Tampilkan SweetAlert dengan dropdown
                        Swal.fire({
                            title: 'Pilih Customer',
                            html: `
                        <select id="customer-dropdown" class="form-control">
                            <option value="">-- Pilih Customer --</option>
                            ${optionsHtml}
                        </select>
                    `,
                            showCancelButton: true,
                            confirmButtonText: 'Pilih',
                            cancelButtonText: 'Batal',
                            preConfirm: () => {
                                const customerId = document.getElementById(
                                    'customer-dropdown').value;
                                if (!customerId) {
                                    Swal.showValidationMessage(
                                        'Silakan pilih customer');
                                    return false;
                                }
                                return customerId;
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const customerId = result.value;

                                // Fetch data customer berdasarkan ID
                                $.ajax({
                                    url: `/dashboard/customers/${customerId}`,
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(data) {
                                        // Isi form dengan data customer yang dipilih
                                        $('#edit_user_id').val(data.name);
                                        $('#edit_user_id_hidden').val(data
                                            .id);

                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Customer terpilih',
                                            text: `Anda telah memilih ${data.name}`,
                                            timer: 1500
                                        });
                                    },
                                    error: function(xhr) {
                                        console.error(xhr.responseText);
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Terjadi kesalahan',
                                            text: 'Gagal mengambil data customer'
                                        });
                                    }
                                });
                            }
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Gagal mengambil daftar customer'
                        });
                    }
                });
            });

            // Update Data Tugas Teknisi
            $('#editTugasTeknisiForm').on('submit', function(e) {
                e.preventDefault();
                var id = $('#edit_tugas_id').val();

                // Ambil data foto jika ada
                var photoData = $('#edit_photo-data').val();

                // Siapkan form data
                var formData = new FormData(this);

                // Tambahkan photo data jika ada
                if (photoData) {
                    formData.append('foto_data', photoData);
                }

                $.ajax({
                    url: "/dashboard/tugas-teknisi/" + id,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-HTTP-Method-Override': 'PUT',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status == 422) {
                            $.each(response.errors, function(key, err_value) {
                                $('.edit_' + key + '_error').text(err_value[
                                    0]);
                            });
                        } else if (response.status == 404) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message
                            });
                        } else {
                            // Reset modal dan reload tabel
                            resetModalState();
                            $('#editModalTugasTeknisi').modal('hide');
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
                        console.error(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat menyimpan data'
                        });
                    }
                });
            });

            // Fungsi untuk kamera pada modal edit
            $('#edit_start-camera').on('click', function() {
                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Browser Anda tidak mendukung akses kamera.',
                        icon: 'error'
                    });
                    return;
                }
                startCameraEdit();
            });

            $('#edit_capture').on('click', function() {
                capturePhotoEdit();
            });

            $('.clear-photo').on('click', function() {
                clearPhotoEdit();
            });

            // Tunggu modal selesai ditampilkan sebelum mengaktifkan kamera
            $('#editModalTugasTeknisi').on('shown.bs.modal', function() {
                // Tunggu sebentar agar modal benar-benar ditampilkan sebelum mengakses kamera
                setTimeout(function() {
                    if ($('#edit_preview-container').css('display') === 'none') {
                        // Hanya aktifkan tombol kamera jika preview tidak ditampilkan
                        $('#edit_start-camera').prop('disabled', false);
                    }
                }, 500);
            });

            // Bersihkan kamera saat modal ditutup
            $('#editModalTugasTeknisi').on('hidden.bs.modal', function() {
                stopCameraEdit();
            });

            // Delete Data Paket
            $(document).on('click', '.delete-tugas-teknisi', function() {
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
                            url: "/dashboard/tugas-teknisi/" + id,
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
            //Show Tugas Teknisi
            $(document).on('click', '.show-tugas-teknisi', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: "/dashboard/tugas-teknisi/" + id,
                    type: "GET",
                    success: function(response) {
                        if (response.status == 404) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message
                            });
                        } else {
                            $('#show-tugas-id').text(response.tugas.tugas_id);
                            $('#show-teknisi').text(response.tugas.teknisi.name);
                            $('#show-tugas').text(response.tugas.tugas);
                            $('#show-status').text(response.tugas.status);
                            $('#show-pending').text(response.tugas.pending);
                            $('#show-proses').text(response.tugas.proses);
                            $('#show-done').text(response.tugas.done);
                            $('#show-kerusakan').text(response.tugas.kerusakan);


                            var fotoCell = $('tr:contains("Foto") td:last-child');
                            fotoCell.empty();

                            // Handle photo path
                            if (response.tugas.foto) {
                                var photoTable = $(
                                    '<table class="table table-bordered mb-0"></table>');
                                var photoRow = $('<tr></tr>');
                                var photoCell = $('<td class="text-center"></td>');

                                // Correct the path - assuming your storage is linked to public/storage
                                var photoPath = response.tugas.foto;
                                // If path doesn't start with http or slash, add the storage path
                                if (!photoPath.startsWith('http') && !photoPath.startsWith(
                                        '/')) {
                                    photoPath = '/storage/' + photoPath;
                                }
                                // If path starts with 'tugas/' directly, add storage prefix
                                else if (photoPath.startsWith('tugas/')) {
                                    photoPath = '/storage/' + photoPath;
                                }

                                var photoImg = $('<img src="' + photoPath +
                                    '" alt="Foto" style="max-width: 300px; max-height: 200px;">'
                                );

                                photoCell.append(photoImg);
                                photoRow.append(photoCell);
                                photoTable.append(photoRow);
                                fotoCell.append(photoTable);

                                // Log the image path to console for debugging
                                ///console.log("Trying to load image from:", photoPath);
                            } else {
                                // No photos available
                                fotoCell.text('Tidak ada foto');
                            }

                            $('#showModalTugasTeknisi').modal('show');
                        }
                    }
                });
            });
        });
    </script>
@endpush
