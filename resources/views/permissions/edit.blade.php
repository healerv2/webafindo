@extends('layouts.master')

@section('title')
    Edit Permissions
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"> Edit Permissions</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form class="custom-validation"
                        action="{{ route('permissions.update', encrypt(['id' => $permission->id])) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Nama Permissions</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ $permission->name }}" required placeholder="Nama Permissions" />
                        </div>
                        <div class="mb-0">
                            <div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light"><i
                                        class="fas fa-save"></i>
                                    Save
                                </button>
                                <a class="btn btn-danger waves-effect ms-1" href="{{ route('permissions.index') }}"><i
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
