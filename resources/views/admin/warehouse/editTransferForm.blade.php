<?php
date_default_timezone_set('Asia/Dhaka');
$date = date("Y-m-d");
?>

@extends('layout')

@section('main_content')
    <style>
        .input:focus {
            outline: none !important;
            border:1px solid #648FBE;
            box-shadow: 0 0 10px #719ECE;
        }
    </style>

    <div class="content-body">

        <div class="container-fluid">


            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Transfer Product</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                @include('admin.includes.error')
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Update Transfer Entry Info</h4>
                            <div class="basic-form">
                                <form action="{{url('edit_transfer')}}" method="post" >

                                    @csrf

                                    <input type="hidden" name="old_transfer_id" value="{{$info_arr['old_transfer_id']}}">
                                    <input type="hidden" name="old_quantity" value="{{$info_arr['quantity']}}">
                                    <input type="hidden" name="old_product_id" value="{{$info_arr['product_id']}}">
                                    <input type="hidden" name="old_from_warehouse" value="{{$info_arr['from_warehouse_id']}}">
                                    <input type="hidden" name="old_to_warehouse" value="{{$info_arr['to_warehouse_id']}}">

                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <span class="level_size">Date</span>
                                            <div class="input-group">
                                                <input type="text" tabindex="1" id="startpicker"  name="entry_date" value="{{$info_arr['entry_date']}}" required class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <span class="level_size">From</span>
                                            <select class="input form-control js-example-basic-single"  tabindex="2" name="warehouse_from" id="newsupplier" data-validation="required">
                                                <option value="">Select Warehouse Name</option>
                                                @foreach($warehouses as $value)
                                                    @if($info_arr['from_warehouse_id'] == $value->id )
                                                    <option value="{{ $value->id }}" selected>{{ $value->warehouse_name }}</option>
                                                    @else
                                                    <option value="{{ $value->id }}">{{ $value->warehouse_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <span class="level_size">To</span>
                                            <select class="input form-control js-example-basic-single" tabindex="3" name="warehouse_to" id="newsupplier" data-validation="required">
                                                <option value="">Select Warehouse Name</option>
                                                @foreach($warehouses as $value)
                                                    @if($info_arr['to_warehouse_id'] == $value->id )
                                                    <option value="{{ $value->id }}" selected>{{ $value->warehouse_name }}</option>
                                                    @else
                                                    <option value="{{ $value->id }}">{{ $value->warehouse_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-4">
                                            <span class="level_size">Memo No</span>
                                            <div class="input-group">
                                                <input type="text" tabindex="4"   name="memo_no" value="{{$memo_no}}" required class="form-control"  readonly>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <span class="level_size">Product Catagory</span>
                                            <select class="input form-control js-example-basic-single" tabindex="5" name="cat_id" id="cat_id" onChange="getProducts(this);" data-validation="required">
                                                <option value="">Select Catagory</option>
                                                @foreach($catagories as $value)
                                                    @if($info_arr['cat_id'] == $value->id )
                                                    <option value="{{ $value->id }}" selected>{{ $value->cname }}</option>
                                                    @else
                                                    <option value="{{ $value->id }}">{{ $value->cname }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <span class="level_size">Product Name</span>
                                            <select class="input form-control js-example-basic-single" tabindex="6" name="product_id" id="product_id" data-validation="required">
                                                <option value="">Select Product</option>
                                                @foreach($products as $value)
                                                    @if($info_arr['product_id'] == $value->id )
                                                    <option value="{{$value->id}}" selected>{{$value->product_name}}</option>
                                                    @else
                                                    <option value="{{$value->id}}">{{$value->product_name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-4">
                                            <span class="level_size">Carton</span>
                                            <input type="hidden" class="qt_per_carton" tabindex="7" id="qt_per_carton" value="{{$info_arr['qt_per_carton']}}" name="qt_per_carton">
                                            <input class="input form-control carton" id="carton" placeholder="Carton" type="text"  name="carton" value="{{$info_arr['carton']}}" data-validation="number">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <span class="level_size">Piece</span>
                                            <input class="input form-control pieces" tabindex="8" id="pieces" placeholder="piece" type="text" value="{{$info_arr['pieces']}}" name="pieces" data-validation="number" data-validation-allowing="float">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <span class="level_size">Total Quantity</span>
                                            <input class="input form-control quantity" tabindex="9" id="quantity" placeholder="Quantity" value="{{$info_arr['quantity']}}" readonly type="text" name="quantity" data-validation="number">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-dark " tabindex="10" style="margin-top: 10px">Update</button>
                                    <button type="button" class="btn btn-facebook" data-toggle="modal" style="margin-top: 10px; margin-left: 10px " data-target="#exampleModalCenter">Edit</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{--MODAL STARTS--}}
            <div class="modal fade" id="exampleModalCenter">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Get Memo Info</h5>
                        </div>
                        <div class="modal-body">
                            <div class="basic-form">
                                <form action="{{url('edit_transfer_info')}}" method="post" >
                                    @csrf
                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-4">
                                            <span class="level_size">Start Date</span>
                                            <div class="input-group">
                                                <input type="text" id="startpicker1" tabindex="1" name="from_date" required class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <span class="level_size">End Date</span>
                                            <div class="input-group">
                                                <input type="text" id="enddatepicker1" tabindex="2" name="to_date" required  class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <span class="level_size">Select Memo</span>
                                            <div class="input-group">
                                                <input class="form-control input " placeholder="Memo No"  tabindex="3" list="memos" id="memo_input">
                                                <div id="memo_datalist">

                                                </div>
                                                <input class="form-control input" type="hidden" id="memo" name="memo" >
                                            </div>
                                        </div>
                                    </div>
                                    <input type="submit" name="save" class="btn btn-dark" value="Submit">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--MODAL ENDS--}}
        </div>
    </div>
@stop


@section('js')

    <script>
        function getProducts(selected_option) {
            var cat_id = selected_option.options[selected_option.selectedIndex].value;
            //console.log(cat_id)

            $.ajax({
                //url: 'getUser.php',
                url:'get_products',
                type: 'GET',
                data: 'cat_id='+cat_id,
                //data:{id:uid}
                dataType: 'html'
            })
                .done(function(data){
                    console.log(data);

                    $('#product_id').html(data); // load response
                })
                .fail(function(){
                    $('#product_id').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
                });

        }


        $("#product_id").change(function() {
            // $(this) refers to the select element
            var product_id = $("#product_id").val();
            // console.log(product_id)

            $.ajax({
                //url: 'getUser.php',
                url:'get_qt_per_carton',
                type: 'GET',
                data: 'product_id='+product_id,
                //data:{id:uid}
                dataType: 'html'
            })
                .done(function(data){
                    console.log(data);
                    $('.qt_per_carton').val(data);

                })
                .fail(function(){
                    $('.qt_per_carton').val('Something went wrong, Please try again...');
                });
        })


        $(document).on('keyup','.carton',function(){

            var qt_per_carton = $("#qt_per_carton").val();
            var carton = $("#carton").val();
            var pieces = $("#pieces").val();

            var quantity = parseInt(qt_per_carton)*parseInt(carton);
            $('.quantity').val(quantity);
        });

        $(document).on('keyup','.pieces',function(){

            var qt_per_carton = $("#qt_per_carton").val();
            var carton = $("#carton").val();
            var pieces = $("#pieces").val();

            if (carton == null || carton<1){
                var quantity = pieces;
            }else {
                var quantity = parseInt(qt_per_carton)*parseInt(carton);
                var quantity = parseInt(quantity)+parseInt(pieces);
            }

            $('.quantity').val(quantity);
        });



        $("#startpicker1").on("change",function (){
            var from_date = document.getElementById('startpicker1').value
            var to_date = document.getElementById('enddatepicker1').value
            console.log(from_date)
            console.log(to_date)

            getMemoByDate(from_date, to_date);

        });

        $("#enddatepicker1").on("change",function (){
            var from_date = document.getElementById('startpicker1').value
            var to_date = document.getElementById('enddatepicker1').value
            console.log(from_date)
            console.log(to_date)
        });

        function getMemoByDate(from_date, to_date) {

            $.ajax({
                url: '{{url('get_transfer_memos_by_date')}}',
                type: 'GET',
                data: 'from_date='+from_date+'&to_date='+to_date,
                /*data:{
                    from_date:from_date,
                    to_date:to_date
                },*/
                dataType: 'html'
            })
                .done(function (data) {
                    console.log(data);

                    // $('.client_address').val(data); // load response
                    $('#memo_datalist').html(data); // load response
                });
        }

        $('#memo_input').on('input', function() {

            var value = $(this).val();
            var c_id = $('#memos [value="' + value + '"]').data('id');
            $('#memo').val(c_id)
        });


    </script>

@stop
