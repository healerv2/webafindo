@extends('layouts.master')

@section('title')
    Add Permission Role
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"> Add Permission Role</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Role : {{ $role->name }}</h5>
                    <div class="general-label">
                        <form class="custom-validation" action="{{ route('give.permission.role', $role->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-0 row">
                                @foreach ($permissions as $permission)
                                    <div class="col-md-12">
                                        <label>
                                            <input type="checkbox" class="form-check-input" name="permission[]"
                                                value="{{ $permission->name }}"
                                                {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }} />
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <p></p>
                            <!--end row-->
                            <div class="mb-0 row">
                                <div>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light"><i
                                            class="fas fa-save"></i>
                                        Save
                                    </button>
                                    <a class="btn btn-danger waves-effect ms-1" href="{{ route('roles.index') }}"><i
                                            class="fas fa-undo-alt"></i> Cancel</a>
                                </div>
                            </div>
                        </form>
                        <!-- end form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection
