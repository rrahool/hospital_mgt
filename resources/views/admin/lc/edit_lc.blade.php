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
                    <h3 class="page-header">Edit L/C Info</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>--}}

            <div class="row">
                @include('admin.includes.error')
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Edit L/C Info</h4>

                            <div class="basic-form">
                                <form action="{{url('update_lc')}}" method="post" >

                                    @csrf
                                    <input type="hidden" name="id" value="{{$lc_info->id}}">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">L/C Type</span>
                                            <select class="form-control" autofocus name="lc_type" data-validation="required">
                                                <option value="">Select LC Type</option>
                                                @foreach($lc_types as $value)
                                                    @if($lc_info->lc_type == $value->id)
                                                    <option value="{{ $value->id }}" selected>{{ $value->name }}</option>
                                                    @else
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                    @endif
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
                                            <input class="form-control" placeholder="L/C No" name="lc_no" value="{{$lc_info->lc_no}}" data-validation="required">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">L/C Date</span>
                                            <input class="form-control" type="date" value="<?php echo date('Y-m-d', $lc_info->lc_date); ?>" name="lc_date" >
                                        </div>
                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Bank Name</span>
                                            <input class="form-control" placeholder="Bank Name" name="bank_name" value="{{$lc_info->bank_name}}" data-validation="required">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Bank</span>
                                            <input class="form-control" placeholder="Bank" name="" data-validation="required">
                                        </div>
                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Importer Name</span>
                                            <input class="form-control" placeholder="Importer Name" value="{{$lc_info->importer_name}}" name="importer_name" data-validation="required">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Beneficiary</span>
                                            <input class="form-control" placeholder="Beneficiary" value="{{$lc_info->beneficiary}}" name="beneficiary" data-validation="required">
                                        </div>
                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">SCPI No</span>
                                            <input class="form-control" placeholder="SCPI No" name="scpi_no" value="{{$lc_info->scpi_no}}" data-validation="required">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">SCPI date</span>
                                            <input class="form-control" type="date" value="<?php echo date('Y-m-d', $lc_info->scpi_date); ?>" name="scpi_date">
                                        </div>
                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">MC Name</span>
                                            <input class="form-control" placeholder="MC Name" name="mc_name" value="{{$lc_info->mc_name}}" data-validation="required">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">MC No</span>
                                            <input class="form-control" placeholder="MC No" name="mc_no" value="{{$lc_info->mc_no}}" data-validation="required">
                                        </div>
                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">MC date</span>
                                            <input class="form-control" type="date" value="<?php echo date('Y-m-d', $lc_info->mc_date); ?>" name="mc_date">
                                        </div>
                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">L/C USD</span>
                                            <input class="form-control" placeholder="L/C USD" name="lc_usd" value="{{$lc_info->lc_usd}}" data-validation="required">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">L/C Exchange Rate</span>
                                            <input class="form-control" placeholder="L/C Exchange Rate" name="lc_exchange_rate" value="{{$lc_info->lc_exchange_rate}}" data-validation="required">
                                        </div>
                                    </div>


                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">L/C BDT</span>
                                            <input class="form-control" placeholder="Enter cost Price" name="lc_bdt" value="{{$lc_info->lc_bdt}}" data-validation="required">
                                        </div>
                                    </div>


                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Remarks</span>
                                            <textarea class="form-control h-150px" name="remarks" rows="3" placeholder="Remarks" data-validation="required">{{$lc_info->remarks}}</textarea>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Status</span>
                                            <select class="form-control" name="status">
                                                <option value="0">Select Status</option>
                                                @if($lc_info->status == 'Active')
                                                    <option value="Active" selected>Active</option>
                                                    <option value="Inactive">Inactive</option>
                                                @else
                                                    <option value="Active" >Active</option>
                                                    <option value="Inactive" selected>Inactive</option>
                                                @endif
                                            </select>                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-dark">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
