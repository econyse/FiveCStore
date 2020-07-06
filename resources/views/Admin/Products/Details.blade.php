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
                <h1>Product Details</h1>
                <div class="card">
                    <input type="hidden" name="productid" id="productid">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->product_name }}</h5>
                        <p class="card-text">
                            <b>Description:</b> {{ $product->description }}
                            <br>
                        </p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <b>Price: </b>${{ $product->price." ".$product->currency}}
                        </li>
                        <li class="list-group-item "><b>Category: </b>{{ $product->category_id }}</li>
                    </ul>
                    <div class="card-body">
                        <a href="/admin/products/edit/{{ $product->_id }}" class="card-link">Edit</a>
                        <a href="/admin/products/delete/{{ $product->_id }}" class="card-link">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
