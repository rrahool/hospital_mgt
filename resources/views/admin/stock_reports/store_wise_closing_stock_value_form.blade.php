@extends('layout')

@section('main_content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-body">


        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Store Wise Closing Stock & Value</h4>
                            <div class="basic-form">
                                <form  action="{{url('store_wise_closing_stock_value')}}" method="post" data-validation="required" target="_blank">

                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Date</span>
                                            <div class="input-group">
                                                <input type="text" id="startpicker" name="date" required  class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                            </div>
                                        </div>
                                    </div>



                                    <button type="submit" name="submit" value="with_zero" class="btn btn-primary">Search</button>
                                    <button type="submit" name="submit" value="without_zero" class="btn btn-google">Search Without 0</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
