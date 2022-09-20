<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ETShare') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/style.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>@media screen and (max-width: 750px) {
        #left_menu{
                display:none;
            }
    }
    #loading {
        background: url("{{asset('loader.gif')}}") no-repeat center rgba(0,0,0,0.8);
            opacity: 0.8;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            z-index: 9999999;
        }
    </style>
    @yield('pageCss')
</head>
<body class="bg-dark">
<nav class="navbar-expand-sm navbar navbar-dark sticky-top navbar-inverse" id="top_nav">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand fs-4 py-0 px-3 text-white" style="text-shadow: 2px 2px #7473b6;" href="#">ETShare <i class="fa-solid fa-bars text-white pl-3" id="bar_button"></i></a>
        </div>
        <div class="dropdown nav navbar-nav navbar-right">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('user_logo.png') }}" alt="" width="30" height="30" class="rounded-circle">
                        <span class="d-none d-sm-inline mx-1">Welcome {{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark  shadow" aria-labelledby="dropdownUser1">
                        <li> <a class="dropdown-item text-dark" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                        </li>
                        
                    </ul>
                </div>
    </div>
</nav>
<div class="container-fluid"> 
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 sticky-left" id="left_menu">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <a href="/" class="d-flex align-items-center mb-md-0 me-md-auto text-white text-decoration-none pb-3"><img src="{{asset('logo.png')}}" alt=""  width="60" height="60" class="rounded-circle ml-2">
                </a>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    <li class="nav-item">
                        <a href="/" class="nav-link align-middle px-0">
                        <i class="fas fa-home"></i><span class="ms-1 d-sm-inline">Home</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/cluster/join" class="nav-link align-middle px-0">
                        <i class="fa-solid fa-layer-group"></i><span class="ms-1 d-sm-inline">Join Cluster</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('cluster.create')}}" class="nav-link align-middle px-0">
                        <i class="fas fa-plus"></i><span class="ms-1 d-sm-inline">New Cluster</span>
                        </a>
                    </li>
                    <li>
                        <a href="/cluster" class="nav-link px-0 align-middle">
                        <i class="fa fa-list"></i> <span class="ms-1 d-sm-inline">Clusters</span> </a>
                    </li>
                    <li class="nav-item">
                        <a href="/cluster/to_do_list" class="nav-link align-middle px-0">
                        <i class="fa-solid fa-list-check"></i><span class="ms-1 d-sm-inline">To-Do</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link align-middle px-0">
                        <i class="fas fa-info"></i><span class="ms-1 d-sm-inline">Help</span>
                        </a>
                    </li>
                </ul>  
            </div>
        </div>
        <div class="col py-3">
            @yield('content')
            <footer class="fixed-bottom text-white" id="footer_div">
                <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2 float-right fs-6"><span
                            class="float-md-left d-block d-md-inline-block px-2">Copyright  &copy; 2022 | ETShare<span
                            class="float-md-right d-md-inline-blockd-none d-lg-block px-2">| made with <i class="fas fa-heart"></i> by Govind Singh</span>
                </p>
            </footer>
        </div>
    </div>
</div>
</body>
<script>
    $(document).ready(function(){
     $('#bar_button').click(function(){
        if($('#left_menu').css('display') == 'none'){
            $('#left_menu').fadeIn();
        }else{
            $('#left_menu').fadeOut();
        }
    }) ;
   
});
</script>
@yield('pageJs')
</html>
