@extends('admin.master')

@section('mainContend')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Invoice Report</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">Invoice Report</div>
                <div class="panel-body">

                    {!! Form::open(['url'=>'invoice_report','method'=>'post']) !!}

                    <div class="form-group col-lg-5">
                        <label>Star Date</label>
                        <input class="form-control" type="date" value="" name="sdate1">
                    </div>
                    <div class="form-group col-lg-5">
                        <label>End Date</label>
                        <input class="form-control" type="date" value="" name="sdate2">
                    </div>

                    <div class="form-group col-lg-2">
                        &nbsp;<br>&nbsp;
                        <input type="submit" name="" class="btn btn-default" value="Submit">

                    </div>

                    </form>


                </div>
            </div>
        </div>
    </div>





@stop
