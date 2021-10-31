@extends('layout.app')
@section('title',"Edit Product")

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-8" style="margin: 0 auto;">
                <h2>Edit Product</h2>
                <form action="{{route('product.update',$product->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{method_field("PATCH")}}
                    <div class="form-group">
                        <label for="shop_id">Shop Name:</label>
                        <select class="form-control" id="shop_id"  name="shop_id" >
                            <option value="">Select Shop Name</option>
                            @foreach($shops as $shop)
                                <option value="{{$shop->id}}" @if ($product->shop_id == $shop->id) {{ 'selected' }} @endif>{{$shop->name}}</option>
                            @endforeach
                        </select>
                        @if($errors->first('shop_id'))
                            <label class="text-danger text-bold">{{$errors->first('shop_id')}}</label>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" value="{{$product->name}}">
                        <input type="hidden" id="old_name" name="old_name" value="{{$product->name}}">
                        @if($errors->first('name'))
                            <label class="text-danger text-bold">{{$errors->first('name')}}</label>
                        @endif
                        @if(Session::has('product_exists'))
                            <label class="text-danger">{!! Session::get('product_exists') !!}</label>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="text" class="form-control" id="price" placeholder="Enter Price" name="price" value="{{$product->price}}">
                        @if($errors->first('price'))
                            <label class="text-danger text-bold">{{$errors->first('price')}}</label>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="stock">Stock:</label>
                        <input type="text" class="form-control" id="stock" placeholder="Enter Price" name="stock" value="{{$product->stock}}">
                        @if($errors->first('stock'))
                            <label class="text-danger text-bold">{{$errors->first('stock')}}</label>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="video">Video:</label>
                                <input type="file" class="form-control" id="video"  name="video">
                                @if($errors->first('video'))
                                    <label class="text-danger text-bold">{{$errors->first('video')}}</label>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <a href="javascript:void(0)" title="play" data-video-name="{{$product->video}}" class="video-play"><img src="{{asset('public/images/play.png')}}" width="100"></a>
                            </div>
                        </div>
                    </div>


                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{route('product.index')}}" class="btn badge-danger">Cancle</a>
                </form>
            </div>
        </div>
    </div>

    <!-- The Modal -->
    <div class="modal fade" id="video_modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body" id="yt-player">
                    <video width="450" height="300" controls autoplay  class="sample_video">
                        <source src="" type="video/mp4" class="video-src">
                        Your browser does not support the video tag.
                    </video>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(".video-play").click(function(){
                var video_name = $(this).data('video-name');
                var src = "{{URL::asset('storage/uploads/product/')}}";
                src = src +"/"+ video_name;
                $(".sample_video").html('<source src="'+src+'" type="video/mp4" class="video-src">');

                $('#video_modal').modal({backdrop: 'static', keyboard: false});

                $('.sample_video').trigger('play');
                // $('#video_modal').modal();
            });

            $('#video_modal').on('hidden.bs.modal', function () {
                //$(".modal-body").html('<iframe width="420" height="345" src=""> </iframe>');
                $('.sample_video').trigger('pause');
            });
        } );
    </script>
@endsection