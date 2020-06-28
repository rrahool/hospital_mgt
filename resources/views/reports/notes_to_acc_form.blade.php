@extends('layout')

@section('main_content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-body">


        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Notes To the Account</h4>
                            <div class="basic-form">
                                <form action="{{url('notes-to-the-accounts')}}" method="post" target="_blank">
                                    @csrf

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <span class="level_size">Type</span>
                                            <select class="form-control js-example-basic-single" id="type_id" data-validation="required">
                                                <option value="">-- Select Type --</option>
                                                @foreach($groups as $group)
                                                    <option value="{{$group->id}}">{{$group->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-12">
                                            <span class="level_size">Head Name</span>

                                            <select class="form-control js-example-basic-single" name="group_id" id="head_id" data-validation="required">
                                                <option value="">-- Select Head --</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group margin_top_minus_10">
                                        <span class="level_size">From Date</span>
                                        <div class="input-group">
                                            <input type="text" name="from_date"   required class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                        </div>
                                    </div>

                                    <div class="form-group margin_top_minus_10">
                                        <span class="level_size">To Date</span>
                                        <div class="input-group">
                                            <input type="text" name="to_date" required class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
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
