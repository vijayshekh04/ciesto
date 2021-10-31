@extends('layout.app')
@section('title',"Add Product")

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-8" style="margin: 0 auto;">
                <h2>Add Product</h2>
                <form action="{{route('product.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="shop_id">Shop Name:</label>
                        <select class="form-control" id="shop_id"  name="shop_id" >
                            <option value="">Select Shop Name</option>
                            @foreach($shops as $shop)
                                <option value="{{$shop->id}}" @if (old('shop_id') == $shop->id) {{ 'selected' }} @endif>{{$shop->name}}</option>
                            @endforeach
                        </select>
                        @if($errors->first('shop_id'))
                            <label class="text-danger text-bold">{{$errors->first('shop_id')}}</label>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" value="{{old('name')}}">
                        @if($errors->first('name'))
                            <label class="text-danger text-bold">{{$errors->first('name')}}</label>
                        @endif
                        @if(Session::has('product_exists'))
                                <label class="text-danger">{!! Session::get('product_exists') !!}</label>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="text" class="form-control" id="price" placeholder="Enter Price" name="price" value="{{old('price')}}">
                        @if($errors->first('price'))
                            <label class="text-danger text-bold">{{$errors->first('price')}}</label>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="stock">Stock:</label>
                        <input type="text" class="form-control" id="stock" placeholder="Enter Price" name="stock" value="{{old('stock')}}">
                        @if($errors->first('stock'))
                            <label class="text-danger text-bold">{{$errors->first('stock')}}</label>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="video">Video:</label>
                        <input type="file" class="form-control" id="video"  name="video">
                        @if($errors->first('video'))
                            <label class="text-danger text-bold">{{$errors->first('video')}}</label>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{route('product.index')}}" class="btn badge-danger">Cancle</a>
                </form>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
        } );
    </script>
@endsection