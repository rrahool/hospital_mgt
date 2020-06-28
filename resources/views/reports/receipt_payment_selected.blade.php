@extends('layout')

@section('main_content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-body">


        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Search Receive & payment</h4>
                            <div class="basic-form">
                                <form action="{{url('selected-receive-payments')}}" method="post" target="_blank">
                                    @csrf
                                    <div class="form-group">
                                        <span class="level_size">From Date</span>
                                        <div class="input-group">
                                            <input type="text" name="from_date" required class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                        </div>
                                    </div>

                                    <div class="form-group margin_top_minus_10">
                                        <span class="level_size">To Date</span>
                                        <div class="input-group">
                                            <input type="text" name="to_date" required onchange="getDate(this.value)" class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                        </div>
                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-12">
                                            <label>Select Ledger</label>
                                            <select class="form-control js-example-basic-single" name="led_id" data-validation="required">
                                                <option value="">-- Select Type --</option>
                                                @foreach($bank_cash_leds as $led)
                                                    <?php
                                                    $name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $led->name));
                                                    ?>
                                                    <option value="{{$led->id}}">{{$name}}</option>
                                                @endforeach
                                            </select>
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
