@extends('admin.master')

@section('mainContend')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-warning">Settings</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            @include('admin.includes.error')
        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    General Settings
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            {{ Form::open(['url'=>'get_setting','method'=>'post','enctype'=>'multipart/form-data']) }}
                            @if($setting)
                                @foreach($setting as $value)
                                <input type="hidden" name="id" value="<?php echo (isset($value->id))? $value->id :'';?>">
                                <div class="form-group col-lg-12">
                                    <label>Company Name</label>
                                    <input type="text" class="form-control" placeholder="Enter company Name" name="cname" value="@if($value->cname)  {{ $value->cname }} @endif ">
                                </div>

                                <div class="form-group col-lg-12">
                                    <label>Address</label>
                                    <textarea class="form-control" placeholder="Enter Company Address" rows="3" name="address"><?php echo (isset($value->address))? $value->address :'';?></textarea>
                                </div>

                                <div class="form-group col-lg-6" style="margin-left:15px;">
                                    @if(!empty($value->logo))
                                    <img src="{{ asset('product_image/logo/'.$value->logo)}}" height="100">
                                    @endif
                                    <br>
                                    <label>Company Logo</label>
                                    <input type="file" name="logo">
                                    <input type="hidden" name="defaulImage" value="{{ $value->logo }}">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Invoice Prefix</label>
                                    <input class="form-control" placeholder="Enter Invoice Prefix" name="payment_method" value="<?php echo (isset($value->payment_method))? $value->payment_method :'';?>">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Payment Method</label>
                                    <input class="form-control" placeholder="Enter payment method" name="invoice_prefix" value="<?php echo (isset($value->invoice_prefix))? $value->invoice_prefix :'';?>">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label>Terms &amp; Conditions</label>
                                    <textarea class="form-control" placeholder="Enter Company Address" rows="3" name="terms"><?php echo (isset($value->terms))? $value->terms :'';?></textarea>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label>Print in Pad</label>
                                    <div class="radio">
                                        <label>
                                            <input id="" name="IsUseCompanyPad" value="1" class="FormInputRadio" style="" type="radio" <?php echo ($value->print == 1) ?  "checked" : "" ;  ?>> Yes
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input id="" name="IsUseCompanyPad" value="0" class="FormInputRadio" style="" type="radio" <?php echo ($value->print == 0) ?  "checked" : "" ;  ?>> No
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <input type="hidden" name="id" value="">
                                <div class="form-group col-lg-12">
                                    <label>Company Name</label>
                                    <input type="text" class="form-control" placeholder="Enter company Name" name="cname" value="">
                                </div>

                                <div class="form-group col-lg-12">
                                    <label>Address</label>
                                    <textarea class="form-control" placeholder="Enter Company Address" rows="3" name="address"></textarea>
                                </div>

                                <div class="form-group col-lg-6" style="margin-left:15px;">

                                    <label>Company Logo</label>
                                    <input type="file" name="logo">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Invoice Prefix</label>
                                    <input class="form-control" placeholder="Enter Invoice Prefix" name="payment_method" value="">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Payment Method</label>
                                    <input class="form-control" placeholder="Enter payment method" name="invoice_prefix" value="">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label>Terms &amp; Conditions</label>
                                    <textarea class="form-control" placeholder="Enter Company Address" rows="3" name="terms"></textarea>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label>Print in Pad</label>
                                    <div class="radio">
                                        <label>
                                            <input id="" name="IsUseCompanyPad" value="1" class="FormInputRadio" style="" type="radio"> Yes
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input id="" name="IsUseCompanyPad" value="0" class="FormInputRadio" style="" type="radio"> No
                                        </label>
                                    </div>
                                </div>
                                @endif

                                <div class="form-group col-lg-4">

                                    <button type="submit" class="btn btn-warning btn-block col-lg-3" style="">Save</button>
                                </div>
                            {{ Form::close() }}
                        </div>

                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    @stop