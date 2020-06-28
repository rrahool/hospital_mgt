@extends('admin.master')

@section('mainContend')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Projects</h1>
        </div>
        <!-- /.col-lg-12 -->
        <a href="#" data-toggle="modal" data-target="#login-modal" class="col-lg-offset-4 col-lg-3 btn btn-warning text-center">Project Name</a>

        <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

            <div class="modal-dialog">
                <div class="loginmodal-container">
                    <h1>Project Name</h1><br>
                    {{ Form::open(['url'=>'create_project','method'=>'post']) }}
                        <input type="text" name="project_name" placeholder="Enter Project Name" required>
                        <input type="submit" name="save" class="login btn btn-warning" value="Save Changes">
                    {{ Form::close() }}


                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header text-warning"></h2>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-md-12">
            @include('admin.includes.error')
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    Projects
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Project Name</th>
                                <th>Edit/Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            @foreach($project_list as $value)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $value->project_name }}</td>
                                <td><a href="{{ url('delete_project/'.$value->id) }}" class="btn btn-danger text-center" onclick="return confirm('Are you sure to delete this?')">Delete</a></td>
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