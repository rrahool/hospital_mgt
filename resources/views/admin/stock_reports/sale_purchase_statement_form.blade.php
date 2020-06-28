@extends('layout')

@section('main_content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-body">


        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Search Sales / Purchase Statement</h4>
                            <div class="basic-form">
                                <form  action="{{url('sales_or_purchase_statement')}}" method="post" target="_blank">


                                    @csrf
                                    <div class="form-group">
                                        <span class="level_size">Select Type</span>
                                        <select class="form-control js-example-basic-single" name="sale_or_purchase" data-validation="required">
                                            <option value="">-- Select Type --</option>
                                            <option value="s">Sale</option>
                                            <option value="p">Purchase</option>
                                            {{--<option value="r">Purchase</option>
                                            <option value="t">Purchase</option>--}}
                                        </select>
                                    </div>

                                    <div class="form-row  margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Start Date</span>
                                            <div class="input-group">
                                                <input type="text" id="startpicker" name="from_date" required  class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">End Date</span>
                                            <div class="input-group">
                                                <input type="text" id="enddatepicker" name="to_date" required  class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                            </div>
                                        </div>
                                    </div>



                                    <button type="submit" class="btn btn-primary">Submit</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
