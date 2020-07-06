@extends('layouts.app')

@section('content')
    <div class="container">

        @if (session('mssg') !== null)
            <div class="alert alert-{{ session('alerttype')}} alert-dismissible fade show" role="alert">
                {{ session('mssg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <h1>Products</h1>
                <a class="text-right" href="/admin/products/create">Create New Product</a>
            </div>
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Price</th>
                            <th scope="col">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $prod)
                            <tr>
                                <th scope="row">{{ $loop->index + 1 }}</th>
                                <td>{{ $prod["product_name"] }}</td>
                                <td>{{ $prod["description"] }}</td>
                                <td>${{ $prod["price"]." ".$prod["currency"] }}</td>
                                <td>
                                    <a href="/admin/products/{{ $prod['_id'] }}">Details</a> |
                                    <a href="/admin/products/edit/{{ $prod->_id }}">Edit</a> |
                                    <a href="/admin/products/delete/{{ $prod->_id }}">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
