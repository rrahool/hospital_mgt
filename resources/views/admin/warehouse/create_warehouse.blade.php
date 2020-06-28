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


            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Add New Warehouse</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            @include('admin.includes.error')
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add New Warehouse Information</h4>
                            <div class="basic-form">
                                <form action="{{url('add_warehouse')}}" method="post">

                                    @csrf
                                    <div class="form-group">
                                        <span class="level_size">Warehouse Name</span>
                                        <input class="input form-control" autofocus  tabindex="1" placeholder="Warehouse Name" type="text" name="warehouse_name" data-validation="required">
                                    </div>

                                    <div class="form-group margin_top_minus_10">
                                        <span class="level_size">Address</span>
                                        <input class="input form-control" tabindex="2" placeholder="Address" type="text" name="address" data-validation="required">
                                    </div>
                                    <div class="form-group margin_top_minus_10">
                                        <span class="level_size">Owner Name</span>
                                        <input class="input form-control" tabindex="3" placeholder="Enter Owner name" type="text" name="owner_name" data-validation="required">
                                    </div>
                                    <div class="form-group margin_top_minus_10">
                                        <span class="level_size">Contact No</span>
                                        <input class="input form-control" tabindex="4" placeholder="Enter Owner name" type="text" name="contact_no" data-validation="required">
                                    </div>

                                    <button type="submit" class="btn btn-dark" tabindex="5">Save</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
