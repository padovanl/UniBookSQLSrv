<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Unibook</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<<<<<<< HEAD
    <link href='https://fonts.googleapis.com/css?family=Roboto Slab' rel='stylesheet'></style>
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'></style>
    <link href="assets/css/home.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/1e803d693b.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
<div class="wrapper">

      <header class="main-head">
        <div class="name">
          <div class="marcato">UNI</div>
          <div class="fino">BOOK</div>
        </div>
        <div class="middle-nav">
          <div class="growing-search">
            <div class="input">
              <input type="text" name="search"/>
            </div><!-- Space hack -->
            <div class="submit">
              <button type="submit" id="search" name="go_search">
                <span class="fa fa-search"></span>
              </button>
            </div>
          </div>
=======
    <link href="../../assets/css/facebook.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>


  
  <div class="wrapper">
      <div class="box">
          <div class="row row-offcanvas row-offcanvas-left">
              <!-- main right col -->
              <div class="column col-sm-12 col-xs-11 col-offeset-4" id="main">

                  <!-- top nav -->
                  <div class="navbar navbar-blue navbar-static-top navbar-center">
                      <div class="navbar-header">
                          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                              <span class="sr-only">Toggle</span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                          </button>
                          <a href="/" class="navbar-brand logo">b</a>
                      </div>
                      <nav class="collapse navbar-collapse" role="navigation">
                          <form class="navbar-form navbar-left" action="/search" method="GET">
                              <div class="input-group input-group-sm" style="max-width:360px;">
                                  <input class="form-control" placeholder="Search" name="search-term" id="search-term" type="text">
                                  <div class="input-group-btn">
                                      <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                  </div>
                              </div>
                          </form>
                          <ul class="nav navbar-nav navbar-center">
                              <li>
                                  <a href="#"><i class="glyphicon glyphicon-home"></i> Home</a>
                              </li>
                              <li>
                                  <a href="#postModal" role="button" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i> Message</a>
                              </li>
                              <li>
                                  <a href="#"><span class="badge">{{$logged_user -> name}} {{$logged_user -> surname}}</span></a>
                              </li>
                          </ul>
                          <ul class="nav navbar-nav navbar-right">
                              <li>
                                  <a href="/message"><span class="badge badge-success">2</span>&nbsp;&nbsp;Messaggi</a>
                              </li>
                              <li class="dropdown">
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i></a>
                                  <ul class="dropdown-menu">
                                      <li><a href="">Report..</a></li>
                                      <li><a href="">Activity Log</a></li>
                                      <li><a href="">Settings</a></li>
                                      <li><a href="">About UniBook</a></li>
                        				      @if($logged_user->admin == 1)
                          				      <li class="divider"></li>
                          				      <li><a href="/admin"><i class="fa fa-desktop" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Dashboard</a></li>
                        				      @endif
                        				      <li class="divider"></li>
                                      <li><a href="/logout">Logout</a></li>
                                  </ul>
                              </li>
                          </ul>
                      </nav>
                  </div>
>>>>>>> 9e6fae337edba5e653811eba76748565b34a4bbd

          <div id="notifiche">
            <i class="fa fa-user fa-lg" aria-hidden="true"></i>
            <i class="fa fa-bell fa-lg" aria-hidden="true"></i>
            <i class="fa fa-commenting fa-lg" aria-hidden="true"></i>
          </div>
        </div>

        <div id="avatar"><div id="name-nav">{{$logged_user -> name . ' ' . $logged_user -> surname}}</div><img src="{{$logged_user -> pic_path}}" alt="Avatar"></div>

      </header>

      <nav class="main-nav">
        <div class="side-sec">
          <img id="main_avatar" src="{{$logged_user -> pic_path}}" alt="Avatar">
          <span id="side-name">{{$logged_user -> name . ' ' . $logged_user -> surname}}</span>
          <hr>
          <ul class="nav-links">
              <li><button class="btn btn-round color-1 material-design" data-color="#ffffff"><span class="fa fa-home" aria-hidden="true"></span> Timeline</button></li>
              <li><button class="btn btn-border btn-round color-1 material-design" data-color="#426FC5"><span class="fa fa-commenting" aria-hidden="true"></span> Messaggi</button></li>
              <li><button class="btn btn-border btn-round color-1 material-design" data-color="#426FC5"><span class="fa fa-book" aria-hidden="true"></span> Pagine</button></li>
          </ul>
        </div>
      </nav>

      <article class="content">
          @yield('content')
      </article>
      <aside class="side">
        {{-- @yield('suggested_friends') --}}
      </aside>
</div>
</body>
</html>
