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
                                    <h5>Edit Vehicle Category</h5>
                                    <div class="float-right">
                                        <a href="{{ route('vehicle-categories.index') }}" class="btn btn-primary btn-md">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <form action="{{ route('vehicle-categories.update', $vehicle_category->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <label for="category-name">Category Name</label>
                                            <input type="text" class="form-control" name="name" id="category-name" value="{{ $vehicle_category->name }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection