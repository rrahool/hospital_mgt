@extends('layout')

@section('main_content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-body">


        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Search L/C Info</h4>
                            <div class="basic-form">
                                <form action="{{url('lc_info')}}" method="post" target="_blank">
                                    @csrf

                                    <div class="form-group">
                                        <span class="level_size">L/C No</span>
                                        <select class="form-control" name="lc_id" data-validation="required">
                                            @foreach($lc_infos as $lc_info)
                                                <option value="{{$lc_info->id}}">{{$lc_info->lc_no}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>


    </div>

    <!-- /.content-wrapper -->


@endsection
