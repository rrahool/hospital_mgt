<?php
date_default_timezone_set('Asia/Dhaka');
$date = date("Y-m-d");
?>
@extends('admin.master')

@section('mainContend')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-warning">Complain Entry</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-md-12">
            @include('admin.includes.error')
        </div>
    </div>
    <div class="panel panel-warning">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    {!! Form::open(['url'=>'complain_entry','method'=>'post']) !!}
                        <div class="form-group col-lg-6">
                            <label>Entry Date</label>
                            <input type="date" class="form-control" value="{{ $date }}" placeholder="" name="entry_date"/>
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Client Name</label>
                            <select class="form-control" name="client_id">
                                <option value="0">Select Client</option>
                                @foreach($client as $value)
                                    <option value="{{ $value->id }}">{{ $value->client_name }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Invoice No</label>
                            <input class="form-control" placeholder="Enter Invoice No" type="text" name="invoice">
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Complain</label>
                            <input class="form-control" placeholder="Enter Complain" type="text" name="complain">
                        </div>

                        <div class="form-group col-lg-3">
                            <button type="submit" class="form-control btn btn-warning pull-right" style="margin-top:25px;">Submit</button>
                        </div>
                    {!! Form::close() !!}
                </div>

            </div>
            <!-- /.row (nested) -->
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-warning">
                <div class="panel-heading text-warning">
                    Entries
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>Serial No.</th>
                                <th>Date</th>
                                <th>Client Name</th>
                                <th>Invoice No</th>
                                <th>Complain</th>
                                <th>Creator</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($complain_list as $value)
                            <tr class="odd gradeX">
                                <td>{{ $value->id }}</td>
                                <td>{{ date('d-M-Y',$value->entry_date) }}</td>
                                <td>{{ $value->client_name }}</td>
                                <td>{{ $value->invoice }}</td>
                                <td>{{ $value->complain }}</td>
                                <td>{{ $value->username }}</td>
                            </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->

                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    @stop