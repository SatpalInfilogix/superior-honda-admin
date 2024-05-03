@extends('layouts.app')

@section('content')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="card">
                                <div class="card-header">
                                    <h5>Roles & Permissions</h5>
                                </div>
                                <div class="card-block">
                                    <div class="roles-and-permissions">
                                        <a class="accordion-msg b-none waves-effect waves-light">Lorem Message 1</a>
                                        <div class="accordion-desc p-0 b-default">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Module Name</th>
                                                        <th>View</th>
                                                        <th>Add</th>
                                                        <th>Update</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>Mark</td>
                                                        <td>Otto</td>
                                                        <td>@mdo</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">2</th>
                                                        <td>Jacob</td>
                                                        <td>Thornton</td>
                                                        <td>@fat</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">3</th>
                                                        <td>Larry</td>
                                                        <td>the Bird</td>
                                                        <td>@twitter</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <a class="accordion-msg b-none waves-effect waves-light">Lorem
                                            Message
                                            2</a>
                                        <div class="accordion-desc">
                                            <p>
                                                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                                Lorem Ipsum has been the industry's standard dummy text ever since the
                                                1500s, when an unknown printer took a galley of type and scrambled it to
                                                make a type specimen book. It has
                                                survived not only five centuries, but also the leap into electronic
                                                typesetting, remaining essentially unchanged. It was popularised in the
                                                1960s with the release of Letraset sheets containing
                                                Lorem Ipsum passages, and more .
                                            </p>
                                        </div>
                                        <a class="accordion-msg b-none waves-effect waves-light">Lorem
                                            Message
                                            3</a>
                                        <div class="accordion-desc">
                                            <p>
                                                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                                Lorem Ipsum has been the industry's standard dummy text ever since the
                                                1500s, when an unknown printer took a galley of type and scrambled it to
                                                make a type specimen book. It has
                                                survived not only five centuries, but also the leap into electronic
                                                typesetting, remaining essentially unchanged. It was popularised in the
                                                1960s with the release of Letraset sheets containing
                                                Lorem Ipsum passages, and more .
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            var icons = {
                header: "fas fa-up-arrow",
                activeHeader: "fas fa-down-arrow"
            };

            $(".roles-and-permissions").accordion({
                heightStyle: "content",
                icons: icons
            });
        })
    </script>
@endsection
