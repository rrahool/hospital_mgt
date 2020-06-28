@extends('layout')

@section('main_content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-body">


        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Store Wise Items Register</h4>
                            <div class="basic-form">
                                <form  action="{{url('store_wise_item_register')}}" method="post" target="_blank">

                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Store Name</span>
                                            <div class="input-group">
                                                <input class="form-control input " placeholder="Store Name" autofocus tabindex="1" list="warehouses" id="warehouse_input">
                                                <datalist id="warehouses">
                                                    @foreach($warehouses as $value)
                                                        <option data-id="{{$value->id}}" value="{{ $value->warehouse_name }}">
                                                    @endforeach
                                                </datalist>
                                                <input class="form-control input" type="hidden" id="warehouse_id" name="warehouse_id">
                                            </div>
                                        </div>


                                        <div class="form-group col-md-6">
                                            <span class="level_size">Product Name</span>
                                            <div class="input-group">
                                                <input class="form-control input " placeholder="Product Name" autofocus tabindex="1" list="products" id="product_input">
                                                <datalist id="products">
                                                    @foreach($products as $value)
                                                        <option data-id="{{$value->id}}" value="{{ $value->product_name }}">
                                                    @endforeach
                                                </datalist>
                                                <input class="form-control input" type="hidden" id="product_id" name="product_id">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Start Date</span>
                                            <div class="input-group">
                                                <input type="text" id="startpicker" name="from_date" required class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
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

@section('js')
    <script>


        $('#warehouse_input').on('input', function() {

            var value = $(this).val();
            var c_id = $('#warehouses [value="' + value + '"]').data('id');
            $('#warehouse_id').val(c_id)
        });

        $('#product_input').on('input', function() {

            var value = $(this).val();
            var c_id = $('#products [value="' + value + '"]').data('id');
            $('#product_id').val(c_id)
        });

    </script>
@stop



