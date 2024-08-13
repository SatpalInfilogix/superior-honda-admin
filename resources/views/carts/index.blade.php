@extends('layouts.app')

@section('content')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Carts</h5>
                                    <div class="float-right">

                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="cart-list" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone Number</th>
                                                    <th>Cart Products</th>
                                                    <th>Wishlist Products</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $key => $user)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $user->first_name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->phone_number }}</td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                <button type="button"
                                                                    class="btn btn-primary primary-btn waves-effect waves-light mr-2"
                                                                    data-toggle="modal"
                                                                    data-target="#cartModal{{ $key }}">
                                                                    <i class="feather icon-eye m-0"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                <button type="button"
                                                                    class="btn btn-primary primary-btn waves-effect waves-light mr-2"
                                                                    data-toggle="modal"
                                                                    data-target="#wishlistModal{{ $key }}">
                                                                    <i class="feather icon-eye m-0"></i>
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

    <!-- Cart Modals -->
    @foreach ($users as $key => $user)
    <?php
        // echo"<pre>"; print_R($user); die();
    ?>
        <div class="modal fade" id="cartModal{{ $key }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cart Products</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $cartProducts = json_decode(optional($user->carts)->cart);
                                @endphp
                                @if($cartProducts)
                                    @foreach ($cartProducts->products as $key => $product)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->quantity }}</td>
                                            <td>{{ '$' . number_format($product->price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                @else 
                                    <tr>
                                        <td colspan="4" class="text-center">Cart is empty</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Wishlist Modals -->
    @foreach ($users as $key => $user)
        <div class="modal fade" id="wishlistModal{{ $key }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Wishlist Products</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($user->wishlists) > 0)
                                    @foreach ($user->wishlists as $key => $wishlist)
                                        @if ($wishlist->products)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ optional($wishlist->products)->product_name }}</td>
                                                <td>{{ '$' . number_format( optional($wishlist->products)->cost_price, 2) }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @else 
                                    <tr>
                                        <td colspan="4" class="text-center">Wishlist is empty</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        $(function() {
            $('#cart-list').DataTable();
        })
    </script>
@endsection
