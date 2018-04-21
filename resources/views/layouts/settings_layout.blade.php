<!DOCTYPE html>
<html lang="en">
<head>

  @include('includes.head')

  <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->


  <link href="/assets/css/home.css" rel="stylesheet">
  <script src="https://use.fontawesome.com/1e803d693b.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script type="text/javascript" src="../../../assets/js/jquery.powertip.js"></script>
  <link href="../../../assets/css/jquery.powertip.css" rel="stylesheet">

  <script src="/assets/js/page.js"></script>
  <!-- CSS per profile page-->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link href="../../../assets/css/profile_badge.css" rel="stylesheet">


  <!--Modal -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body class="wrapper">
        <header class="main-head">
          <div class="name" onclick="window.location='/';" style="cursor: pointer;">
            <div class="marcato">UNI</div><div class="fino">BOOK</div>
          </div>
         <div class="middle-nav">
          <div class="growing-search">
            <div class="input">
              <input type="text" name="search" id="searchtext"/>
            </div><!-- Space hack -->
            <div class="submit">
              <button type="submit" id="search" name="go_search" onclick="window.location='/search?search_term=' + encodeURI(document.getElementById('searchtext').value)">
				 <span class="fa fa-search"></span>
              </button>
            </div>
          </div>

            <div id="notifiche">
              <a href="{{url('friend/request')}}" id="navBarFriend"><span class="fa-stack fa-1x has-badge" id="spanNewFriend"><i class="fa fa-user fa-stack-1x fa-lg" aria-hidden="true"></i></span></a>
              <a href="/notification" id="navBarNotification"><span class="fa-stack fa-1x has-badge" id="spanNewNotifications"><i class="fa fa-bell fa-stack-1x fa-lg" aria-hidden="true"></i></span></a>
              <a href="/message" id="navBarMessages"><span class="fa-stack fa-1x has-badge" id="spanNewMessages"><i class="fa fa-commenting fa-stack-1x fa-lg" aria-hidden="true"></i></span></a>
            </div>
          </div>
          <a href="/profile/user/<?php echo "$logged_user->id_user" ?>">
            <div id="avatar"><div id="name-nav">{{$logged_user -> name . " " . $logged_user -> surname}}</div><img src="{{$logged_user ->pic_path}}" alt="Avatar"></div>
          </a>
        </header>
          @yield('content')
        <!--prova nuovi messaggi-->

    </body>
</html>
<script>

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  //pannello messaggi
  $(document).ready(function(){
    $.ajax({
      dataType: 'json',
      type: 'POST',
      url: '/getcountNewMessage',
      data: { id_user: '{{$logged_user->id_user}}' }
    }).done(function (data) {
      if(data.newMessages > 0){
        var html = '&nbsp;&nbsp;<span class="badge badge-danger" style="font-size:10px;">' + data.newMessages + '</span>';
        $('#btnMessage').append(html);
        var htmlNavBar = '<span class="fa-stack fa-1x has-badge" id="spanNewMessages" data-count="' + data.newMessages + '"><i class="fa fa-commenting fa-stack-1x fa-lg" aria-hidden="true"></i></span>';
        $('#navBarMessages').html(htmlNavBar);
      }else{
        var htmlNavBar = '<i class="fa fa-commenting fa-lg" aria-hidden="true"></i>';
        $('#navBarMessages').html(htmlNavBar);
      }
    });
  });

  //pannello notifiche
  $(document).ready(function(){
    $.ajax({
       url : '/getnotifications',
       method : "POST",
       dataType : "json",
       data: { id_user: '{{ $logged_user->id_user}}' }
    }).done(function (data) {
      if(data.newNotifications > 0){
        var htmlNavBar = '<span class="fa-stack fa-1x has-badge" id="spanNewNotifications" data-count="' + data.newNotifications + '"><i class="fa fa-bell fa-stack-1x fa-lg" aria-hidden="true"></i></span>';
        $('#navBarNotification').html(htmlNavBar);
      }else{
        var htmlNavBar = '<i class="fa fa-bell fa-lg" aria-hidden="true"></i>';
        $('#navBarNotification').html(htmlNavBar);
      }
    });
  });


  //pannello richieste amicizia
  $(document).ready(function(){
    $.ajax({
       url : '/getcountNewRequest',
       method : "POST",
       dataType : "json",
       data: { id_user: '{{ $logged_user->id_user}}' }
    }).done(function (data) {
      if(data.newRequest > 0){
        var htmlNavBar = '<span class="fa-stack fa-1x has-badge" id="spanNewFriend" data-count="' + data.newRequest + '"><i class="fa fa-user fa-stack-1x fa-lg" aria-hidden="true"></i></span>';
        $('#navBarFriend').html(htmlNavBar);
      }else{
        var htmlNavBar = '<i class="fa fa-user fa-lg" aria-hidden="true"></i>';
        $('#navBarFriend').html(htmlNavBar);
      }
    });
  });
</script>
