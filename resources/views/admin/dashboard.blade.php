@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="row">
        <!-- end col -->
        <div class="col-sm-6 col-xl-3">
            <div class="card card-content">
                <div class="card-body border-bottom">
                    <div class="">
                        <div class="row align-items-center">
                            <div class="col-4">
                                <div class="overview-content">
                                    <i class="mdi mdi-account-box-multiple-outline text-primary"></i>
                                </div>
                            </div>
                            <div class="col-8 text-end">
                                <p class="text-muted font-size-13 mb-1">Members</p>
                                <h4 class="mb-0 font-size-20">90909</h4>
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
        <div class="col-sm-6 col-xl-3">
            <div class="card card-content">
                <div class="card-body border-bottom">
                    <div class="">
                        <div class="row align-items-center">
                            <div class="col-4">
                                <div class="overview-content">
                                    <i class="mdi  mdi-trophy text-warning"></i>
                                </div>
                            </div>
                            <div class="col-8 text-end">
                                <p class="text-muted font-size-13 mb-1">Total Point</p>
                                <h4 class="mb-0 font-size-20">0909090</h4>
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection
