<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Central City Hospital & Diagnostic</title>

    <style>
        element.style{
            min-height: auto !important;
        }

    </style>

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}">

    <link href="{{ asset('plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/tables/css/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
{{--    <link href="{{ asset('plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">--}}
    <!-- Page plugins css -->
{{--    <link href="{{ asset('plugins/clockpicker/dist/jquery-clockpicker.min.css') }}" rel="stylesheet">--}}
    <!-- Color picker plugins css -->
{{--    <link href="{{ asset('plugins/jquery-asColorPicker-master/css/asColorPicker.css') }}" rel="stylesheet">--}}
    <!-- Date picker plugins css -->
    <!-- Daterange picker plugins css -->
{{--    <link href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">--}}
{{--    <link href="{{ asset('plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">--}}

    <!-- Pignose Calender -->
{{--    <link href="{{ asset('plugins/pg-calendar/css/pignose.calendar.min.css') }} " rel="stylesheet">--}}

    <!-- Chartist -->
{{--<link rel="stylesheet" href="{{ asset('plugins/chartist/css/chartist.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css') }}">
--}}


    <!-- Custom Stylesheet -->

    <style>

        .brand-title h6{
            font-size: .95rem;
        }

        .card .card-body {
            padding: 0.5rem .5rem;
        }

        .header {
            height: 4rem;
            z-index: 1;
            position: relative;
            padding: 0 0.9375rem;
            background: #fff;
            margin-left: 15.1875rem;
            transition: all .2s ease;
        }

        .select2-selection__rendered {
            line-height: 32px !important;
            font-size: 0.775rem;

        }


        .select2-container .select2-selection--single {
            height: 32px !important;
            border: 1px solid #5F6368;
            border-radius: 0px;
            font-size: 0.775rem;
        }

        .select2-container .select2-selection--single:focus {
            outline: none !important;
            border:1px solid #648FBE;
            box-shadow: 0 0 10px #719ECE;
        }

        .form-control:focus {
            outline: none !important;
            border:1px solid #648FBE;
            box-shadow: 0 0 10px #719ECE;
        }

        .select2-selection__arrow {
            height: 32px !important;
        }



        .form-control{
            min-height: 32px;
            height: 32px;
            font-size: 0.775rem;
            border-color: #5F6368;
        }

        .level_size{
            font-size: 11px;
        }

        .level_size_title{
            font-size: 13px;
        }

        .level_size_card_title{
            font-size: 15px;
        }

        .margin_top_minus_10{
            margin-top: -10px
        }

        .menu_font_color{
            color: white;
        }

        .nk-sidebar .metismenu > li.active > a {
            background: #8B87FF;
            color: #ffffff; }

        .nk-sidebar .metismenu > li> a {
            background: #7571F9;
            color: #ffffff; }



        .nk-sidebar .metismenu > li > a:hover {
            color: #ffffff;
            background: #8B87FF;
            transition: all .2s ease; }



        [data-sibebarbg="color_1"] .nk-sidebar .metismenu > li ul a {
             color: #ffffff;
            background: #7571F9;
        }

        .nk-sidebar .metismenu .mega-menu ul.in li a:hover, .nk-sidebar .metismenu .mega-menu ul.in li a:focus, .nk-sidebar .metismenu .mega-menu ul.in li a.active {
            color: #ffffff;
            background: #8B87FF;
        }

        .nk-sidebar .metismenu .mega-menu ul.in li a:hover{
            color: #ffffff;
            background: #8B87FF;
            transition: all .2s ease;
        }

        .nk-sidebar .metismenu > li:hover span, .nk-sidebar .metismenu > li:focus span, .nk-sidebar .metismenu > li.active span {
            color: #ffffff}


        .nk-sidebar .metismenu a {
            position: relative;
            display: block;
            padding: 0.4125rem .8rem;
            outline-width: 0;
            transition: all .3s ease-out;
            color: #464a53;
        }

        .nk-sidebar .metismenu ul a {
            padding: 0.625rem 0.9375rem 0.1rem 2.8125rem; }

        body {
            margin: 0;
            font-family: "Roboto", sans-serif;
            font-size: 0.840rem;
            font-weight: 400;
            line-height: 1.5;
            color: #000000;
            text-align: left;
            background-color: #F3F3F9;
        }

        .input-group-text {
            line-height: 1;
        }

    </style>

</head>

<body >

<!--*******************
    Preloader start
********************-->
<div id="preloader">
    <div class="loader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
        </svg>
    </div>
</div>
<!--*******************
    Preloader end
********************-->


<!--**********************************
    Main wrapper start
***********************************-->
<div id="main-wrapper">

    <!--**********************************
        Nav header start
    ***********************************-->
    <div class="nav-header" style="border-bottom: 1px solid #ffffff">
        <div class="brand-logo">
            <a href="{{url('/')}}">
                <b class="logo-abbr"><img src="{{ asset('images/logo.png') }}" alt=""> </b>
                <span class="logo-compact"><img src="{{ asset('images/logo-compact.png') }}" alt=""></span>
                <span class="brand-title">
                    <h6 style="color: #FFF; font-family: tinymce-small">CENTRAL CITY HOSPITAL & DIAGNOSTIC</h6>
{{--                    <h5 style="color: #fff; font-family: tinymce-small">Chittagong, Bangladesh</h5>--}}
                </span>
            </a>
        </div>
    </div>
    <!--**********************************
        Nav header end
    ***********************************-->

    <!--**********************************
            Header start
        ***********************************-->
    <div class="header">
        <div class="header-content clearfix">

            <div class="nav-control">
                <div class="hamburger">
                    <span class="toggle-icon"><i class="icon-menu"></i></span>
                </div>
            </div>

            <div class="header-right">
                <ul class="clearfix">

                    <li class="icons dropdown">
                        <div class="user-img c-pointer position-relative"   data-toggle="dropdown">
                            <span class="activity active"></span>
                            <img src="{{ asset('images/user/1.png') }}" height="40" width="40" alt="">
                        </div>
                        <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                            <div class="dropdown-content-body">
                                <ul>
                                    <li><a href="{{url('logout')}}"><i class="icon-key"></i> <span>Logout</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--**********************************
        Header end ti-comment-alt
    ***********************************-->


    <!--**********************************
                Sidebar start
            ***********************************-->
    <div class="nk-sidebar" style="background: #7571F9; border-right: 1px solid #7571F9">
        <div class="nk-nav-scroll">
            <ul class="metismenu" id="menu" style="background: #7571F9 ;border-right: 1px solid #7571F9">

                <?php
                    $user_id = \Illuminate\Support\Facades\Auth::id();
                    $user_info = \Illuminate\Support\Facades\DB::table('users')->where('id', $user_id)->first();
                    $role = $user_info->role;
                ?>


                    <li >
                        <a href="{{url('/')}}" aria-expanded="false" class="a_bg">
                            <i class="icon-badge menu-icon" ></i><span class="nav-text" style="color: #ffffff;">Home</span>
                        </a>
                    </li>



                    <li >
                        <a href="{{url('create-doctor')}}" aria-expanded="false" class="a_bg">
                            <i class="icon-badge menu-icon" ></i><span class="nav-text" style="color: #ffffff;">Create Doctor</span>
                        </a>
                    </li>



                    <li >
                        <a href="{{url('test_category')}}" aria-expanded="false" class="a_bg">
                            <i class="icon-badge menu-icon" ></i><span class="nav-text" style="color: #ffffff;">Create Category </span>
                        </a>
                    </li>


                    <li >
                        <a href="{{url('add_test')}}" aria-expanded="false" class="a_bg">
                            <i class="icon-badge menu-icon" ></i><span class="nav-text" style="color: #ffffff;">Create Register</span>
                        </a>
                    </li>




                    <li >
                        <a href="{{url('create_test_memo')}}" aria-expanded="false" class="a_bg">
                            <i class="icon-badge menu-icon" ></i><span class="nav-text" style="color: #ffffff;">Create Invoice</span>
                        </a>
                    </li>


                    <li >
                        <a href="{{url('topsheet')}}" aria-expanded="false" class="a_bg">
                            <i class="icon-badge menu-icon" ></i><span class="nav-text" style="color: #ffffff;">Topsheet</span>
                        </a>
                    </li>



            </ul>
        </div>
    </div>
    <!--**********************************
        Sidebar end
    ***********************************-->


    <!--**********************************
        Content body start
    ***********************************-->
        @yield('main_content')
    <!--**********************************
        Content body end
    ***********************************-->


    <!--**********************************
        Footer start
    ***********************************-->
    <div class="footer">
        <div class="copyright">
            <p>Copyright &copy; Designed & Developed by <a href="#">Isratts Technologies</a> 2019</p>
        </div>
    </div>
    <!--**********************************
        Footer end
    ***********************************-->
</div>
<!--**********************************
    Main wrapper end
***********************************-->

<?php

use App\Ledger;
$journal_ledgers = Ledger::select('id', 'name')->where('type', 0)->get();

?>

<!--**********************************
    Scripts
***********************************-->
<script src="{{ asset('plugins/common/common.min.js') }}"></script>
<script src="{{ asset('js/custom.min.js') }}"></script>
<script src="{{ asset('js/settings.js') }}"></script>
<script src="{{ asset('js/gleek.js') }}"></script>
{{--<script src="{{ asset('js/styleSwitcher.js') }}"></script>--}}


<script src="{{ asset('plugins/moment/moment.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
<!-- Clock Plugin JavaScript -->


<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<!-- Date Picker Plugin JavaScript -->
<script src="{{ asset('plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/plugins-init/form-pickers-init.js') }}"></script>

<!-- Morrisjs -->
<script src="{{ asset('plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('plugins/morris/morris.min.js') }}"></script>

<!-- ChartistJS -->
{{--<script src="{{ asset('plugins/chartist/js/chartist.min.js') }}"></script>--}}
{{--<script src="{{ asset('plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js') }}"></script>--}}

<script src="{{ asset('plugins/tables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/tables/js/datatable/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/tables/js/datatable-init/datatable-basic.min.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>


{{--<script src="{{ asset('js/dashboard/dashboard-1.js') }}"></script>--}}

<script>

    $(document).ready(function() {
        $('.js-example-basic-single').select2();
        $('#js-example-basic-single-a').select2();

    });



    $(document).ready(function () {

        var counter = 0;

        $("#addrow_dr").on("click", function () {
            $('.js-example-basic-single').select2();
            var newRow = $("<tr>");
            var cols = "";

            cols += '<td style="width: 245px"><select name="dr_acc[]" id="" class="form-control js-example-basic-single" > <?php
                foreach ($journal_ledgers as $c){
                    echo '<option value="'.$c->id.'" >'.$c->name.'</option>';
                }
                ?>  </select></td>';
            cols += '<td><input type="text" class="form-control dr_amount" onkeyup="dr_sum()" name="dr_amount[]" placeholder="Amount" data-validation="number" data-validation-allowing="float"></td>';

            cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
            newRow.append(cols);
            $("table.dr-order-list").append(newRow);
            $('.js-example-basic-single').select2();
            counter++;
        });



        $("table.dr-order-list").on("click", ".ibtnDel", function (event) {
            $(this).closest("tr").remove();
            counter -= 1
            dr_sum();
        });


    });



    $(document).ready(function () {
        var counter = 0;

        $("#addrow_cr").on("click", function () {

            var newRow = $("<tr>");
            var cols = "";

            cols += '<td style="width: 245px"><select name="cr_acc[]" id="" class="form-control js-example-basic-single"> <?php
                foreach ($journal_ledgers as $c){
                    echo '<option value="'.$c->id.'">'.$c->name.'</option>';
                }
                ?>  </select></td>';
            cols += '<td><input type="text" class="form-control cr_amount" name="cr_amount[]" onkeyup="cr_sum()"/></td>';

            cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete" placeholder="Amount" data-validation="number" data-validation-allowing="float"></td>';
            newRow.append(cols);
            $("table.cr-order-list").append(newRow);
            $('.js-example-basic-single').select2();
            counter++;
        });



        $("table.cr-order-list").on("click", ".ibtnDel", function (event) {
            $(this).closest("tr").remove();
            counter -= 1
            cr_sum();
            });


    });



    function dr_sum() {

        var sum = 0;
        $('.dr_amount').each(function(){
            var ptotal = $(this).val();
            var total = parseFloat(ptotal.replace(/,/g, ""));
            sum += total;
        });

        //cr_in_word
        var in_word = convertNumberToWords(sum);
        if (in_word != ""){
            document.getElementById("dr_in_word").innerHTML = "(In Words: "+in_word+" Taka)";
        } else {
            document.getElementById("dr_in_word").innerHTML = "";

        }

        $('#dr_total').val(sum);
    }


    function cr_sum() {
        var sum = 0;
        $('.cr_amount').each(function(){
            var ptotal = $(this).val();
            var total = parseFloat(ptotal.replace(/,/g, ""));
            sum += total;
        });

        var in_word = convertNumberToWords(sum);
        if (in_word != ""){
            document.getElementById("cr_in_word").innerHTML = "(In Words: "+in_word+" Taka)";
        } else {
            document.getElementById("cr_in_word").innerHTML = "";

        }

        $('#cr_total').val(sum);
    }


    $(document).ready(function() {
        $('#type_id').on('change', function () {
            var parentID = $(this).val();
            console.log(parentID);
            if (parentID) {
                $.ajax({
                    type: 'GET',
                    url: 'get_heads',
                    data: 'parentID=' + parentID,
                    success: function (html) {
                        console.log(html);
                        $('#head_id').html(html);
                        //$('#head_id').niceSelect('update');
                    }
                });
            } else {
                $('#head_id').html('<option value="">-- Select Head Name --</option>');
            }
        });
    });

    $.validate({

    });


    /*$('#startpicker').datepicker('setDate', new Date());
    $('#enddatepicker').datepicker('setDate', new Date());*/

    // var defaultDate = new Date('m/d/Y');

    $( '.mydatepicker').datepicker({
        format:'mm/dd/yyyy',
    }).on('changeDate', function(ev){
        $('.mydatepicker').datepicker('hide');
    }).datepicker("setDate",'now');

    /*$('.enddatepicker').datepicker({
        format:'mm/dd/yyyy',
    }).datepicker("setDate",'now');*/


    $('.select2').select2();




    // getting amount in words
    function convertNumberToWords(amount) {
        var words = new Array();
        words[0] = '';
        words[1] = 'One';
        words[2] = 'Two';
        words[3] = 'Three';
        words[4] = 'Four';
        words[5] = 'Five';
        words[6] = 'Six';
        words[7] = 'Seven';
        words[8] = 'Eight';
        words[9] = 'Nine';
        words[10] = 'Ten';
        words[11] = 'Eleven';
        words[12] = 'Twelve';
        words[13] = 'Thirteen';
        words[14] = 'Fourteen';
        words[15] = 'Fifteen';
        words[16] = 'Sixteen';
        words[17] = 'Seventeen';
        words[18] = 'Eighteen';
        words[19] = 'Nineteen';
        words[20] = 'Twenty';
        words[30] = 'Thirty';
        words[40] = 'Forty';
        words[50] = 'Fifty';
        words[60] = 'Sixty';
        words[70] = 'Seventy';
        words[80] = 'Eighty';
        words[90] = 'Ninety';
        amount = amount.toString();
        var atemp = amount.split(".");
        var number = atemp[0].split(",").join("");
        var n_length = number.length;
        var words_string = "";
        if (n_length <= 9) {
            var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
            var received_n_array = new Array();
            for (var i = 0; i < n_length; i++) {
                received_n_array[i] = number.substr(i, 1);
            }
            for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
                n_array[i] = received_n_array[j];
            }
            for (var i = 0, j = 1; i < 9; i++, j++) {
                if (i == 0 || i == 2 || i == 4 || i == 7) {
                    if (n_array[i] == 1) {
                        n_array[j] = 10 + parseInt(n_array[j]);
                        n_array[i] = 0;
                    }
                }
            }
            value = "";
            for (var i = 0; i < 9; i++) {
                if (i == 0 || i == 2 || i == 4 || i == 7) {
                    value = n_array[i] * 10;
                } else {
                    value = n_array[i];
                }
                if (value != 0) {
                    words_string += words[value] + " ";
                }
                if ((i == 1 && value != 0) || (i == 0 && value != 0 && n_array[i + 1] == 0)) {
                    words_string += "Crores ";
                }
                if ((i == 3 && value != 0) || (i == 2 && value != 0 && n_array[i + 1] == 0)) {
                    words_string += "Lakhs ";
                }
                if ((i == 5 && value != 0) || (i == 4 && value != 0 && n_array[i + 1] == 0)) {
                    words_string += "Thousand ";
                }
                if (i == 6 && value != 0 && (n_array[i + 1] != 0 && n_array[i + 2] != 0)) {
                    words_string += "Hundred and ";
                } else if (i == 6 && value != 0) {
                    words_string += "Hundred ";
                }
            }
            words_string = words_string.split("  ").join(" ");
        }
        return words_string;
    }


</script>

@yield('js')

</body>

</html>
