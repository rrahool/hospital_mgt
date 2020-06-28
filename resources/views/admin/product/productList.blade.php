@extends('layout')

@section('main_content')

    <div class="content-body">


        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h4>Product List</h4>
                            </div>


                                @if(session()->has('message.level'))
                                    <div class="alert alert-{{ session('message.level') }}">
                                        {!! session('message.content') !!}
                                    </div>
                                @endif

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>Product Type</th>
                                        <th>Product Name</th>
                                        <th>Cost Price</th>
                                        <th>Sell Price</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($notifications as $notification)
                                        <tr class="gradeU">
                                            <td>{{ $notification->cname }}</td>
                                            <td>{{ $notification->product_name }}</td>
                                            <td>{{ $notification->cost }}</td>
                                            <td>{{ $notification->sell }}</td>
                                            <td class="getSize cemter">
                                                <a href="{{ url('product_show/'.$value->p_id) }}" class="btn btn-primary text-center"><i class="fa fa-eye"></i></a>
                                                <a href="{{ url('product_edit/'.$value->p_id) }}" class="btn btn-success text-center"><i class="fa fa-edit"></i></a>
{{--                                                <a href="{{ url('product_delete/'.$value->p_id) }}" class="btn btn-danger text-center" onclick="return confirm('Are you sure to delete this?')"><i class="fa fa-trash" ></i></a></td>--}}
                                        </tr>
                                    @endforeach
                                    </tbody>

                                    <tfoot>
                                    <tr>
                                        <th>Product Type</th>
                                        <th>Product Name</th>
                                        <th>Cost Price</th>
                                        <th>Sell Price</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    <style>
        .getSize{
            width: 125px !important;
        }
    </style>
    @endsection
