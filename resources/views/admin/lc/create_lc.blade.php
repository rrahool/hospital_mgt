<?php
date_default_timezone_set('Asia/Dhaka');
$date = date("Y-m-d");
?>

@extends('layout')

@section('main_content')

    <div class="content-body">

        <div class="container-fluid">


            {{--<div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Add New Product</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>--}}

            <div class="row">
                @include('admin.includes.error')
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Input Product Info</h4>

                            <div class="basic-form">
                                <form action="{{url('create_lc')}}" method="post" >

                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">L/C Type</span>
                                            <select class="form-control" autofocus  name="lc_type" data-validation="required">
                                                <option value="">Select LC Type</option>
                                                @foreach($lc_types as $value)
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">L/C ID</span>
                                            <input class="form-control" placeholder="L/C ID" name="lc_id" value="{{$entry_no}}" readonly>
                                        </div>

                                    </div>


                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">L/C No</span>
                                            <input class="form-control" placeholder="L/C No" name="lc_no" data-validation="required">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">L/C Date</span>
                                            <input class="form-control" type="date" value="<?php echo $date; ?>" name="lc_date">
                                        </div>
                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Bank Name</span>
                                            <input class="form-control" placeholder="Bank Name" name="bank_name" data-validation="required">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Bank</span>
                                            <input class="form-control" placeholder="Bank" name="" data-validation="required">
                                        </div>
                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Importer Name</span>
                                            <input class="form-control" placeholder="Importer Name" name="importer_name" data-validation="required">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Beneficiary</span>
                                            <input class="form-control" placeholder="Beneficiary" name="beneficiary" data-validation="required">
                                        </div>
                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">SCPI No</span>
                                            <input class="form-control" placeholder="SCPI No" name="scpi_no" data-validation="required">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">SCPI date</span>
                                            <input class="form-control" type="date" value="<?php echo $date; ?>" name="scpi_date">
                                        </div>
                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">MC Name</span>
                                            <input class="form-control" placeholder="MC Name" name="mc_name" data-validation="required">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">MC No</span>
                                            <input class="form-control" placeholder="MC No" name="mc_no" data-validation="required">
                                        </div>
                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">MC date</span>
                                            <input class="form-control" type="date" value="<?php echo $date; ?>" name="mc_date">
                                        </div>
                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">L/C USD</span>
                                            <input class="form-control" placeholder="L/C USD" name="lc_usd" data-validation="required">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">L/C Exchange Rate</span>
                                            <input class="form-control" placeholder="L/C Exchange Rate" name="lc_exchange_rate" data-validation="required">
                                        </div>
                                    </div>


                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">L/C BDT</span>
                                            <input class="form-control" placeholder="Enter cost Price" name="lc_bdt" data-validation="required">
                                        </div>
                                    </div>


                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Remarks</span>
                                            <textarea class="form-control h-150px" name="remarks" rows="3" placeholder="Remarks"></textarea>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Status</span>
                                            <select class="form-control" name="status" data-validation="required">
                                                <option value="">Select Status</option>
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                            </select>                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-dark">Save</button>
                                    <a href="{{url('')}}" class="btn btn-primary">Edit</a>
                                    <a href="{{url('')}}" class="btn btn-info">Refresh</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stop
