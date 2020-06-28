@extends('layout')

@section('main_content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-body">


        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Search Transaction</h4>
                            <div class="basic-form">
                                <form action="{{url('transaction-list')}}" method="post" target="_blank">
                                    @csrf
                                    <div class="form-group">
                                        <span class="level_size">From Date<span class="level_size">
                                        <div class="input-group">
                                            <input type="text" name="from_date" required  class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                        </div>
                                    </div>

                                    <div class="form-group margin_top_minus_10">
                                        <label>To Date</label>
                                        <div class="input-group">
                                            <input type="text" name="to_date" required  class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
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

    <!-- /.content-wrapper -->


@endsection
