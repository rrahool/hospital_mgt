@extends('admin.master')

@section('mainContend')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Expense List</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-warning">
                <div class="panel-heading text-warning">
                    Recent Expenses List
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>Entry No.</th>
                                <th>Date</th>
                                <th>Expense Type</th>
                                <th>Payment Method</th>
                                <th>Amount</th>
                                <th>Paid To</th>
                                <th>Paid By</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            @foreach($supplier_list as $value)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ date('d-M-Y',$value->entry_date) }}</td>
                                <td><?php if($value->name ==''){echo 'Payment';}else {echo $value->name;}?></td>
                                <td>{{ ucfirst($value->payment_type) }}</td>
                                <td>{{ number_format($value->amount,2) }}</td>
                                <td><?php if($value->paid_to) { echo $value->paid_to; } if($value->supplier_name) { echo $value->supplier_name; } ?></td>
                                <td>{{ ucfirst($value->username) }}</td>
                                <td>
                                    <a href="{{ url('expense_view_byid/'.$value->id) }}" class="btn btn-success text-center">View</a>  &nbsp;
                                    <a href="{{ url('expense_edit/'.$value->id) }}" class="btn btn-warning text-center">Edit</a>
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
    @endsection()