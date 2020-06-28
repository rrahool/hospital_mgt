@extends('admin.master')

@section('mainContend')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-warning">Complain Report</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            {!! Form::open(['url'=>'complain_report','method'=>'post']) !!}
            <div class="form-group col-lg-4">
                <label>Start Date</label>
                <input type="date" class="form-control" placeholder="" name="sdate1" required/>
            </div>
            <div class="form-group col-lg-4">
                <label>End Date</label>
                <input type="date" class="form-control" placeholder="" name="sdate2" required/>
            </div>
            <div class="form-group col-lg-4">
                <button type="submit" class="form-control btn btn-warning btn-block" style="margin-top:25px!important;">Search</button>
            </div>
            {!! Form::close() !!}
        </div>

    </div>
@stop