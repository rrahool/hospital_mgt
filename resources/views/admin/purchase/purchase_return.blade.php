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
        div.scroll {
            height: 160px;
            overflow: auto;
            text-align:justify;
        }
    </style>

    <div class="content-body">

        <div class="container-fluid">


            {{--<div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Purchase Return</h3>
                    </div>
                <!-- /.col-lg-12 -->
            </div>--}}


            <div class="row">
                @include('admin.includes.error')
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"> Purchase Return</h4>
                            <div class="basic-form">
                                <form action="{{url('purchase_return')}}" method="post" >

                                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                    <div style="border: 1px solid #CED4DA; padding: 10px; border-radius: 8px; " >
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <span class="level_size">Date</span>
                                                <input class="form-control" tabindex="1" type="date" value="<?php echo $date; ?>" name="entry_date">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <span class="level_size">Memo No:</span>
                                                <input class="form-control" tabindex="2" name="memo_no" type="text" value="{{ $entry_no }}" readonly>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <span class="level_size">Supplier Memo No</span>
                                                <input class="input form-control"  autofocus tabindex="3" placeholder="Supplier Memo No" type="text" name="ref_no" >
                                            </div>
                                        </div>

                                        <div class="form-row margin_top_minus_10">

                                        <div class="form-group col-md-6">
                                            <span class="level_size">Supplier Name</span>
                                            <input class="form-control input " tabindex="4" placeholder="Supplier Name" list="suppliers" id="supplier_input">
                                            <datalist id="suppliers">
                                                @foreach($supplier as $value)
                                                    <option data-id="{{$value->id}}" value="{{ $value->supplier_name }}">
                                                @endforeach
                                            </datalist>
                                            <input class="form-control input" type="hidden" id="supplier_id" name="supplier_id">

                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Warehouses Name</span>
                                            <select class="input form-control js-example-basic-single warehouse_id" tabindex="5" name="warehouse_id" id="warehouse_id" data-validation="required">
                                                <option value="">Select Warehouses Name</option>
                                                @foreach($warehouses as $value)
                                                    <option value="{{ $value->id }}">{{ $value->warehouse_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{--<div class="form-group col-md-4">
                                            <span class="level_size">Address</span>
                                            <input class="input form-control" placeholder="" tabindex="6" type="text" id="supplier_address">
                                        </div>--}}
                                    </div>

                                        <div class="row margin_top_minus_10" >
                                            <div class="col-md-8" style=" text-align: right">
                                                {{--<input type="checkbox" class="text-right chk2" name="">--}}
                                            </div>
                                            <div class="col-md-2 pull-right">
                                                <span class="level_size">Total</span>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" name="column_total" placeholder="Total" class="input form-control column_total" data-validation="required" readonly="" >                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-dark " >Submit</button>
                                                <button type="button" class="btn btn-facebook" data-toggle="modal" style="margin-left: 10px " data-target="#exampleModalCenter">Edit</button>
                                            </div>
                                        </div>
                                    </div>


                                    <h4 class="card-title" style="margin-top: 20px; margin-bottom: 10px">Products To Return</h4>
                                    <div style="border: 1px solid #CED4DA; padding: 10px; border-radius: 8px; margin-top: 10px" >

                                        <table class="table order-list" style="margin-top: 0px">
                                            <thead>
                                            <tr>
                                                <td style="width: 5%; text-align: center"></td>
                                                {{--<td style="width: 20%; text-align: center" ><b>Product Type</b></td>--}}
                                                <td style="width: 25%; text-align: center"><b>Product Name</b></td>
                                                <td style="width: 15%; text-align: center"><b>Rate($)</b></td>
                                                <td style="width: 10%; text-align: center"><b>Carton</b></td>
                                                <td style="width: 10%; text-align: center"><b>piece</b></td>
                                                <td style="width: 15%; text-align: center"><b>Total Quantity</b></td>
                                                <td style="width: 20%; text-align: center"><b>Total</b></td>
                                            </tr>
                                            </thead>
                                        </table>

                                        <div class="scroll">
                                        <table class="table order-list">
                                            <tbody id="mytable">
                                            <tr>
                                                <td style="width: 5%"></td>

                                                <td  style="width: 25%">
                                                    <input type="text" data-row="1" tabindex="7" list="products" placeholder="Product Name" id="product_input" class="product_input_1 product_input input form-control">
                                                    <datalist id="products">

                                                        <?php

                                                        foreach ($cat_info as $key=>$value){
                                                        $cats = $cat_info[$key];
                                                        foreach ($cats as $key1=>$value){
                                                        $products = $cats[$key1];
                                                        $product_name = $products['p_name'];
                                                        $product_id = $products['p_id'];
                                                        $cat_name = $products['cat_name'];
                                                        $cat_id = $products['cat_id'];
                                                        ?>
                                                        <option data-pid="{{$product_id}}" data-cid="{{$cat_id}}" value="{{ $product_name }} ({{$cat_name}})">
                                                        <?php
                                                        }
                                                        }

                                                        ?>

                                                    </datalist>
                                                    <input type="hidden" id="product_type_1" name="product_type[]" class="product_type_1 product_type">
                                                    <input type="hidden" id="product_code_name_1" name="product_code[]" class="product_code_name_1 product_code_name">

                                                    {{--<span class="available_qt_1"></span>--}}
                                                </td>

                                                <td  style="width: 15%">
                                                    <div data-row="1" class="rate_div_1 rate_div" >
                                                        <input type="text"  class="input form-control" placeholder="Rate" data-validation="required">
                                                    </div>
                                                </td>

                                                <td  style="width: 10%">
                                                    <input type="text" data-row="1" tabindex="8" value="0" placeholder="Carton" class="input form-control carton_1 carton" name="carton[]" data-validation="required">
                                                    <input type="hidden" class="form-control qt_per_carton_1 qt_per_carton" name="qt_per_carton[]" data-validation="number">
                                                    {{--<input type="text" class="form-control av_qt_1 av_qt" name="av_qt[]" data-validation="required">--}}

                                                </td>

                                                <td  style="width: 10%">
                                                    <input type="text" data-row="1" tabindex="9" value="0" placeholder="Pieces" class="input form-control piece_1 piece" name="piece[]" data-validation="number">
                                                </td>
                                                <td  style="width: 15%">
                                                    <input type="text" data-row="1" value="" placeholder="Quantity" class="input form-control quantity_1 quantity" name="quantity[]" readonly data-validation="required">
                                                </td>
                                                <td  style="width: 20%">
                                                    <input type="text" name="total[]" data-row="1" placeholder="Total" class="input form-control total_1 total" readonly data-validation="required">
                                                </td>
                                            </tr>

                                            </tbody>

                                        </table>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-md-10"></div>
                                            <div class="col-md-2">
                                                <!-- <button type="button" onclick= "removerow()" class="deleterow"><b>- Row</b></button> -->
                                                <button type="button" class="btn btn-info pull-right" onclick= "addrow()"><b>+ Row </b></button>
                                            </div>
                                        </div>
                                    </div>



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
                                    <form action="{{url('get_memo_info_purchase_return')}}" method="post" >
                                    @csrf
                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-4">
                                            <span class="level_size">Start Date</span>
                                            <div class="input-group">
                                                <input type="text" id="startpicker" tabindex="1" name="from_date" required class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <span class="level_size">End Date</span>
                                            <div class="input-group">
                                                <input type="text" id="enddatepicker" tabindex="2" name="to_date" required  class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <span class="level_size">Select Memo</span>
                                            <div class="input-group">
                                                <input class="form-control input "  tabindex="3" list="memos" id="memo_input">
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





    </div>
    @stop

@section('js')
    <script type="text/javascript">
        var i=1;
        function addrow()
        {
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            });

            i++;
            var table = document.getElementById("mytable");
            var row = table.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);
            var cell6 = row.insertCell(5);
            var cell7 = row.insertCell(6);
            // var cell8 = row.insertCell(7);

            cell1.innerHTML='<button class="btn btn-danger" onclick="deleteRow(this)"><i class="fa fa-trash"></i></button>';
            cell2.innerHTML='<td><input type="text" data-row="'+i+'" placeholder="Product Name" list="products" id="product_input" class="product_input_'+i+' product_input input form-control">' +
                '<input type="hidden" id="product_type_'+i+'" name="product_type[]" class="product_type_'+i+' product_type">' +
                '<input type="hidden" id="product_code_name_'+i+'" name="product_code[]" class="product_code_name_'+i+' product_code_name">\n' +
                '</td>';

            cell3.innerHTML='<td><div data-row="'+i+'" class="input rate_div_'+i+' rate_div" name="rate[]"><input type="text" placeholder="Rate" class="form-control"> </div></td>';
            cell4.innerHTML='<input type="text" data-row="'+i+'" placeholder="Carton" class="input form-control carton_'+i+' carton" value="0" name="carton[]" data-validation="number"> ' +
                '<input type="hidden" name="qt_per_carton[]" class="input form-control qt_per_carton_'+i+'">' ;
            cell5.innerHTML='<input type="text" data-row="'+i+'" placeholder="Pieces" class="input form-control piece_'+i+' piece" value="0" name="piece[]" data-validation="number">';
            cell6.innerHTML='<input type="text" data-row="'+i+'" placeholder="Quantity" class="input form-control quantity_'+i+' quantity" name="quantity[]" readonly>';
            cell7.innerHTML='<input type="text" name="total[]" data-row="'+i+'" placeholder="Total" class="form-control total_'+i+' total" readonly>';
        }


        $('#supplier_input').on('input', function() {

            var value = $(this).val();
            var c_id = $('#suppliers [value="' + value + '"]').data('id');
            console.log(c_id);

            $('#supplier_id').val(c_id)
            // getClientInfo(c_id)

        });



        $(document).on('keyup','.product_input',function(){
            var row = $(this).data('row');
            var product_input = $('.product_input_'+row).val();

            var product_id = $('#products [value="' + product_input + '"]').data('pid');
            var cat_id = $('#products [value="' + product_input + '"]').data('cid');


            $('.product_type_'+row).val(cat_id)
            $('.product_code_name_'+row).val(product_id)

            bringRate(product_id, row);
            // getAvailableQuantity(row)
            bringQuantityPerCarton(row)

        });


        function bringRate(product_id, row){
            // var option2 = $('.product_list_'+row).val();
            var varJ = row;
            var token = $('#token').val();
            $.post('{{url('getRate')}}',{select2:product_id,l:varJ,_token: token},function(data){
                $('.rate_div_'+row).html(data).show();
            });
        }


        function bringQuantityPerCarton(row){
            var option2 = $('.product_code_name_'+row).val();
            console.log(option2);
            var varJ = row;
            var token = $('#token').val();
            $.post('{{url('getQuantityPerCarton')}}',{select2:option2,l:varJ,_token: token},function(data){
                // $('.qt_per_carton_'+row).html(data).show();
                $('.qt_per_carton_'+row).val(data);
            });
        }



        function sum()
        {
            var sum = 0;
            $('.total').each(function(){
                var ptotal = $(this).val();
                var total = parseFloat(ptotal.replace(",", ""));
                sum += total;
            });
            var mtotal = (sum).formatMoney(2, '.', ',');
            $('.column_total').val(mtotal);

        }

        function deleteRow(rowNum)
        {
            var i = rowNum.parentNode.parentNode.rowIndex;
            document.getElementById("mytable").deleteRow(i);
            sum();
        }
        $(document).ready(function(){

            Number.prototype.formatMoney = function(c, d, t){
                var n = this,
                    c = isNaN(c = Math.abs(c)) ? 2 : c,
                    d = d == undefined ? "." : d,
                    t = t == undefined ? "," : t,
                    s = n < 0 ? "-" : "",
                    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
                    j = (j = i.length) > 3 ? j % 3 : 0;
                return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
            };

            function totalCalculate(row)
            {
                var p = $('.rate_'+row).val();
                // console.log("rate: "+row)
                var rate = parseFloat(p.replace(",", ""));
                var qt_per_carton = $('.qt_per_carton_'+row).val();
                var carton = $('.carton_'+row).val();
                var piece = $('.piece_'+row).val();
                var available_qt = $('.av_qt_'+row).val();

                /*if (carton != null || carton<1){

                    var quantity = parseInt(carton*qt_per_carton) + parseInt(piece);
                    console.log(quantity);
                }else {
                    var quantity = piece;
                    console.log(quantity);
                }*/

                if (carton > 0 && piece>0){
                    var quantity = parseInt(carton*qt_per_carton) + parseInt(piece);
                }else if ((carton == 0 || carton == 0) && piece>0){
                    var quantity = piece;
                }else if ((piece == 0 || piece == 0) && carton>0){
                    var quantity = parseInt(carton*qt_per_carton);
                }


                    $('.quantity_'+row).val(quantity);
                    // var quantity = $('.quantity_'+row).val();

                    console.log(qt_per_carton+', '+carton+", "+piece);
                    var total = rate * quantity;
                    total = (total).formatMoney(2, '.', ',');
                    $('.total_'+row).val(total);
                    sum();
            }


            function setAllBlank(row){
                $('.total_'+row).val('0.00');
                $('.piece_'+row).val('0');
                $('.carton_'+row).val('0');
                $('.quantity_'+row).val('0');

            }


            $(document).on('click','.deleterow',function(){
                // var row = $(this).data('row');
                // totalCalculate(row);
                sum();
            })

            $(document).on('keyup','.total',function(){
                sum();
            })



            $(document).on('input','.rate',function(){
                var row = $(this).data('row');
                totalCalculate(row);
            });

            $(document).on('keyup','.piece',function(){
                var row = $(this).data('row');
                totalCalculate(row);
                quantityReturn(row);
            });

            $(document).on('change','.product_type', function(){
                var row = $(this).data('row');
                bringName(row);
                setAllBlank(row);
                $('.rate_'+row).val('0');
                // totalCalculate(row);
            });



            $(document).on('keyup','.carton',function(){
                var row = $(this).data('row');
                totalCalculate(row);
                quantityReturn(row);
            });

            $(document).on('change','.product_list', function(){
                var row = $(this).data('row');
                bringRate(row);
                bringQuantityPerCarton(row);
                bringAvailableQuantity(row);
            });

            $(document).on('change','#supplier', function(){
                bringAddress();
            });



            function bringName(row){
                var option = $('.product_type_'+row).val();
                var varI = row;
                var token = $('#token').val();
                $.post('{{url('getProductName')}}', {select:option,j:varI,_token:token}, function(data) {
                    $('.product_code_name_'+row).html(data).hide().show();
                    $('.js-example-basic-single').select2();
                });
            }





            function bringAvailableQuantity(row){
                var product_code = $('.product_list_'+row).val();
                var warehouse_id = $('.warehouse_id').val();
                // console.log(option2);
                var varJ = row;
                var token = $('#token').val();


                if (warehouse_id == '' && product_code != ''){
                    alert('select Warehouse')

                }if (warehouse_id != '' && product_code == ''){
                    alert('select Product')

                } else {

                    console.log("product_code_name:: "+ product_code+", warehouse_id:: "+warehouse_id)
                    var varJ = row;
                    var token = $('#token').val();
                    $.post('{{url('getAvailableQt')}}',{select2:product_code,warehouse_id:warehouse_id,l:varJ,_token: token},function(data){
                        $('.available_qt_'+row).html('Available Qt: '+data).show();
                        $('.av_qt_'+row).val(data);
                        console.log(data)
                    });
                }

                /*$.post('getAvailableQuantity',{select2:option2,l:varJ,_token: token},function(data){
                    // $('.qt_per_carton_'+row).html(data).show();
                    $('.available_qt_'+row).val(data);
                });*/
            }


            function quantityReturn(row){
                var ids= $('.product_list_'+row).val();
                var quantities= $('.quantity_'+row).val();
                var av_qt= $('.av_qt_'+row).val();

                if (quantities> av_qt){
                    alert("Quantity Exeeds Available Quantity")
                    $('.quantity_'+row).val('0')
                    $('.piece_'+row).val('0')
                    $('.carton_'+row).val('0')
                    $('.total_'+row).val('0.00')
                }
            }

            $('#newsupplier').change(function () {
                var supplierId = $(this).val();
                var token = $('#token').val();
                $.post(
                    '{{url('getSupplierAddress')}}',
                    {supplier_id : supplierId, _token: token},
                    function (data) {
                        $('#supplier_address').val(data);
                    }

                );
            });

            // onload = function (){ document.forms[0].discount.disabled = true; }
        });




        $("#startpicker").on("change",function (){
            var from_date = document.getElementById('startpicker').value
            var to_date = document.getElementById('enddatepicker').value
            console.log(from_date)
            console.log(to_date)

            getMemoByDate(from_date, to_date);

        });

        $("#enddatepicker").on("change",function (){
            var from_date = document.getElementById('startpicker').value
            var to_date = document.getElementById('enddatepicker').value
            console.log(from_date)
            console.log(to_date)
        });

        function getMemoByDate(from_date, to_date) {

            $.ajax({
                url: '{{url('get_purchase_return_memos_by_date')}}',
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
