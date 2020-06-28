@extends('layout')

@section('main_content')

    <div class="content-body">


        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h4>Supplier List</h4>
                            </div>
                            @include('admin.includes.error')

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">

                                    <thead>
                                    <tr>
                                        <th>Supplier Name</th>
                                        <th>Executive Name</th>
                                        <th>Address</th>
                                        <th>Contact No</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($all_supplier as $value)
                                        <tr class="odd gradeX">
                                            <td>{{ $value->supplier_name }}</td>
                                            <td>{{ $value->executive_name}}</td>
                                            <td>{{ $value->address }}</td>
                                            <td >{{ $value->contact_no }}</td>
                                            <td class="getSize">
                                                <a href="{{ url('supplier_show/'.$value->id) }}" class="btn btn-primary text-center"><i class="fa fa-eye"></i></a>
                                                <a href="{{ url('supplier_edit/'.$value->id) }}" class="btn btn-success text-center"><i class="fa fa-edit"></i></a>
                                                <a href="{{ url('supplier_delete/'.$value->id) }}" class="btn btn-danger text-center" onclick="return confirm('Are you sure to delete this?')"><i class="fa fa-trash" ></i></a></td>
                                            </td>
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
