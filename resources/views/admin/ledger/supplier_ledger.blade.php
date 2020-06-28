@extends('admin.master')

@section('mainContend')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Supplier Ledger</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-offset-1 col-lg-10">
            <div class="panel panel-warning">
                <div class="panel-heading text-warning">
                    Supplier Ledger View
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Supplier Name</th>
                                <th>Company</th>
                                <th>Ledger View</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i =1; ?>
                            @foreach($supplier_list as $value)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $value->supplier_name }}</td>
                                <td>{{ $value->company_name }}</td>
                                <td class="center"><a href="{{ url('view_supplier_ledger/'.$value->id )  }}" class="btn btn-warning text-center">View</a></td>
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
    @stop