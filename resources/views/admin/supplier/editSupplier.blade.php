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

            @include('admin.includes.error')

            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Edit Supplier</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Supplier Info</h4>
                            <div class="basic-form">
                                <form action="{{url('supplier_edit')}}" method="post">

                                    @csrf
                                    <div class="form-group">
                                        <span class="level_size">Supplier Name</span>
                                        <input class="input form-control" tabindex="1" autofocus placeholder="Supplier Name" type="text"  name="supplier_name" value="{{ $showById->supplier_name }}" data-validation="required">
                                    </div>
                                    <div class="form-group margin_top_minus_10">
                                        <span class="level_size">Executive Name</span>
                                        <input class="input form-control" tabindex="2" placeholder="Executive Name" type="text" name="executive_name" value="{{ $showById->executive_name }}" >
                                    </div>
                                    <div class="form-group margin_top_minus_10">
                                        <span class="level_size">Products</span>
                                        <input class="input form-control" tabindex="3" placeholder="Enter Product name" type="text" name="products" value="{{ $showById->products }}" data-validation="required">
                                    </div>
                                    <div class="form-group margin_top_minus_10">
                                        <span class="level_size">Address</span>
                                        <textarea class="input form-control" tabindex="4" placeholder="Enter supplier full address" rows="3" name="address" data-validation="required">{{ $showById->address }}</textarea>
                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-lg-6">
                                            <span class="level_size">E-mail</span>
                                            <input class="input form-control" tabindex="5" placeholder="johndoe@domain.com" type="email" name="email" value="{{ $showById->email }}" data-validation="required">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <span class="level_size">Contact No</span>
                                            <input class="input form-control" tabindex="6" placeholder="" type="text" name="contact_no" value="{{ $showById->contact_no }}" data-validation="required">
                                        </div>
                                    </div>

                                    <input type="hidden" name="id" value="{{ $showById->id }}">
                                    <button type="submit" class="btn btn-dark" tabindex="7">Update</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
