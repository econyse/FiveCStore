@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="card col-md-12">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->product_name }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">${{ $product->price." ".$product->currency}}</h6>
                    <p class="card-text">{{ $product->description }}</p>
                </div>
                <div class="card-footer">
                    <p>Rating: </p>
                    <input type="radio" name="rating" id="rating">
                    <input type="radio" name="rating" id="rating">
                    <input type="radio" name="rating" id="rating">
                    <input type="radio" name="rating" id="rating">
                    <input type="radio" name="rating" id="rating">
                </div>
            </div>
            <div class="col-md-12">
                <h1>Add a Comment</h1>
                <form action="{{ route('ProductComment') }}" method="POST">
                    @csrf
                    <input type="hidden" name="productid" id="productid" value="{{ $product->_id->__toString() }}">
                    <div class="form-group">
                        <label for="userid">User ID</label>
                        <input class="form-control" type="text" name="userid" id="userid">
                    </div>
                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <textarea class="form-control" name="comment" id="comment" cols="30" rows="4"></textarea>
                    </div>
                    <button class="btn btn-primary" type="submit">Add comment</button>
                </form>
            </div>
            <div class="col-md-12">
                <h1>User comments</h1>
                @if (count($product->comments) == 0 || $product->comments == null || empty($product->comments) )
                        <h1>No comments yet.</h1>
                @else
                    @foreach($product->comments as $comment)
                    <div class="card col-md-12">
                        <div class="card-body">
                            <h4 class="card-title">{{ $comment->user_id }}</h4>
                            <p class="card-text">{{ $comment->comment }}</p>
                            <p class="card-text">Date published: {{ $comment->date }} UTC</p>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection