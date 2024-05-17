@extends('layouts.app')

@section('content')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <div class="row">
                        <div class="col-sm-12">
                            @if (session('success'))
                                <x-alert message="{{ session('success') }}"></x-alert>
                            @endif
                            <div class="card">
                                <div class="card-header">
                                    <h5>Coupon/Offers</h5>
                                    <div class="float-right">
                                        <a href="{{ route('coupons.create') }}" class="btn btn-primary btn-md">Add
                                            Coupon</a>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="coupons-list" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Coupon</th>
                                                    <th>Discount Type</th>
                                                    <th>Discount Amount</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($coupons as $key => $coupon)
                                                    <tr>
                                                        <td>{{ ++$key }}</td>
                                                        <td>{{ $coupon->coupon_code }}</td>
                                                        <td>{{ $coupon->discount_type }}</td>
                                                        <td>{{ $coupon->discount_type == 'Percentage' ? $coupon->discount_amount.' %' : '$ '.$coupon->discount_amount }}</td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                <a href="{{ route('coupons.edit', $coupon->id) }}"
                                                                    class="btn btn-primary waves-effect waves-light mr-2">
                                                                    <i class="feather icon-edit m-0"></i>
                                                                </a>

                                                                <button data-source="Coupon"
                                                                    data-endpoint="{{ route('coupons.destroy', $coupon->id) }}"                                                          class="delete-btn btn btn-danger waves-effect waves-light">
                                                                    <i class="feather icon-trash m-0"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-include-plugins dataTable></x-include-plugins>

    <script>
        $(function() {
            $('#coupons-list').DataTable();
        })
    </script>
@endsection