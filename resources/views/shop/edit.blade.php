@extends('layout.app')
@section('title',"Edit Shop")

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-8" style="margin: 0 auto;">
                <h2>Edit Shop</h2>
                <form action="{{route('shop.update',$shop->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{method_field("PATCH")}}
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" value="{{$shop->name}}">
                        @if($errors->first('name'))
                            <label class="text-danger text-bold">{{$errors->first('name')}}</label>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email" value="{{$shop->email}}">
                        @if($errors->first('email'))
                            <label class="text-danger text-bold">{{$errors->first('email')}}</label>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <textarea  class="form-control" id="address"  name="address">{{$shop->address}}</textarea>
                        @if($errors->first('address'))
                            <label class="text-danger text-bold">{{$errors->first('address')}}</label>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="image">Image:</label>
                        <input type="file" class="form-control" id="image"  name="image">
                        @if($errors->first('image'))
                            <label class="text-danger text-bold">{{$errors->first('image')}}</label>
                        @endif
                    </div>
                    <div class="form-group">
                        <img src="{{asset('storage/uploads/shop/'.$shop->image)}}" width="100px">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{route('shop.index')}}" class="btn badge-danger">Cancle</a>
                </form>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
        } );
    </script>
@endsection