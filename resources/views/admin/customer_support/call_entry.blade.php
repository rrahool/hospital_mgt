<?php
date_default_timezone_set('Asia/Dhaka');
$date = date("Y-m-d");
?>

@extends('admin.master')
@section('mainContend')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-warning">Call Entry</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            @include('admin.includes.error')
        </div>
    </div>

    <div class="panel panel-warning">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    {!! Form::open(['url'=>'call_entry','method'=>'post']) !!}
                        <div class="form-group col-lg-6">
                            <label>Entry Date</label>
                            <input type="date" class="form-control" placeholder="" value="{{ $date }}" name="entry_date" />
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Client Name</label>
                            <input type="text" class="form-control" placeholder="Client Name" name="client_name" />
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Address</label>
                            <input class="form-control" placeholder="Enter Address" type="text" name="address">
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Phone No</label>
                            <input class="form-control" placeholder="Enter Phone No" type="text" name="phone_no">
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Interested for</label>
                            <input class="form-control" placeholder="Interested For" type="text" name="interested">
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
                                <th>Address</th>
                                <th>Phone No</th>
                                <th>Interested</th>
                                <th>Creator</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($call_view as $value)
                            <tr class="odd gradeX">
                                <td>{{ $value->id }}</td>
                                <td>{{ date('d-M-Y',$value->entry_date) }}</td>
                                <td>{{ $value->client_name }}</td>
                                <td>{{ $value->address }}</td>
                                <td>{{ $value->phone_no }}</td>
                                <td>{{ $value->interested }}</td>
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