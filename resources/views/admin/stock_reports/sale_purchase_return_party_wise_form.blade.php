@extends('layout')

@section('main_content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-body">


        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Sale/Purchase/Transfer/Return</h4>
                            <div class="basic-form">
                                <form  action="{{url('sale_purchase_return_party_wise')}}" method="post" target="_blank">


                                    @csrf
                                    <div class="form-row">

                                        <div class="form-group col-md-6">
                                            <span class="level_size">Type</span>
                                            <select class="form-control js-example-basic-single" id="type" name="type" tabindex="1" autofocus data-validation="required">
                                                <option value="">Select Type</option>
                                                <option value="p">Purchase</option>
                                                <option value="p_r">Purchase Return</option>
                                                <option value="s">Sale</option>
                                                <option value="s_r">Sale Return</option>
                                                {{--<option value="in">Product In</option>
                                                <option value="out">Product Out</option>--}}
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Start Date</span>
                                            <div class="input-group">
                                                <input type="text" id="startpicker" name="from_date" data-validation="required" tabindex="3"  class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">End Date</span>
                                            <div class="input-group">
                                                <input type="text" id="enddatepicker" name="to_date" data-validation="required" tabindex="4" class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
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

