@extends('admin.master')

@section('mainContend')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-warning">Product List</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-warning">
                <div class="panel-heading text-warning">
                    Product List
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Supplie Name</th>
                                <th>Company Name</th>
                                <th>Amount</th>
                                <th>Payment Method</th>
                                <th>View</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($payment_list as $value)
                            <tr class="odd gradeX">
                                <td>{{ date('d-M-Y',$value->entry_date) }}</td>
                                <td>{{ $value->supplier_name }}</td>
                                <td>{{ $value->company_name }}</td>
                                <td>Tk.{{ $value->amount }}</td>
                                <td>{{ $value->payment_type }}</td>
                                <td class="center">
                                    <a href="{{ url('supplier_payment_view/'.$value->id) }}" class="btn btn-success text-center">View</a>
                                </td>
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
    <!-- /.ro
@stop