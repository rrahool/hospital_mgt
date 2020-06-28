@extends('admin.master')

@section('mainContend')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Add New Client</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        @include('admin.includes.error')
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-offset-2 col-lg-8">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    Add New Client Information
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            {!! Form::open(['url'=>'add_client','method'=>'post','role'=>'form']) !!}
                            <div class="form-group col-lg-12">
                                <label>Client Name</label>
                                <input class="form-control" placeholder="Client Name" type="text" name="client_name" required>
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Company Name</label>
                                <input class="form-control" placeholder="Company Name" type="text" name="company_name">
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Address</label>
                                <textarea class="form-control" placeholder="Enter supplier full address" rows="3" name="address"></textarea>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>E-mail</label>
                                <input class="form-control" placeholder="johndoe@domain.com" type="email" name="email">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Contact No</label>
                                <input class="form-control" placeholder="" type="text" name="contact_no" required>
                            </div>
                            <button type="submit" class="btn btn-warning col-lg-2" style="margin-left:15px!important;">Save</button>
                            {!! Form::close() !!}
                        </div>

                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    @stop