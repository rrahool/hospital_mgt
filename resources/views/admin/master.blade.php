
@include('admin.includes.head')
<div id="wrapper">
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="color:#fff;background-color:#545454;">
    <!-- Navigation -->
     @include('admin.includes.top-navbar')
        <!-- /.navbar-top-links -->
        @include('admin.includes.side-nav-manu')
    </nav>

    <div id="page-wrapper" style="background-image: url(admin/images/bg.jpg);background-repeat:no-repeat;background-size:cover;">

        <!-- /.row -->
          @yield('mainContend')
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

</div>
@include('admin.includes.footer')

@yield('js')


