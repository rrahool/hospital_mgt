@extends('layout')

@section('main_content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-body">


        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Item Stock</h4>
                            <div class="basic-form">
                                <form  action="{{url('closing_stock_store_wise')}}" method="post" target="_blank">


                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Catagory Name</span>
                                            <div class="input-group">
                                                <input class="form-control input " autofocus tabindex="1" list="cats" id="cat_input">
                                                <datalist id="cats">
                                                    @foreach($cats as $value)
                                                        <option data-id="{{$value->id}}" value="{{ $value->cname }}">
                                                    @endforeach
                                                </datalist>

                                                <input class="form-control input" type="hidden" id="cat_id" name="cat_id">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Warehouse Name</span>
                                            <div class="input-group">
                                                <input class="form-control input " autofocus tabindex="2" list="warehouses" id="warehouse_input">
                                                <datalist id="warehouses">
                                                    @foreach($warehouses as $value)
                                                        <option data-id="{{$value->id}}" value="{{ $value->warehouse_name }}">
                                                    @endforeach
                                                </datalist>

                                                <input class="form-control input" type="hidden" id="warehouse_id" name="warehouse_id">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Date</span>
                                            <div class="input-group">
                                                <input type="text" id="enddatepicker" name="to_date" tabindex="3" data-validation="required"  class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
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

@section('js')
    <script>

        $('#cat_input').on('input', function() {

            var value = $(this).val();
            var c_id = $('#cats [value="' + value + '"]').data('id');
            $('#cat_id').val(c_id)
        });

        $('#warehouse_input').on('input', function() {

            var value = $(this).val();
            var c_id = $('#warehouses [value="' + value + '"]').data('id');
            $('#warehouse_id').val(c_id)
        });

    </script>

@stop
