@extends('layouts.master')

@section('title')
    Tambah Users
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"> Tambah Users</li>
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
                    <form class="custom-validation" action="{{ route('users.store') }}" method="POST">
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
                            <label class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required
                                placeholder="Password" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="roles[]" class="form-select" multiple>
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role }}">{{ $role }}</option>
                                @endforeach
                            </select>
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
