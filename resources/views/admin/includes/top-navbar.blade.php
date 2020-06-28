 <div class="navbar-header">
        <a class="navbar-brand" style="color:#ffb732;" href="index.html">
            @if($user)
                {{ ucwords($user->cname) }}
                @endif
        </a>
    </div>

    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>

    <ul class="nav navbar-nav navbar-left navbar-top-links" style="margin-left:150px;">
        <li><a href="{{ url('add_product') }}" class="hvr hvr-underline-from-center"><i class="fa fa-cube"></i>&nbsp;Add New Product</a></li>
        <li><a href="{{ url('create_sell') }}"><i class="fa fa-building-o"></i>&nbsp;Create Sale Invoice</a></li>
        <li><a href="{{url('purchase_entry')}}"><i class="fa fa-credit-card"></i>&nbsp;Create Purchase Payment</a></li>
        <li><a href="{{ url('add_client') }}"><i class="fa fa-male"></i>&nbsp;Add Customer</a></li>
    </ul>

    <ul class="nav navbar-right navbar-top-links">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" style="color:white;" href="#">
                <i class="fa fa-user fa-fw"></i>Administrator <b class="caret"></b>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                </li>
                <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out"></i> Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
    </ul>