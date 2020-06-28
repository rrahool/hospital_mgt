
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ISRATTS-Inventory Management System</title>

    <!-- CSS -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="{{ asset('admin/login/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/login/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/login/css/form-elements.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/login/css/style.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="{{ asset('admin/login/ico/favicon.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('admin/login/ico/apple-touch-icon-144-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('admin/login/ico/apple-touch-icon-114-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('admin/login/ico/apple-touch-icon-72-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('admin/login/ico/apple-touch-icon-57-precomposed.png') }}">

</head>

<body>

<!-- Top content -->
<div class="top-content">

    <div class="inner-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text">

                    <div class="description">
                        <h1 class="text-default"><strong>ISRATTS</strong></h1>
                        <strong>Inventory Management System</strong>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 form-box">
                    <div class="form-top">
                        <div class="form-top-left">
                            <h3 class="text-success">Login to access</h3>
                            <p class="text-default">Enter your username and password</p>
                        </div>
                        <div class="form-top-right">
                            <i class="fa fa-lock text-default"></i>
                        </div>
                    </div>
                    <div class="form-bottom">
                            {!! Form::open(['url'=>'login','method'=>'post','class'=>'login-form']) !!}
                            <div class="form-group">
                                <label class="sr-only" for="form-username">Username</label>
                                <input type="text" name="username" placeholder="user name" class="form-control" id="form-username">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="form-password">Password</label>
                                <input type="password" name="password" placeholder="Password..." class="form-control" id="form-password">
                            </div>
                            <button type="submit" class="btn">Sign in</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <!--    <div class="col-sm-6 col-sm-offset-3 social-login">
                       <h3>...or login with:</h3>
                       <div class="social-login-buttons">
                           <a class="btn btn-link-2" href="#">
                               <i class="fa fa-facebook"></i> Facebook
                           </a>
                           <a class="btn btn-link-2" href="#">
                               <i class="fa fa-twitter"></i> Twitter
                           </a>
                           <a class="btn btn-link-2" href="#">
                               <i class="fa fa-google-plus"></i> Google Plus
                           </a>
                       </div>
                   </div> -->
            </div>
        </div>
    </div>

</div>


<!-- Javascript -->
<script src="{{ asset('admin/login/js/jquery-1.11.1.min.js') }}"></script>
<script src="{{ asset('admin/login/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('admin/login/js/jquery.backstretch.min.js') }}"></script>
{{--<script src="{{ asset('admin/login/js/scripts.js') }}"></script>--}}
<script src="{{ asset('admin/login/js/placeholder.js') }}"></script>

<script>

    jQuery(document).ready(function() {

        /*
            Fullscreen background
        */
        $.backstretch([
            "admin/login/img/backgrounds/2.jpg"
            , "admin/login/img/backgrounds/3.jpg"
            , "admin/login/img/backgrounds/1.jpg"
        ], {duration: 3000, fade: 750});

        /*
            Form validation
        */
        $('.login-form input[type="text"], .login-form input[type="password"], .login-form textarea').on('focus', function() {
            $(this).removeClass('input-error');
        });

        $('.login-form').on('submit', function(e) {

            $(this).find('input[type="text"], input[type="password"], textarea').each(function(){
                if( $(this).val() == "" ) {
                    e.preventDefault();
                    $(this).addClass('input-error');
                }
                else {
                    $(this).removeClass('input-error');
                }
            });

        });


    });

</script>
<!--[if lt IE 10]>


<![endif]-->

</body>

</html>