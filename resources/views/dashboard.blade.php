@extends('layouts.app')

@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="feather icon-watch bg-c-blue"></i>
                    <div class="d-inline">
                        <h5>Sample page</h5>
                        <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="index.html"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#!">Sample page</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Hello card</h5>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li class="first-opt"><i class="feather icon-chevron-left open-card-option"></i>
                                            </li>
                                            <li><i class="feather icon-maximize full-card"></i>
                                            </li>
                                            <li><i class="feather icon-minus minimize-card"></i>
                                            </li>
                                            <li><i class="feather icon-refresh-cw reload-card"></i>
                                            </li>
                                            <li><i class="feather icon-trash close-card"></i></li>
                                            <li><i class="feather icon-chevron-left open-card-option"></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <p>
                                        "Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                                        sed do eiusmod tempor incididunt ut labore et dolore magna
                                        aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                                        ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                        Duis aute irure dolor
                                        in reprehenderit in voluptate velit esse cillum dolore eu
                                        fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                        proident, sunt in culpa qui officia deserunt mollit anim id
                                        est laborum."
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
