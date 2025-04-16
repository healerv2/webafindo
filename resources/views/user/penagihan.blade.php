@extends('layouts.master')

@section('title')
    Tambah Users Penagihan
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"> Tambah Penagihan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-xl-12">
            @if ($errors->any())
                <ul class="alert alert-warning">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <div class="card">
                <div class="card-body">
                    <form class="custom-validation" action="{{ route('users.penagihan_add') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" id="name" class="form-control" required
                                placeholder="Nama" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <div>
                                <input type="email" name="email" id="email" class="form-control" required
                                    placeholder="Email" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="areas" class="form-label">Areas</label>
                            <select class="select2 mb-3 select2-multiple" id="areas" name="areas[]" multiple>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}">{{ $area->nama_area }} </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">You can select multiple areas for this user</small>
                        </div>
                        <div class="mb-0">
                            <div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light"><i
                                        class="fas fa-save"></i>
                                    Save
                                </button>
                                <a class="btn btn-danger waves-effect ms-1" href="{{ route('users.index') }}"><i
                                        class="fas fa-undo-alt"></i> Cancel</a>
                            </div>
                        </div>
                    </form>
                    <!-- end form -->
                </div>
                <!-- end cardbody -->
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
