@extends('layout')

@section('main_content')

    <div class="content-body">

        <div class="container-fluid">


            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Edit Warehouse</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            @include('admin.includes.error')
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Edit Warehouse Information</h4>
                            <div class="basic-form">
                                <form action="{{url('warehouse_edit')}}" method="post">

                                    @csrf
                                    <div class="form-group">
                                        <span class="level_size">Warehouse Name</span>
                                        <input class="form-control" placeholder="Warehouse Name" type="text" value="{{$showById->warehouse_name}}" name="warehouse_name" required>
                                    </div>

                                    <div class="form-group margin_top_minus_10">
                                        <span class="level_size">Address</span>
                                        <input class="form-control" placeholder="Address" type="text" name="address" value="{{$showById->address}}" required>
                                    </div>
                                    <div class="form-group margin_top_minus_10">
                                        <span class="level_size">Owner Name</span>
                                        <input class="form-control" placeholder="Enter Owner name" type="text" name="owner_name" value="{{$showById->owner_name}}" required>
                                    </div>
                                    <div class="form-group margin_top_minus_10">
                                        <span class="level_size">Contact No</span>
                                        <input class="form-control" placeholder="Enter Owner name" type="text" name="contact_no" value="{{$showById->contact_no}}" required>
                                    </div>

                                    <input type="hidden" name="id" value="{{$showById->id}}">

                                    <button type="submit" class="btn btn-dark" >Update</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
