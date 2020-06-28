@extends('admin.master')

@section('mainContend')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Merge Quotation Bill</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-green">
                <div class="panel-heading">
                    Merge Quotation Bill
                </div>
                <div class="panel-body">
                    {{ Form::open(['url'=>'merge_quotation','method'=>'post']) }}
                    <div class="form-group">
                        <label for="number">Merge Quation:</label>
                        <input type="text" class="form-control" name="number" id="number" placeholder="Quotation Number">
                    </div>
                    <div class="form-group col-lg-6">

                        <button type="submit" class="btn btn-info">Search</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    @stop