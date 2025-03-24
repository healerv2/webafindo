@extends('layouts.master')

@section('title')
    Permissions
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Permissions</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <a href="{{ route('permissions.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus-circle"></i>
                        Tambah
                    </a>
                    <p></p>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <th>No</th>
                                <th>Nama</th>
                                <th width="15%"><i class="fa fa-cog"></i></th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->
@endsection

@push('scripts')
    <script>
        let table;

        $(function() {
            table = $('.table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('permissions.index') }}',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false
                    },
                ]
            });
        });

        function deleteData(url) {
            if (confirm('Anda yakin akan menghapus data ini?')) {
                $.post(url, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'delete'
                    })
                    .done((response) => {
                        table.ajax.reload();
                        if (response.success) {
                            return toastr.success(response.message, toastr.options = {
                                "closeButton": true,
                                "progressBar": true
                            })
                        }
                        return toastr.error(response.message, toastr.options = {
                            "closeButton": true,
                            "progressBar": true
                        })
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menghapus data');
                        return;
                    });
            }
        }
    </script>
@endpush
