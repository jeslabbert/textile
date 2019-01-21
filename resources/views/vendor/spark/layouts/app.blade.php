<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name'))</title>

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600' rel='stylesheet' type='text/css'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet' type='text/css'>



    <!-- CSS -->
    <link href="{{ mix(Spark::usesRightToLeftTheme() ? 'css/app-rtl.css' : 'css/app.css') }}" rel="stylesheet">
<style>
    .commChartDiv {
        max-width: 600px;
        max-height: 400px;
    }
    /* The sidebar menu */
    .sidebar {
        height: 100%; /* 100% Full-height */
        width: 0; /* 0 width - change this with JavaScript */
        position: fixed; /* Stay in place */
        z-index: 1; /* Stay on top */
        top: 0;
        left: 0;
        background-color: #222d32; /* Black*/
        overflow-x: hidden; /* Disable horizontal scroll */
        padding-top: 60px; /* Place content 60px from the top */
        transition: 0.5s; /* 0.5 second transition effect to slide in the sidebar */
    }

    /* The sidebar links */
    .sidebar a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;

        color: #bababa;
        display: block;
        transition: 0.3s;
    }

    /* When you mouse over the navigation links, change their color */
    .sidebar a:hover {
        color: #f1f1f1;
    }

    /* Position and style the close button (top right corner) */
    .sidebar .closebtn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
    }

    /* The button used to open the sidebar */
    .openbtn {
        font-size: 20px;
        cursor: pointer;
        background-color: white;
        color: #111;
        padding: 10px 15px;
        border: none;
    }



    /* Style page content - use this if you want to push the page content to the right when you open the side navigation */
    #main {
        transition: margin-left .5s; /* If you want a transition effect */
        padding: 20px;
    }

    /* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
    @media screen and (max-height: 450px) {
        .sidebar {padding-top: 15px;}
        .sidebar a {font-size: 18px;}
    }
</style>
    <style>
        .sparknavli {
            max-height: 40px;
            list-style: none;
        }
    </style>
    <!-- Scripts -->
    @yield('scripts', '')

    <!-- Global Spark Object -->
    <script>
        window.Spark = <?php echo json_encode(array_merge(
            Spark::scriptVariables(), []
        )); ?>;
    </script>

</head>
<body>
@yield('sidebar')
    <div id="spark-app" v-cloak>
        <!-- Navigation -->
        <!--Main Navigation-->
    @if (Auth::check())
        @include('spark::nav.user')
    @else
        @include('spark::nav.guest')
    @endif
        {{--<header>--}}

            {{--<!-- Navbar -->--}}
            {{--<nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">--}}
                {{--<div class="container-fluid">--}}

                    {{--<!-- Brand -->--}}
                    {{--<a class="navbar-brand waves-effect" href="https://mdbootstrap.com/material-design-for-bootstrap/"--}}
                       {{--target="_blank">--}}
                        {{--<strong class="blue-text">MDB</strong>--}}
                    {{--</a>--}}

                    {{--<!-- Collapse -->--}}
                    {{--<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"--}}
                            {{--aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">--}}
                        {{--<span class="navbar-toggler-icon"></span>--}}
                    {{--</button>--}}
                {{----}}

                    {{--<!-- Links -->--}}
                    {{--<div class="collapse navbar-collapse" id="navbarSupportedContent">--}}

                        {{--<!-- Left -->--}}
                        {{--<ul class="navbar-nav mr-auto">--}}
                            {{--<li class="nav-item active">--}}
                                {{--<a class="nav-link waves-effect" href="#">Home--}}
                                    {{--<span class="sr-only">(current)</span>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            {{--<li class="nav-item">--}}
                                {{--<a class="nav-link waves-effect" href="https://mdbootstrap.com/material-design-for-bootstrap/"--}}
                                   {{--target="_blank">About MDB</a>--}}
                            {{--</li>--}}
                            {{--<li class="nav-item">--}}
                                {{--<a class="nav-link waves-effect" href="https://mdbootstrap.com/getting-started/" target="_blank">Free--}}
                                    {{--download</a>--}}
                            {{--</li>--}}
                            {{--<li class="nav-item">--}}
                                {{--<a class="nav-link waves-effect" href="https://mdbootstrap.com/bootstrap-tutorial/" target="_blank">Free--}}
                                    {{--tutorials</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}

                        {{--<!-- Right -->--}}
                        {{--<ul class="navbar-nav nav-flex-icons">--}}
                            {{--<li class="nav-item">--}}
                                {{--<a href="https://www.facebook.com/mdbootstrap" class="nav-link waves-effect" target="_blank">--}}
                                    {{--<i class="fa fa-facebook"></i>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            {{--<li class="nav-item">--}}
                                {{--<a href="https://twitter.com/MDBootstrap" class="nav-link waves-effect" target="_blank">--}}
                                    {{--<i class="fa fa-twitter"></i>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            {{--<li class="nav-item">--}}
                                {{--<a href="https://github.com/mdbootstrap/bootstrap-material-design" class="nav-link border border-light rounded waves-effect"--}}
                                   {{--target="_blank">--}}
                                    {{--<i class="fa fa-github mr-2"></i>MDB GitHub--}}
                                {{--</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}

                    {{--</div>--}}

                {{--</div>--}}
            {{--</nav>--}}
            {{--<!-- Navbar -->--}}

            {{--<!-- Sidebar -->--}}
            {{--<div class="sidebar-fixed position-fixed">--}}

                {{--<a class="logo-wrapper waves-effect">--}}
                    {{--<img src="https://mdbootstrap.com/img/logo/mdb-email.png" class="img-fluid" alt="">--}}
                {{--</a>--}}

                {{--<div class="list-group list-group-flush">--}}
                    {{--<a href="#" class="list-group-item active waves-effect">--}}
                        {{--<i class="fa fa-pie-chart mr-3"></i>Dashboard--}}
                    {{--</a>--}}
                    {{--<a href="#" class="list-group-item list-group-item-action waves-effect">--}}
                        {{--<i class="fa fa-user mr-3"></i>Profile</a>--}}
                    {{--<a href="#" class="list-group-item list-group-item-action waves-effect">--}}
                        {{--<i class="fa fa-table mr-3"></i>Tables</a>--}}
                    {{--<a href="#" class="list-group-item list-group-item-action waves-effect">--}}
                        {{--<i class="fa fa-map mr-3"></i>Maps</a>--}}
                    {{--<a href="#" class="list-group-item list-group-item-action waves-effect">--}}
                        {{--<i class="fa fa-money mr-3"></i>Orders</a>--}}
                {{--</div>--}}

            {{--</div>--}}
            {{--<!-- Sidebar -->--}}

        {{--</header>--}}


        <!-- Main Content -->
        <main class="py-4">
            @yield('content')
            {{--TODO Make sure it updates to current team correctly and has a pull out function to display name --}}
            {{--TODO Should only be on team specific pages--}}
            @if(Auth::User())
            <div class="sticky" style="position: fixed;
    top: 85px;
    right: 0;
    width: 25px;
"><div class="row">
                    <div style="padding-top: 2px; width: 30%;">
                        <a href="/settings/teams/{{Auth::User()->currentTeam->id}}" title="{{Auth::User()->currentTeam->name}}">
                        <img src="{{Auth::User()->currentTeam->photo_url}}" style="
    -webkit-box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);" class="spark-profile-photo">
                        </a>
                    </div>
                    {{--<div style="display: inline-block; padding-top: 5px;width: 80%;">--}}
                        {{--<small class="form-text text-muted col-md-12">{{Auth::User()->currentTeam->name}}</small>--}}

                    {{--</div>--}}
                </div>

            </div>
                @endif
        </main>

        <!-- Application Level Modals -->
        @if (Auth::check())
            @include('spark::modals.notifications')
            @include('spark::modals.support')
            @include('spark::modals.session-expired')
        @endif
    </div>

    <!-- JavaScript -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="/js/sweetalert.min.js"></script>

@yield('addscripts')
<script>
    /* Set the width of the sidebar to 250px and the left margin of the page content to 250px */
    function openNav() {
        document.getElementById("mySidebar").style.width = "250px";

    }

    /* Set the width of the sidebar to 0 and the left margin of the page content to 0 */
    function closeNav() {
        document.getElementById("mySidebar").style.width = "0";

    }
//    function openNav() {
//        document.getElementById("mySidebar").style.display = "block";
//    }
//    function closeNav() {
//        document.getElementById("mySidebar").style.display = "none";
//    }
</script>
</body>
</html>
