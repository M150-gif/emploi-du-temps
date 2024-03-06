<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Light Bootstrap Dashboard by Creative Tim</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="{{asset('assets/cssMaster/bootstrap.min.css')}}" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="{{asset('assets/cssMaster/animate.min.css')}}" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="{{asset('assets/cssMaster/light-bootstrap-dashboard.css?v=1.4.0')}}" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="{{asset('assets/cssMaster/demo.css')}}" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="{{asset('assets/cssMaster/pe-icon-7-stroke.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-color="blue" data-image="{{asset('assets/img/sidebar-4.jpg')}}">

    <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->

    	<div class="sidebar-wrapper">
            <div class="logo" style="display: flex;">
                <img src="{{asset('assets/img/logoofppt.png')}}" style="width: 40px;" alt="">
                <a href="https://www.1min30.com/wp-content/uploads/2019/02/Logo-OFPPT-1-2.jpg" class="simple-text" style="margin-left: 10px;font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                    Emploi
                </a>
            </div>

            <ul class="nav">
                <li class="active">
                    <a href="dashboard.html">
                        <i class="pe-7s-copy-file"></i>
                        <p>Nouveau Emploi</p>
                    </a>
                </li>
                <li>
                    <a href="user.html">
                        <i class="pe-7s-users"></i>
                        <p>Formateurs</p>
                    </a>
                </li>
                <li>
                    <a href="table.html">
                        <i class="pe-7s-menu"></i>
                        <p>Groupes</p>
                    </a>
                </li>
                <li>
                    <a href="typography.html">
                        <i class="pe-7s-user"></i>
                        <p>Par Formateur</p>
                    </a>
                </li>
                <li>
                    <a href="icons.html">
                        <i class="pe-7s-menu"></i>
                        <p>Par Groupe</p>
                    </a>
                </li>
				<li class="active-pro">
                    <a href="upgrade.html">
                        <i class="pe-7s-check"></i>
                        <p>Validé et Exporter</p>
                    </a>
                    <a href="upgrade.html">
                        <i class="pe-7s-settings"></i>
                        <p>Settings</p>
                    </a>
                </li>
            </ul>
    	</div>
    </div>

    <div class="main-panel" >
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid" >
                <div class="navbar-header" >
                    <img class="logoOfppt" src="{{asset('assets/img/ofpptLogo.png')}}" style="width: 70px; margin-top: 5px;margin-left: 38vw;" alt="ofpptLogo">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse">

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="">
                                <p style="color: black !important;"><i class="fa-solid fa-user"></i>  Account</p>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <p style="color: red !important;"> <i class="fa-solid fa-right-from-bracket"></i>  Log out</p>
                            </a>
                        </li>
						<li class="separator hidden-lg"></li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    {{$slot}}
                </div>



                <div class="row">
                 <!-- code -->
                </div>
            </div>
        </div>


        <footer class="footer">
            <!-- code -->
        </footer>

    </div>
</div>


</body>

    <!--   Core JS Files   -->
    <script src="{{asset('assets/js/jquery.3.2.1.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/js/bootstrap.min.js')}}" type="text/javascript"></script>

	<!--  Charts Plugin -->
	<script src="{{asset("assets/js/chartist.min.js")}}"></script>

    <!--  Notifications Plugin    -->
    <script src="{{asset('assets/js/bootstrap-notify.js')}}"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="{{asset('assets/js/light-bootstrap-dashboard.js?v=1.4.0')}}"></script>

	<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
	<script src="{{asset('assets/js/demo.js')}}"></script>

</html>
