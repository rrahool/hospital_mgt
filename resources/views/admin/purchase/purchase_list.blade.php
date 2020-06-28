@extends('layout')

@section('main_content')

    <div class="content-body">


        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Purchase History</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h4>Purchase List</h4>
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
                                        <th>Entry No</th>
                                        <th>Entry Date</th>
                                        <th>Supplier Name</th>
                                        <th>View</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($purchase_list as $value)
                                        <tr class="odd gradeX">
                                            <td>{{ $value->id }}</td>
                                            <td>{{ date('d-M-Y',$value->entry_date) }}</td>
                                            <td>{{ $value->executive_name }}</td>
                                            <td class="center"><a href="{{ url('show_purchase_Byid/'.$value->id) }}" class="btn btn-success text-center">View</a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @stop
