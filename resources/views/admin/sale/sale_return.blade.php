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
        .form-control {
            padding: 0.0rem !important;

        }

        .table th, .table td{
            padding: 0.2rem !important;
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
                    <h3 class="page-header">Sale Return</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>--}}


            <div class="row">
                @include('admin.includes.error')
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"> Sale Return</h4>
                            <div class="basic-form">
                                <form action="{{url('sale_return')}}" method="post" >

                                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                                    <div style="border: 1px solid #CED4DA; padding: 10px; border-radius: 8px; " >
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Date</span>
                                            <input class="input form-control" type="date" tabindex="1" value="{{ $date }}" name="entry_date">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <span class="level_size">Memo No</span>
                                            <input class="form-control" type="text" tabindex="2" name="memo_no" value="{{ $memo_no }}" readonly data-validation="required">
                                        </div>
                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Client Name</span>
                                            <input class="form-control input " placeholder="Client Name" autofocus tabindex="3" list="clients" id="client_input">
                                            <datalist id="clients">
                                                @foreach($client_info as $value)
                                                    <option data-id="{{$value->id}}" value="{{ $value->client_name }}">
                                                @endforeach
                                            </datalist>

                                            <input class="form-control input" type="hidden" id="client_id" name="client_id">

                                        </div>

                                        <div class="form-group col-md-6">
                                            <span class="level_size">Ref No:</span>
                                            <input class="input form-control" placeholder="Reference No" tabindex="4" type="text" value="" name="ref_no" >
                                        </div>
                                    </div>

                                    {{--<div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-12">
                                            <span class="level_size">Address</span>
                                            <input class="input form-control" placeholder="" type="text" id="client_address">
                                        </div>
                                    </div>--}}

                                        <div class="row margin_top_minus_10" style="margin-top: 0px;">
                                            <div class="col-md-8" style=" text-align: right">
                                                {{--<input type="checkbox" class="text-right chk2" name="">--}}
                                            </div>
                                            <div class="col-md-2 pull-right">
                                                <span class="level_size">Total</span>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" name="column_total" placeholder="Total" class="input form-control column_total" data-validation="required" readonly="">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-dark pull-left" >Submit</button>
                                                <button type="button" class="btn btn-facebook" data-toggle="modal" style="margin-left: 10px " data-target="#exampleModalCenter">Edit</button>
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="card-title" style="margin-top: 20px; margin-bottom: 10px">Products To Return</h4>
                                    <div style="border: 1px solid #CED4DA; padding: 10px; border-radius: 8px; margin-top: 10px" >

                                        <table class="table order-list" style="margin-top: 0px">


                                            <thead>
                                            <tr>
                                                <td style="width: 5%"></td>
                                                <td  style="width: 20%; text-align: center"><b>Warehouse</b></td>
                                                {{--<td  style="width: 20%; text-align: center"><b>Product Type</b></td>--}}
                                                <td style="width: 20%; text-align: center"><b>Name</b></td>
                                                <td style="width: 15%; text-align: center"><b>Rate($)</b></td>
                                                <td style="width: 5%; text-align: center"><b>Carton</b></td>
                                                <td style="width: 10%; text-align: center"><b>piece</b></td>
                                                <td style="width: 10%; text-align: center"><b>Total Quantity</b></td>
                                                <td style="width: 15%; text-align: center"><b>Total</b></td>
                                            </tr>
                                            </thead>
                                        </table>

                                        <div class="scroll">
                                            <table class="table order-list">
                                        <tbody id="mytable">

                                        <tr>
                                            <td style="width: 5%"></td>
                                            <td style="width: 20%">
                                                <select  data-row="1" name="warehouse[]" tabindex="5" class="js-example-basic-single input form-control warehouse_1 warehouse" data-validation="required">
                                                    <option value="">Select Warehouse</option>
                                                    @foreach($warehouse_info as $value)
                                                        <option value="{{$value->id}}">{{ $value->warehouse_name     }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td style="width: 20%">
                                                <input type="text" data-row="1" tabindex="6" placeholder="Product Name" list="products" id="product_input" class="product_input_1 product_input input form-control">
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
                                                <span class="available_qt_1"></span>
                                            </td>


                                            <td style="width: 15%">
                                                <div data-row="1" class="input rate_div_1 rate_div" >
                                                    <input type="text" class="input form-control" placeholder="Rate" data-validation="required">
                                                </div>
                                            </td>

                                            <td style="width: 5%">
                                                <input type="text" data-row="1" tabindex="7" value="0" placeholder="Carton" class="input form-control carton_1 carton" name="carton[]" data-validation="number">
                                                <input type="hidden" class="form-control qt_per_carton_1 qt_per_carton" name="qt_per_carton[]">

                                            </td>

                                            <td style="width: 10%">
                                                <input type="text" data-row="1" tabindex="8" placeholder="Pieces" value="0" class="input form-control piece_1 piece" name="piece[]"data-validation="number">
                                            </td>
                                            <td style="width: 10%">
                                                <input type="text" data-row="1" value="" placeholder="Quantity" class="input form-control quantity_1 quantity" name="quantity[]" readonly data-validation="required">
                                            </td>
                                            <td style="width: 15%">
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
                                            <button type="button" tabindex="9" class="btn btn-info pull-right" onclick= "addrow()"><b>+ Row </b></button>
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
                                <form action="{{url('get_memo_info_sale_return')}}" method="post" >
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



@stop

@section('js')
    <script>


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
            var cell8 = row.insertCell(7);
            // var cell9 = row.insertCell(8);

            cell1.innerHTML='<button class="btn btn-danger" onclick="deleteRow(this)"><i class="fa fa-trash"></i></button>';
            cell2.innerHTML='<select name="warehouse[]" data-row="'+i+'" class="js-example-basic-single input form-control warehouse_'+i+' warehouse" data-validation="required"><option>Select Warehouse</option><?php foreach ($warehouse_info as $type) {?>  <option value="<?=$type->id ?>"><?=$type->warehouse_name ?></option><?php } ?></select>';
            cell3.innerHTML='<td><input type="text" placeholder="Product Name" data-row="'+i+'" list="products" id="product_input" class="product_input_'+i+' product_input input form-control">' +
                '<input type="hidden" id="product_type_'+i+'" name="product_type[]" class="product_type_'+i+' product_type">\n' +
                '<input type="hidden" id="product_code_name_'+i+'" name="product_code[]" class="product_code_name_'+i+' product_code_name">\n' +
                '<span class="available_qt_'+i+'"></span> </td>';
            cell4.innerHTML='<td><div data-row="'+i+'" class="rate_div_'+i+' rate_div" name="rate[]"><input type="text" placeholder="Rate" class="input form-control" data-validation="required"> </div></td>';
            cell5.innerHTML='<input type="text" data-row="'+i+'" class="input form-control carton_'+i+' carton" placeholder="Carton" value="0" name="carton[]" data-validation="number"> ' +
                '<input type="hidden" name="qt_per_carton[]" class="form-control qt_per_carton_'+i+'" data-validation="required">';
            cell6.innerHTML='<input type="text" data-row="'+i+'" placeholder="Pieces" class="input form-control piece_'+i+' piece" value="0" name="piece[]" data-validation="number">';
            cell7.innerHTML='<input type="text" data-row="'+i+'" placeholder="Quantity" class="input form-control quantity_'+i+' quantity" name="quantity[]" readonly data-validation="required">';
            cell8.innerHTML='<input type="text" name="total[]" data-row="'+i+'" placeholder="Total" class="form-control total_'+i+' total" readonly data-validation="required">';
        }


        function sum()
        {
            var sum = 0;
            $('.total').each(function(){
                var ptotal = $(this).val();
                //var rTotal = ptotal.replace(",", "");
                var rTotal = ptotal.replace(/,/g, '');
                var total = parseFloat(rTotal);
                // alert(rTotal);
                sum += total;
            });
            var mtotal = (sum).formatMoney(2, '.', ',');
            $('.column_total').val(mtotal);

            var pvat = $('.pvat').val();
            var avat = $('.vat').val();
            var aavat = parseFloat(avat.replace(",", ""));
            var ppvat = parseFloat(pvat.replace(",", ""));
            var vvat = (ppvat > 0) ? (sum * ppvat) / 100 : aavat ;
            var vat = (vvat).formatMoney(2, '.', ',');
            $('.vat').val(vat);

            var ptax = $('.ptax').val();
            var pptax = parseFloat(ptax.replace(",", ""));
            var vtax = (sum * pptax) / 100 ;
            var tax = (vtax).formatMoney(2, '.', ',');
            $('.tax').val(tax);

            // var ppdiscount = $('.discount').val();
            // var pdiscount = parseFloat(ppdiscount.replace(",", ""));
            // var discount = (pdiscount).formatMoney(2, '.', ',');

            var pdiscount = $('.pdiscount').val();
            var discount = $('.discount').val();
            var adiscount = parseFloat(discount.replace(",", ""));
            var ppdiscount = parseFloat(pdiscount.replace(",", ""));
            var vdiscount = (ppdiscount > 0) ? (sum * ppdiscount) / 100 : adiscount ;
            discount = (vdiscount).formatMoney(2, '.', ',');
            $('.discount').val(discount);

            var pbalance = sum + vvat + vtax - vdiscount ;
            var balance = (pbalance).formatMoney(2, '.', ',');
            $('.balance').val(balance);
        }


        $('#client_input').on('input', function() {

            var value = $(this).val();
            var c_id = $('#clients [value="' + value + '"]').data('id');
            console.log(c_id);

            $('#client_id').val(c_id)
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
            getAvailableQuantity(row)
            bringQuantityPerCarton(row)

        });

        function bringRate(product_id, row){
            // var option2 = $('.product_list_'+row).val();
            var varJ = row;
            var token = $('#token').val();
            $.post('getRate',{select2:product_id,l:varJ,_token: token},function(data){
                $('.rate_div_'+row).html(data).show();
            });
        }


        function getAvailableQuantity(row) {

            // console.log('sj')

            var product_code = $('.product_code_name_'+row).val();
            var warehouse_id = $('.warehouse_'+row).val();
            /*

                        if (warehouse_id == '' && product_code != ''){
                            alert('select Warehouse')

                        }if (warehouse_id != '' && product_code == ''){
                            alert('select Product')

                        } else {
            */

            console.log("product_code_name:: "+ product_code+", warehouse_id:: "+warehouse_id)
            var varJ = row;
            var token = $('#token').val();
            $.post('getAvailableQt',{select2:product_code,warehouse_id:warehouse_id,l:varJ,_token: token},function(data){
                $('.available_qt_'+row).html("Available qt: "+data).show();
            });
            // }

        }


        function bringQuantityPerCarton(row){
            var option2 = $('.product_code_name_'+row).val();
            console.log(option2);
            var varJ = row;
            var token = $('#token').val();
            $.post('getQuantityPerCarton',{select2:option2,l:varJ,_token: token},function(data){
                // $('.qt_per_carton_'+row).html(data).show();
                $('.qt_per_carton_'+row).val(data);
            });
        }


        function deleteRow(rowNum)
        {
            var i = rowNum.parentNode.parentNode.rowIndex;
            document.getElementById("mytable").deleteRow(i);
            sum();
        }

        //get product type ......

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
                var rate = parseFloat(p.replace(",", ""));
                var qt_per_carton = $('.qt_per_carton_'+row).val();
                var carton = $('.carton_'+row).val();
                var piece = $('.piece_'+row).val();


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
                sum();
            })

            $(document).on('input','.discount',function(){
                sum();
            })

            $(document).on('keyup','.total',function(){
                sum();
            })

            $(document).on('input','.pdiscount', function(){
                sum();
            });

            $(document).on('input','.pvat', function(){
                sum();
            });

            $(document).on('input','.vat', function(){
                sum();
            });

            $(document).on('input','.ptax', function(){
                sum();
            });

            $(document).on('input','.rate',function(){
                var row = $(this).data('row');
                totalCalculate(row);
            });

            $(document).on('keyup','.carton',function(){
                var row = $(this).data('row');
                // quantity(row);
                totalCalculate(row);
                // console.log('piece keyup')
            });

            $(document).on('keyup','.piece',function(){
                var row = $(this).data('row');
                totalCalculate(row);
                quantity(row);
            });

            $(document).on('change','.product_type', function(){
                var row = $(this).data('row');
                //console.log(row)
                bringName(row);
                setAllBlank(row);
                $('.rate_'+row).val('0');
                totalCalculate(row);
            });

            $(document).on('change','.product_code_name', function(){
                var row = $(this).data('row');
                setAllBlank(row);
                totalCalculate(row);
            });


            $(document).on('change','.product_list', function(){
                var row = $(this).data('row');
                bringRate(row);
                bringQuantityPerCarton(row);

            });

            $(document).on('change','.warehouse', function(){
                var row = $(this).data('row');
                getAvailableQuantity(row);
            });


            function bringName(row){
                var option = $('.product_type_'+row).val();
                //console.log(option)
                var token = $('#token').val();
                var varI = row;

                console.log(token)
                console.log(varI)

                $.post('getProductName', {select:option,j:varI, _token: token}, function(data) {
                    //alert(data);
                    $('.product_code_name_'+row).html(data).hide().show();
                    $('.js-example-basic-single').select2();
                });
            }



            function bringQuantityPerCarton(row){
                var option2 = $('.product_list_'+row).val();
                console.log(option2);
                var varJ = row;
                var token = $('#token').val();
                $.post('getQuantityPerCarton',{select2:option2,l:varJ,_token: token},function(data){
                    // $('.qt_per_carton_'+row).html(data).show();
                    $('.qt_per_carton_'+row).val(data);
                });
            }

            // function quantity(row){
            //     var ids= $('.product_list_'+row).val();
            //     var quantities= $('.quantity_'+row).val();
            //     var token = $('#token').val();
            //     $.post('getQuantity',{quantity:quantities,id:ids, _token: token},function(data){
            //         $('.quantity_'+row).html(data).show();
            //         if(data == "false"){
            //             alert('Quantity not available');
            //             $('.quantity_'+row).val("");
            //         }
            //     });
            // }

            // function bringAddress(){
            //     var option3 = $('#newsupplier').val();
            //     var token = $('token').va();
            //     alert(option3);
            //     // console.log(option3);
            //     $.post('getSupplierAddress',{select3:option3, _token: token},function(data){
            //         $('#supplier_address').html(data).show();
            //     });
            // }

            $('#newsupplier').change(function () {
                var supplierId = $(this).val();
                var token = $('#token').val();
                $.post(
                    'getSupplierAddress',
                    {supplier_id : supplierId, _token: token},
                    function (data) {
                        $('#supplier_address').val(data);
                    }

                );
            });

            $('.chk1').change(function(){
                $(".vat").prop("disabled", !$(this).is(':checked'));
                $(".pvat").prop("disabled", !$(this).is(':checked'));
            });

            $('.chk2').change(function(){
                $(".tax").prop("disabled", !$(this).is(':checked'));
                $(".ptax").prop("disabled", !$(this).is(':checked'));
            });

            $('.chk3').change(function(){
                $(".discount").prop("disabled", !$(this).is(':checked'));
                $(".pdiscount").prop("disabled", !$(this).is(':checked'));
            });

            $(".tax").attr('disabled','disabled');
            $(".vat").attr('disabled','disabled');
            $(".vat_p").attr('disabled','disabled');
            $(".tax_p").attr('disabled','disabled');
            $(".discount_p").attr('disabled','disabled');
            $(".discount").attr('disabled','disabled');

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
                url: '{{url('get_sale_return_memos_by_date')}}',
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
