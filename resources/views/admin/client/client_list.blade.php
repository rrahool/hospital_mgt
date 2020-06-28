@extends('admin.master')

@section('mainContend')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">  Client List</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        @include('admin.includes.error')
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-success">
                <div class="panel-heading text-success">
                    <i class="fa fa-user"></i> Client List
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>Client Name</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Contact No</th>
                                <th>View/Edit/Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($all_client as $value)
                            <tr class="odd gradeX">
                                <td>{{ $value->client_name }}</td>
                                <td>{{ $value->address }}</td>
                                <td>{{ $value->email }}</td>
                                <td>{{ $value->contact_no }}</td>
                                <td>
                                    <a href="{{ url('client_show/'.$value->id) }}" class="btn btn-primary text-center"><i class="fa fa-eye"></i></a>
                                    <a href="{{ url('client_edit/'.$value->id) }}" class="btn btn-success text-center"><i class="fa fa-edit"></i></a>
                                    <a href="{{ url('client_delete/'.$value->id) }}" class="btn btn-danger text-center" onclick="return confirm('Are you sure to delete this?')"><i class="fa fa-trash" ></i></a></td>
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
    <!-- /.row---->
@stop