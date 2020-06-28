<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    {{--@if(\Request::is('purchase_entry')){--}}
    {{--<meta name="csrf-token" content="{{ csrf_token() }}">--}}
    {{--}--}}
    {{--@endif--}}

    <title>Isratts -Inventory Management </title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('admin/css/bootstrap.min.css') }} " rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{ asset('admin/css/metisMenu.min.css') }}" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="{{ asset('admin/css/timeline.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('admin/css/startmin.css') }}" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="{{ asset('admin/css/morris.css') }}" rel="stylesheet">

    <link rel="shortcut icon" href="{{ asset('admin/login/ico/favicon.png') }}">

    <!-- Custom Fonts -->
    <link href="{{ asset('admin/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    {{--<link href="{{ asset('admin/css/hover-min.css') }}" rel="stylesheet">--}}
    {{--<link href="{{ asset('admin/css/animate.min.css') }}" rel="stylesheet">--}}

    <!-- DataTables CSS -->
    <link href="{{ asset('admin/css/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{ asset('admin/css/dataTables/dataTables.responsive.css') }}" rel="stylesheet">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>