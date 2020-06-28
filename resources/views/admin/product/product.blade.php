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


            @if(empty($info))
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Add New Test Info</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                @include('admin.includes.error')
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            @if(empty($client_info))
                            <h4 class="card-title">Input Test Info</h4>
                            <div class="basic-form">
                                <form action="{{url('add_product')}}" method="post" enctype="multipart/form-data">

                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-12 margin_top_minus_10" style="display: block">
                                            <span class="level_size">Product Category</span>
                                            <select class="input form-control js-example-basic-single" autofocus tabindex="1" name="cat_id" data-validation="required">
                                                <option value="">Select your Product Category</option>
                                                <option value="{{ $cat_all[0]->id }}" selected>{{ $cat_all[0]->category_name }}</option>
                                                @foreach($cat_all as $value)
                                                    <option value="{{ $value->id }}">{{ $value->category_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12 margin_top_minus_10">
                                            <span class="level_size">Test Name</span>
                                            <input class="input form-control" tabindex="2" placeholder="Name" name="product_name" data-validation="required">
                                        </div>

                                    </div>

                                    <div class="form-row">

                                        <div class="form-group col-md-6 margin_top_minus_10">
                                            <span class="level_size">Normal Range</span>
                                            <input class="input form-control" tabindex="3" placeholder="Range" name="range" data-validation="">
                                        </div>

                                        <div class="form-group col-md-6 margin_top_minus_10" >
                                            <span class="level_size">Unit</span>
                                            <select class="input form-control js-example-basic-single" autofocus tabindex="4" name="range_unit">
                                                <option value="">Select Unit</option>
                                                <option value="mmoL/L." >mmoL/L.</option>
                                                <option value="mg/dL ." >mg/dL .</option>
                                                <option value="u/L." >u/L.</option>
                                                <option value="g/dL." >g/dL.</option>
                                                <option value="gm/dL." >gm/dL.</option>
                                                <option value="μg/dL" >μg/dL</option>
                                                <option value="ng/mL" >ng/mL</option>
                                                <option value="pg/ml." >pg/ml.</option>
                                                <option value="%" >%</option>
                                                <option value="mIU/ml" >mIU/ml</option>
                                                <option value="μIU/ml" >μIU/ml</option>
                                                <option value="gm/dL." >gm/dL.</option>
                                                <option value="mm" >mm</option>
                                                <option value="x10/L" >x10&sup3;9</sup>/L</option>
                                                <option value="million/cmm" >million/cmm</option>
                                                <option value="/Cmm" >/Cmm</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-row">

                                        <div class="form-group col-md-6 margin_top_minus_10">
                                            <span class="level_size">Code</span>
                                            <input class="input form-control" tabindex="5" placeholder="Code" name="code" >
                                        </div>

                                        <div class="form-group col-md-6 margin_top_minus_10">
                                            <span class="level_size">Price</span>
                                            <input class="input form-control" tabindex="5" placeholder="Price" name="sale" data-validation="number" data-validation-allowing="float">
                                        </div>

                                        <div class="form-group col-md-6" style="display: none">
                                            <span class="level_size">Brand</span>
                                            <input class="input form-control" name="brand" value="" tabindex="3">
                                        </div>
                                    </div>

                                    <div class="form-group margin_top_minus_10" style="display: none">
                                        <span class="level_size">Test Description</span>
                                        <textarea class="input form-control h-150px" tabindex="6" name="description" rows="3" placeholder="Type Test Description" data-validation="required">N/A</textarea>
                                    </div>

                                    <div class="form-row margin_top_minus_10" style="display: none">
                                        <div class="form-group col-md-3">
                                            <span class="level_size">Cost Price</span>
                                            <input class="input form-control" value="0"  placeholder="Enter cost Price" name="cost" data-validation="number" data-validation-allowing="float">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <span class="level_size">Minimum Price</span>
                                            <input class="input form-control" value="0"  placeholder="Minimum Price" name="min_price" data-validation="number" data-validation-allowing="float">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <span class="level_size">Re-order Level</span>
                                            <input class="input form-control" value="0" placeholder="" name="alert_limit" data-validation="number" >
                                        </div>
                                    </div>

                                    <div class="form-row margin_top_minus_10" style="display: none">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Product Unit</span>
                                            <select class="input form-control js-example-basic-single"  name="unit" data-validation="required">
                                                <option value="">Select Product Unit</option>
                                                    <option value="Kg">Kg</option>
                                                    <option value="Pieces" selected>Pieces</option>
                                                    <option value="Dozen">Dozen</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Quantity Per Carton</span>
                                            <input class="input form-control" value="1" placeholder="Quantity Per Carton" name="qt_per_carton" data-validation="number">
                                        </div>
                                    </div>

                                    <div class="form-group margin_top_minus_10" style="display: none">
                                        <span class="level_size">File input: </span>
                                        <input type="file" class="input "  name="product_image">
                                    </div>

                                    <button type="submit" class="btn btn-dark" tabindex="7">Save</button>
                                </form>
                            </div>

                            @else
                                <h4 class="card-title">Input Test Info</h4>
                                <div class="basic-form">
                                    <form action="{{url('add_product')}}" method="post" enctype="multipart/form-data">

                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group col-md-4" style="display: block">
                                                <span class="level_size">Product Category</span>
                                                <select class="input form-control js-example-basic-single" autofocus tabindex="1" name="cat_id" data-validation="required">
                                                    <option value="">Select your Product Category</option>
                                                    <option value="{{ $cat_all[0]->id }}" selected>{{ $cat_all[0]->category_name }}</option>
                                                    @foreach($cat_all as $value)
                                                        <option value="{{ $value->id }}">{{ $value->category_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <span class="level_size">Test Name</span>
                                                <input class="input form-control" tabindex="1" placeholder="Name" name="product_name" data-validation="required">
                                            </div>

                                        </div>


                                        <div class="form-row">

                                            <div class="form-group col-md-12 margin_top_minus_10">
                                                <span class="level_size">Price</span>
                                                <input class="input form-control" tabindex="2" placeholder="Price" name="sale" data-validation="number" data-validation-allowing="float">
                                            </div>

                                            <div class="form-group col-md-6" style="display: none">
                                                <span class="level_size">Brand</span>
                                                <input class="input form-control" name="brand" value="" tabindex="3">
                                            </div>
                                        </div>




                                        <div class="form-group margin_top_minus_10">
                                            <span class="level_size">Test Description</span>
                                            <textarea class="input form-control h-150px" tabindex="3" name="description" rows="3" placeholder="Type Test Description" data-validation="required"></textarea>
                                        </div>

                                        <div class="form-row margin_top_minus_10" style="display: none">
                                            <div class="form-group col-md-3">
                                                <span class="level_size">Cost Price</span>
                                                <input class="input form-control" value="0" tabindex="5" placeholder="Enter cost Price" name="cost" data-validation="number" data-validation-allowing="float">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <span class="level_size">Minimum Price</span>
                                                <input class="input form-control" value="0" tabindex="7" placeholder="Minimum Price" name="min_price" data-validation="number" data-validation-allowing="float">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <span class="level_size">Re-order Level</span>
                                                <input class="input form-control" value="0" tabindex="8" placeholder="" name="alert_limit" data-validation="number" >
                                            </div>
                                        </div>

                                        <div class="form-row margin_top_minus_10" style="display: none">
                                            <div class="form-group col-md-6">
                                                <span class="level_size">Product Unit</span>
                                                <select class="input form-control js-example-basic-single" tabindex="9" name="unit" data-validation="required">
                                                    <option value="">Select Product Unit</option>
                                                    <option value="Kg">Kg</option>
                                                    <option value="Pieces" selected>Pieces</option>
                                                    <option value="Dozen">Dozen</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <span class="level_size">Quantity Per Carton</span>
                                                <input class="input form-control" value="1" tabindex="10" placeholder="Quantity Per Carton" name="qt_per_carton" data-validation="number">
                                            </div>
                                        </div>

                                        <div class="form-group margin_top_minus_10" style="display: none">
                                            <span class="level_size">File input: </span>
                                            <input type="file" class="input " tabindex="11" name="product_image">
                                        </div>

                                        <button type="submit" class="btn btn-dark" tabindex="4">Save</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @else
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header">Edit Test Info</h3>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <div class="row">
                    @include('admin.includes.error')
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                @if(empty($info))
                                    <h4 class="card-title">Input Test Info</h4>
                                    <div class="basic-form">
                                        <form action="{{url('add_product')}}" method="post" enctype="multipart/form-data">

                                            @csrf
                                            <div class="form-row">
                                                <div class="form-group col-md-4" style="display: none">
                                                    <span class="level_size">Product Category</span>
                                                    <select class="input form-control js-example-basic-single" autofocus tabindex="1" name="cat_id" data-validation="required">
                                                        <option value="">Select your Product Category</option>
                                                        <option value="{{ $cat_all[0]->id }}" selected>{{ $cat_all[0]->cname }}</option>
                                                        @foreach($cat_all as $value)
                                                            <option value="{{ $value->id }}">{{ $value->cname }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <span class="level_size">Test Name</span>
                                                    <input class="input form-control" tabindex="1" placeholder="Name" name="product_name" data-validation="required">
                                                </div>

                                            </div>


                                            <div class="form-row">

                                                <div class="form-group col-md-12 margin_top_minus_10">
                                                    <span class="level_size">Price</span>
                                                    <input class="input form-control" tabindex="2" placeholder="Price" name="sale" data-validation="number" data-validation-allowing="float">
                                                </div>

                                                <div class="form-group col-md-6" style="display: none">
                                                    <span class="level_size">Brand</span>
                                                    <input class="input form-control" name="brand" value="" tabindex="3">
                                                </div>
                                            </div>

                                            <div class="form-group margin_top_minus_10">
                                                <span class="level_size">Test Description</span>
                                                <textarea class="input form-control h-150px" tabindex="3" name="description" rows="3" placeholder="Type Test Description" data-validation="required"></textarea>
                                            </div>

                                            <div class="form-row margin_top_minus_10" style="display: none">
                                                <div class="form-group col-md-3">
                                                    <span class="level_size">Cost Price</span>
                                                    <input class="input form-control" value="0" tabindex="5" placeholder="Enter cost Price" name="cost" data-validation="number" data-validation-allowing="float">
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <span class="level_size">Minimum Price</span>
                                                    <input class="input form-control" value="0" tabindex="7" placeholder="Minimum Price" name="min_price" data-validation="number" data-validation-allowing="float">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <span class="level_size">Re-order Level</span>
                                                    <input class="input form-control" value="0" tabindex="8" placeholder="" name="alert_limit" data-validation="number" >
                                                </div>
                                            </div>

                                            <div class="form-row margin_top_minus_10" style="display: none">
                                                <div class="form-group col-md-6">
                                                    <span class="level_size">Product Unit</span>
                                                    <select class="input form-control js-example-basic-single" tabindex="9" name="unit" data-validation="required">
                                                        <option value="">Select Product Unit</option>
                                                        <option value="Kg">Kg</option>
                                                        <option value="Pieces" selected>Pieces</option>
                                                        <option value="Dozen">Dozen</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <span class="level_size">Quantity Per Carton</span>
                                                    <input class="input form-control" value="1" tabindex="10" placeholder="Quantity Per Carton" name="qt_per_carton" data-validation="number">
                                                </div>
                                            </div>

                                            <div class="form-group margin_top_minus_10" style="display: none">
                                                <span class="level_size">File input: </span>
                                                <input type="file" class="input " tabindex="11" name="product_image">
                                            </div>

                                            <button type="submit" class="btn btn-dark" tabindex="4">Save</button>
                                        </form>
                                    </div>
                                @else
                                    <h4 class="card-title">Input Test Info</h4>
                                    <div class="basic-form">
                                        <form action="{{url('edit_product')}}" method="post" enctype="multipart/form-data">

                                            @csrf
                                            <input type="hidden" name="id" value="{{$info->id}}">
                                            <div class="form-row">
                                                <div class="form-group col-md-4" style="display: none">
                                                    <span class="level_size">Product Category</span>
                                                    <select class="input form-control js-example-basic-single" autofocus tabindex="1" name="cat_id" data-validation="required">
                                                        <option value="">Select your Product Category</option>
                                                        <option value="{{ $cat_all[0]->id }}" selected>{{ $cat_all[0]->cname }}</option>
                                                        @foreach($cat_all as $value)
                                                            <option value="{{ $value->id }}">{{ $value->cname }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <span class="level_size">Test Name</span>
                                                    <input class="input form-control" tabindex="1" value="{{$info->product_name}}" placeholder="Name" name="product_name" data-validation="required">
                                                </div>

                                            </div>


                                            <div class="form-row">

                                                <div class="form-group col-md-12 margin_top_minus_10">
                                                    <span class="level_size">Price</span>
                                                    <input class="input form-control" tabindex="2" value="{{$info->sell }}" placeholder="Price" name="sale" data-validation="number" data-validation-allowing="float">
                                                </div>

                                                <div class="form-group col-md-6" style="display: none">
                                                    <span class="level_size">Brand</span>
                                                    <input class="input form-control" name="brand" value="" tabindex="3">
                                                </div>
                                            </div>

                                            <div class="form-group margin_top_minus_10">
                                                <span class="level_size">Test Description</span>
                                                <textarea class="input form-control h-150px" tabindex="3" name="description" rows="3" placeholder="Type Test Description" data-validation="required">{{$info->product_name}}</textarea>
                                            </div>

                                            <div class="form-row margin_top_minus_10" style="display: none">
                                                <div class="form-group col-md-3">
                                                    <span class="level_size">Cost Price</span>
                                                    <input class="input form-control" value="0" tabindex="5" placeholder="Enter cost Price" name="cost" data-validation="number" data-validation-allowing="float">
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <span class="level_size">Minimum Price</span>
                                                    <input class="input form-control" value="0" tabindex="7" placeholder="Minimum Price" name="min_price" data-validation="number" data-validation-allowing="float">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <span class="level_size">Re-order Level</span>
                                                    <input class="input form-control" value="0" tabindex="8" placeholder="" name="alert_limit" data-validation="number" >
                                                </div>
                                            </div>

                                            <div class="form-row margin_top_minus_10" style="display: none">
                                                <div class="form-group col-md-6">
                                                    <span class="level_size">Product Unit</span>
                                                    <select class="input form-control js-example-basic-single" tabindex="9" name="unit" data-validation="required">
                                                        <option value="">Select Product Unit</option>
                                                        <option value="Kg">Kg</option>
                                                        <option value="Pieces" selected>Pieces</option>
                                                        <option value="Dozen">Dozen</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <span class="level_size">Quantity Per Carton</span>
                                                    <input class="input form-control" value="1" tabindex="10" placeholder="Quantity Per Carton" name="qt_per_carton" data-validation="number">
                                                </div>
                                            </div>

                                            <div class="form-group margin_top_minus_10" style="display: none">
                                                <span class="level_size">File input: </span>
                                                <input type="file" class="input " tabindex="11" name="product_image">
                                            </div>

                                            <button type="submit" class="btn btn-dark" tabindex="4">Save</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Tests</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>Test Name</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($tests as $client)
                                        <tr>
                                            <td>{{$client->product_name}}</td>
                                            <td>{{$client->sell}}</td>
                                            <td><a href="{{url('edit-test/'.$client->id)}}" class="btn btn-primary">Edit</a> <a href="{{url('delete-test/'.$client->id)}}" class="btn btn-danger">Delete</a></td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Test Name</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>

    @stop
