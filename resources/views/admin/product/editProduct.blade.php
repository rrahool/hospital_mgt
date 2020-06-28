@extends('layout')

@section('main_content')
    <style>
        .input:focus {
            outline: none !important;
            border:1px solid #648FBE;
            box-shadow: 0 0 10px #719ECE;
        }
    </style>

    <div class="content-body">

        <div class="container-fluid">

            @if(session()->has('message.level'))
                <div class="alert alert-{{ session('message.level') }}">
                    {!! session('message.content') !!}
                </div>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Edit Product</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Input Product Info</h4>
                            <div class="basic-form">
                                <form action="{{url('update_product')}}" method="post" enctype="multipart/form-data">

                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <span class="level_size">Product Category</span>
                                            <select class="input form-control js-example-basic-single" tabindex="1" name="cat_id">
                                                <option value="0">Select your Product Category</option>
                                                @foreach($cat_all as $value)
                                                    @if($productById->cat_id == $value->id)
                                                    <option value="{{ $value->id }}" selected>{{ $value->cname }}</option>
                                                    @else
                                                    <option value="{{ $value->id }}">{{ $value->cname }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <span class="level_size">Product Name</span>
                                            <input class="input form-control" tabindex="2" name="product_name" value="{{ $productById->product_name }}" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <span class="level_size">Brand</span>
                                            <input class="input form-control" tabindex="3" name="brand" value="{{ $productById->brand }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group margin_top_minus_10">
                                        <span class="level_size">Product Description</span>
                                        <textarea class="input form-control" tabindex="4" placeholder="Type Product Description" name="description" rows="3">{{ $productById->description }}</textarea>
                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Cost Price</span>
                                            <input class="input form-control" tabindex="5" placeholder="Enter cost Price" name="cost" value="{{ $productById->cost }}" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Sell Price</span>
                                            <input class="input form-control" tabindex="6" placeholder="Sell Price" name="sell" value="{{ $productById->sell }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group margin_top_minus_10" style="margin-left:15px;">
                                        @if($productById->product_image == NULL)
                                            <img src="{{ asset('product_image/product_icon.png') }}" tabindex="7" height="120px" width="120px">
                                        @else
                                            <img src="{{ asset('product_image/').'/'.$productById->product_image }}" tabindex="7" height="120px" width="120px">

                                        @endif
                                        <br>
                                            <span class="level_size">File input</span>
                                        <input type="file" name="product_image">
                                    </div>

                                    <input type="hidden" name="id" value="{{ $productById->p_id }}">
                                    <input type="hidden" name="default_image" value="{{ $productById->product_image }}">


                                    <button type="submit" class="btn btn-dark" tabindex="8">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    @endsection
