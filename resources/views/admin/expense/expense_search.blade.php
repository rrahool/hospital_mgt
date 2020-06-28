@extends('admin.master')

@section('mainContend')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-warning">Expense List</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="panel panel-warning">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                        {{ Form::open(['url'=>'expense_search_result','method'=>'post']) }}
                        <div class="form-group col-lg-6">
                            <label>Start Date</label>
                            <input type="date" class="form-control" placeholder="" name="sdate1"/>
                        </div>
                        <div class="form-group col-lg-6">
                            <label>End Date</label>
                            <input type="date" class="form-control" placeholder="" name="sdate2"/>
                        </div>
                        <div class="form-group col-lg-6">
                            <label>User</label>
                            <select class="form-control" name="uid">
                                <option value="0"></option>
                                @foreach($users as $value)
                                <option value="{{ $value->id }}">{{ $value->username }}</option>
                                    @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Expense </label>
                            <select class="form-control" name="expenseid">
                                <option value="0"></option>
                                @foreach($expense_type as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Project</label>
                            <select name="project_id" class="form-control">
                                <option value="0"></option>
                                @foreach($project as $value)
                                    <option value="{{ $value->id }}">{{ $value->project_name }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-6 ">
                            <button type="submit" class="btn btn-warning col-lg-2 pull-right" style="margin-left:15px!important;">Search</button>
                        </div>

                    {{ Form::close() }}

                </div>

            </div>
            <!-- /.row (nested) -->
        </div>
    </div>
    @stop