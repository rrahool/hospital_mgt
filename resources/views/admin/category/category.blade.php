@extends('layout')

@section('main_content')
    <style>
        .input:focus {
            outline: none !important;
            border:1px solid #648FBE;
            box-shadow: 0 0 10px #719ECE;
        }
    </style>

    <div class="content-body">


        <div class="container-fluid">

            <div class="col-md-12">
                @include('admin.includes.error')
            </div>

            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add New Product Category</h4>
                            <div class="basic-form">

                                <div class="bootstrap-modal">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">Create New Category</button>

                                    <div class="modal fade" id="exampleModalCenter">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Category Information</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="basic-form">
                                                    <form action="{{url('category_value')}}" method="post" >
                                                        @csrf
                                                        <div class="form-group">
                                                            <input type="text" tabindex="1" name="category_name" class="input form-control" data-validation="required" placeholder="Enter Category Name">
                                                        </div>
                                                        {{--<div class="form-group">
                                                            <input type="text" name="category_code" class="input form-control" data-validation="required" placeholder="Code">
                                                        </div>--}}
                                                        <input type="submit" tabindex="2" name="save" class="btn btn-dark" value="Save">
                                                    </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h4>Categories</h4>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">

                                    <thead>
                                    <tr>
                                        <th>Serial No.</th>
                                        <th>Category Name</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($all_categories as $value)
                                        <tr class="odd gradeX">
                                            <td>{{ $value->id }}</td>
                                            <td>{{ $value->category_name }}</td>
                                            <td>
                                                <a href="{{ url('/getCatId/'.$value->id) }}" class="btn btn-success text-center">Edit</a> &nbsp; &nbsp;
                                                <a href="{{ url('/delete_Id/'.$value->id) }}" class="btn btn-danger text-center" onclick="return confirm('Are you sure to delete this?')">Delete</a></td>
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
