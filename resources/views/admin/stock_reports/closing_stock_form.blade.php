@extends('layout')

@section('main_content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-body">


        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Category Wise Closing Stock And Value</h4>
                            <div class="basic-form">
                                <form  action="{{url('closing_stock')}}" method="post" target="_blank">


                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Category Name</span>
                                            <div class="input-group">
                                                <input class="form-control input " placeholder="Category Name" autofocus tabindex="1" list="catagories" id="catagory_input">
                                                <datalist id="catagories">
                                                    @foreach($catagories as $value)
                                                        <option data-id="{{$value->id}}" value="{{ $value->cname }}">
                                                    @endforeach
                                                </datalist>
                                                <input class="form-control input" type="hidden" id="catagory_id" name="catagory_id">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Date</span>
                                            <div class="input-group">
                                                <input type="text" id="enddatepicker" tabindex="3" name="to_date" required  class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary" tabindex="4">Submit</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop



@section('js')

    <script>

        $('#catagory_input').on('input', function() {

            var value = $(this).val();
            var c_id = $('#catagories [value="' + value + '"]').data('id');
            $('#catagory_id').val(c_id)
        });



    </script>

@stop
