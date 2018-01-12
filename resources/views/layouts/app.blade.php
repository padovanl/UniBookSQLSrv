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

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link href="../../assets/css/admin/bootstrap.min.css" rel="stylesheet">


  <link href='https://fonts.googleapis.com/css?family=Roboto Slab' rel='stylesheet'></style>
  <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'></style>
  <link href="assets/css/home.css" rel="stylesheet">
  <script src="https://use.fontawesome.com/1e803d693b.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <meta name="_token" content="{{ csrf_token() }}">
  <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/thumb/e/ee/U-Bahn_Berlin_logo.svg/2000px-U-Bahn_Berlin_logo.svg">
</head>
<body>
<div class="wrapper">
      <header class="main-head">
        <div class="name">
          <div class="marcato">UNI</div><div class="fino">BOOK</div>
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

          <div id="notifiche">
            <a href="#"><i class="fa fa-user fa-lg" aria-hidden="true"></i></a>
            <a href="#"><i class="fa fa-bell fa-lg" aria-hidden="true"></i></a>
            <a href="/message" id="navBarMessages"><span class="fa-stack fa-1x has-badge" id="spanNewMessages"><i class="fa fa-commenting fa-stack-1x" aria-hidden="true"></i></span></a>
          </div>
        </div>
        <?php
        echo "<a href=\"profile/user/{{$logged_user -> id_user}}\">"
        ?>
          <div id="avatar"><div id="name-nav">{{$logged_user -> name . " " . $logged_user -> surname}}</div><img src="{{$logged_user ->pic_path}}" alt="Avatar"></div>
        </a>
      </header>
      <nav class="main-nav">
        <div class="side-sec">
          <img id="main_avatar" src="{{$logged_user -> pic_path}}" alt="Avatar">
          <span id="side-name">{{$logged_user -> name . " " . $logged_user -> surname}}</span>
          <hr>
          <ul class="nav-links">
              <li><button class="btn btn-round color-1 material-design" data-color="#ffffff" id="btnTimeline" onclick="window.location='/'"><span class="fa fa-home" aria-hidden="true"></span> Timeline</button></li>
              <li><button class="btn btn-border btn-round color-1 material-design" data-color="#426FC5" id="btnMessage" onclick="window.location='/message'"><span class="fa fa-commenting" aria-hidden="true"></span> Messaggi</button></li>
              <li><button class="btn btn-border btn-round color-1 material-design" data-color="#426FC5" id="btnPage"><span class="fa fa-book" aria-hidden="true"></span> Pagine</button></li>
              @if($logged_user->admin)
              <li><button class="btn btn-border btn-round color-1 material-design" data-color="#426FC5" id="btnAdmin" onclick="window.location='/admin'"><i class="fa fa-desktop" aria-hidden="true"></i>&nbsp;Dashboard</button></li>
              @endif
              <li><button class="btn btn-border btn-round color-1 material-design" data-color="#426FC5" id="btnLogout" onclick="window.location='/logout'"><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;Logout</button></li>
          </ul>
        </div>
      </nav>
        @yield('content')


      <!--prova nuovi messaggi-->
      <script>

        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $(document).ready(function(){
          $.ajax({
            dataType: 'json',
            type: 'POST',
            url: '/message/countNewMessage',
            data: { id_user: '{{$logged_user->id_user}}' }
          }).done(function (data) {
            if(data.newMessages > 0){
              var html = '&nbsp;&nbsp;<span class="badge badge-danger" style="font-size:10px;">' + data.newMessages + '</span>';
              $('#btnMessage').append(html);
              var htmlNavBar = '<span class="fa-stack fa-1x has-badge" id="spanNewMessages" data-count="' + data.newMessages + '"><i class="fa fa-commenting fa-stack-1x" aria-hidden="true"></i></span>';
              $('#navBarMessages').html(htmlNavBar);
            }else{
              var htmlNavBar = '<i class="fa fa-commenting" aria-hidden="true"></i>';
              $('#navBarMessages').html(htmlNavBar);
            }
          });
        });
      </script>
      <style type="text/css">
        .fa-stack[data-count]:after{
        position:absolute;
        right:0%;
        top:1%;
        content: attr(data-count);
        font-size:50%;
        padding:.6em;
        border-radius:999px;
        line-height:.75em;
        color: white;
        background:rgba(255,0,0,.85);
        text-align:center;
        min-width:2em;
        font-weight:bold;
      }
      </style>
</body>
</html>
