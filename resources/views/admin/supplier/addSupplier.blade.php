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
                    <h3 class="page-header">Add New Supplier</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            @include('admin.includes.error')
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add New Supplier Information</h4>
                            <div class="basic-form">
                                <form action="{{url('add_supplier')}}" method="post">

                                    @csrf
                                    <div class="form-group">
                                        <span class="level_size">Supplier Name</span>
                                        <input class="input form-control" tabindex="1" autofocus  placeholder="Supplier Name" type="text" name="supplier_name" data-validation="required">
                                    </div>

                                    <div class="form-group  margin_top_minus_10">
                                        <span class="level_size">Executive Name</span>
                                        <input class="input form-control" tabindex="2" placeholder="Executive Name" type="text" name="executive_name" >
                                    </div>
                                    <div class="form-group margin_top_minus_10">
                                        <span class="level_size">Product Name</span>
                                        <input class="input form-control" tabindex="3" placeholder="Enter Product name" type="text" name="products" data-validation="required">
                                    </div>
                                    <div class="form-group margin_top_minus_10">
                                        <span class="level_size">Address</span>
                                        <textarea class="input form-control" tabindex="4" placeholder="Enter supplier full address" rows="3" name="address" data-validation="required"></textarea>
                                    </div>
                                    <div class="form-group margin_top_minus_10">
                                        <span class="level_size">E-mail</span>
                                        <input class="input form-control" tabindex="5" placeholder="johndoe@domain.com" type="email" name="email">
                                    </div>
                                    <div class="form-group margin_top_minus_10">
                                        <span class="level_size">Contact No</span>
                                        <input class="input form-control" tabindex="6" placeholder="Contact No" type="text" name="contact_no" data-validation="required">
                                    </div>
                                    <button type="submit" class="btn btn-dark" tabindex="7" style="margin-left:15px!important;">Save</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
