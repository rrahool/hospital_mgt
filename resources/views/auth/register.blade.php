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

                                <h4 class="card-title">Create New User</h4>
                                <div class="basic-form">
                                    <form action="{{url('create-new-user')}}" method="post" >

                                        @csrf

                                        <div class="form-row margin_top_minus_10">
                                            <div class="form-group col-md-6">
                                                <span class="level_size">User Name</span>
                                                <input type="text" tabindex="1" name="user_name" class="input form-control" placeholder="User Name" data-validation="required" autofocus >
                                            </div>
                                            <div class="form-group col-md-6">
                                                <span class="level_size">Email Address</span>
                                                <input type="email" tabindex="3" name="email" class="input form-control" placeholder="Email Address" data-validation="required">
                                            </div>
                                        </div>

                                        <div class="form-row margin_top_minus_10">
                                            <div class="form-group col-md-6">
                                                <span class="level_size">Contact No</span>
                                                <input type="number" tabindex="3" name="contact_no" class="input form-control" placeholder="Contact No" data-validation="required">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <span class="level_size">User Type</span>
                                                <select tabindex="6" class="form-control" name="user_type" onChange="getUserType(this);" data-validation="required">
                                                    <option value="0">User</option>
                                                    <option value="1">Admin</option>
                                                </select></div>
                                        </div>


                                        <div class="form-group margin_top_minus_10">
                                            <span class="level_size">Address</span>
                                            <input type="text" tabindex="4" name="address" class="input form-control" placeholder="Address">
                                        </div>

                                        <div class="form-row margin_top_minus_10">
                                            <div class="form-group col-md-6">
                                                <span class="level_size">Password</span>
                                                <input type="password" tabindex="5" name="password" class="input form-control" placeholder="Password" data-validation="required">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <span class="level_size">Confirm Password</span>
                                                <input type="password" tabindex="6" name="confirm_password" class="input form-control" placeholder="Confirm Password" data-validation="required">
                                            </div>
                                        </div>

                                        <div id="select_access_menus">
                                            <div class="form-group ">
                                                <span class="level_size">Give Access From 'Account Create' Manu</span>
                                                <div class="form-group">
                                                    @foreach($account_create_menus as $menu)
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input" name="create_account_menus[]" value="{{$menu->id}}"><span class="level_size">{{$menu->manu_name}}</span></label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <span class="level_size">Give Access From 'Account Report' Manu</span>
                                                <div class="form-group">
                                                    @foreach($account_report_menus as $menu)
                                                        <div class="form-check form-check-inline">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input" name="account_report_menus[]" style="margin-top: 10px" value="{{$menu->id}}"><span class="level_size">{{$menu->manu_name}}</span></label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <span class="level_size">Give Access From 'Stock Input' Manu</span>
                                                <div class="form-group">
                                                    @foreach($stock_entry_menus as $menu)
                                                        <div class="form-check form-check-inline">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input" name="stock_entry_menus[]" style="margin-top: 10px" value="{{$menu->id}}"><span class="level_size">{{$menu->manu_name}}</span></label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <span class="level_size">Give Access From 'Stock Report' Manu</span>
                                                <div class="form-group">
                                                    @foreach($stock_report_menus as $menu)
                                                        <div class="form-check form-check-inline">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input" name="stock_report_menus[]" style="margin-top: 10px" value="{{$menu->id}}"><span class="level_size">{{$menu->manu_name}}</span></label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" tabindex="10" class="btn btn-dark">Create</button>
                                    </form>
                                </div>


                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- #/ container -->
    </div>


    <script>
        function getUserType(selected_option) {
            var value = selected_option.options[selected_option.selectedIndex].text;
            console.log(value)
            if (value == 'Admin') {
                document.getElementById('select_access_menus').style.display = 'none';
            }else if (value == 'User') {
                document.getElementById('select_access_menus').style.display = 'block';
            }
        }
    </script>

@endsection
