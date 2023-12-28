@extends('layout')
@section('content')
    <div class="row">
        <div class="col-md-12"><h3>Add new Product</h3></div>
        <div class="col-md-2">&nbsp;</div>
        <div class="col-md-8">
            <form action="{{ route('addProduct') }}" method="post" enctype="multipart/form-data">@csrf
                Name: <input name="productName" type="text" class="form-control" /><br>
                Description: <input name="description" type="text" class="form-control" /><br>
                Price: <input name="price" type="number" class="form-control" /><br>
                Quantity: <input name="quantity" type="number" class="form-control" /><br>
                Image: <input name="product-image" type="file" class="form-control" /><br>
                Category ID: <input name="categoryID" type="text" class="form-control" /><br>
                <button class="btn btn-info" type="submit">Add Product</button>
            </form>
        </div>
        <div class="col-md-2">&nbsp;</div>
    </div>
@endsection