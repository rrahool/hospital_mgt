

@extends('layout')

@section('main_content')
    <div class="content-body">

        <div class="container-fluid">
            @if(session()->has('message.level'))
                <div class="alert alert-{{ session('message.level') }}">
                    {!! session('message.content') !!}
                </div>
            @endif

            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Create Group</h4>
                            <div class="basic-form">
                                <form action="{{url('create-new-group')}}" method="post" >

                                    @csrf

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Group Name</label>
                                            <input type="text" name="group_name" class="form-control" placeholder="Group Name">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Group Code</label>
                                            <input type="text" name="group_code" class="form-control" placeholder="Group Code">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Parent Group</label>
                                        <select id="inputState" class="form-control" name="parent_group">
                                            @foreach($groups as $group)
                                                <option value="{{$group->id}}">{{$group->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-dark">Create</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- #/ container -->
    </div>


@endsection
