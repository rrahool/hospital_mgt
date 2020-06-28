@extends('admin.master')

@section('mainContend')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Client Payement List</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-success">
                <div class="panel-heading text-success">
                    Client Payement List
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Client Name</th>
                                <th>Address</th>
                                <th>Amount</th>
                                <th>Payment method</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($payemt_list as $value)
                            <tr class="odd gradeX">
                                <td>{{ date('d-M-Y',$value->entry_date) }}</td>
                                <td>{{ $value->client_name }}</td>
                                <td>{{ $value->address }}</td>
                                <td>{{ $value->amount }}</td>
                                <td>{{ $value->payment_type }}</td>
                                <td class="getSize">
                                    <a href="{{ url('payment_view/'.$value->pId) }}" class="btn btn-success text-center"><i class="fa fa-eye"></i></a>
                                    <a href="{{ url('payment_edit/'.$value->pId) }}" class="btn btn-warning text-center"><i class="fa fa-edit"></i></a></td>
                            </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->

                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <style>
        .getSize{
            width: 125px !important;
        }
    </style>
    @stop