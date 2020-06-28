@extends('admin.master');

@section('mainContend')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-warning">Quotation Lists</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-warning">
                <div class="panel-heading text-warning">
                    Quotation List
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>EN</th>
                                <th>Entry Date</th>
                                <th>Client Name</th>
                                <th>Company Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($quotation_list as $value)
                            <tr class="odd gradeX">
                                <td>{{ $value->id }}</td>
                                <td>{{ date('d-M-Y',$value->entry_date) }}</td>
                                <td>{{ $value->client_name }}</td>
                                <td>{{ $value->company_name }}</td>
                                <td class="center">
                                    <a href="{{ url('quotation_view_Byid/'.$value->id) }}" class="btn btn-primary text-center"><i class="fa fa-eye"></i></a>
                                    <a href="{{ url('quotation_edit/'.$value->id) }}" class="btn btn-success text-center"><i class="fa fa-edit"></i></a>
                                    <a href="{{ url('quotation_invoice/'.$value->id) }}" class="btn btn-warning text-center">To Invoice</a>
                                    <a href="{{ url('quotation_delete/'.$value->id) }}" class="btn btn-danger text-center" onclick="return confirm('Are you sure to delete this?')"><i class="fa fa-trash-o"></i></a>
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
    @stop