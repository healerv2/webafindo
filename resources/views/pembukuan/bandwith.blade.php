@extends('layouts.master')

@section('title')
    Rincian Pengeluaran Bandwith
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Rincian Pengeluaran Bandwith</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-responsive">
                    @can('create pembukuan')
                        <a href="{{ route('pembukuan.index') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus-circle"></i>
                            Tambah Pembukuan
                        </a>
                    @endcan
                    <p>
                    <p>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table1">
                            <thead>
                                <th>No</th>
                                <th>Keterangan</th>
                                <th>Admin</th>
                                <th>Kategori</th>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
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
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#table1').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: "{{ route('pembukuan.bandwith') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'keterangan'
                    },
                    {
                        data: 'admin.name'
                    },
                    {
                        data: 'kategori_pembukuan'
                    },
                    {
                        data: 'jumlah'
                    },
                    {
                        data: 'tanggal'
                    },
                ],
            });

        });
    </script>
@endpush
