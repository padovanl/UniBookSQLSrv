<!DOCTYPE html>
<html lang="en">
<head>

    @include('includes.head')


    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="../../assets/js/jquery.powertip.js"></script>
    <link href="/assets/css/jquery.powertip.css" rel="stylesheet">

    <script src="/assets/js/common.js"></script>

    <script src="/assets/js/admin/popper.min.js"></script>

    <script src="/assets/js/admin/bootstrap.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <script src="/assets/js/page.js"></script>

    <link href="/assets/css/home.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/1e803d693b.js"></script>

    <link href="/assets/css/profile_badge.css" rel="stylesheet">


</head>
<body>
<div class="wrapper">
    <header class="main-head">
        @include('includes.header')
    </header>

    <nav class="main-nav">
        <div class="side-sec">
            <img id="main_avatar" src="{{$logged_user -> pic_path}}" alt="Avatar">
            <span id="side-name">{{$logged_user -> name . " " . $logged_user -> surname}}</span>
            <hr>
            <ul class="nav-links">
                <li>
                    <button class="btn btn-round color-1 material-design" data-color="#ffffff" id="btnTimeline"
                            onclick="window.location='/'"><span class="fa fa-home" aria-hidden="true"></span> Timeline
                    </button>
                </li>
                <li>
                    <button class="btn btn-border btn-round color-1 material-design" data-color="#426FC5"
                            id="btnMessage" onclick="window.location='/message'"><span class="fa fa-commenting"
                                                                                       aria-hidden="true"></span>
                        Messaggi
                    </button>
                </li>
                <li>
                    <button class="btn btn-border btn-round color-1 material-design" data-color="#426FC5" id="btnPage"
                            onclick="window.location='/page/mypage'"><span class="fa fa-book" aria-hidden="true"></span>
                        Pagine
                    </button>
                </li>
                @if($logged_user->admin)
                    <li>
                        <button class="btn btn-border btn-round color-1 material-design" data-color="#426FC5"
                                id="btnAdmin" onclick="window.location='/admin'"><i class="fa fa-desktop"
                                                                                    aria-hidden="true"></i>&nbsp;Dashboard
                        </button>
                    </li>
                @endif
                <li>
                    <button class="btn btn-border btn-round color-1 material-design" data-color="#426FC5" id="btnLogout"
                            onclick="window.location='/logout'"><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;Logout
                    </button>
                </li>
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
        //pannello messaggi
        $(document).ready(function () {
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: '/getcountNewMessage',
                data: {id_user: '{{$logged_user->id_user}}'}
            }).done(function (data) {
                if (data.newMessages > 0) {
                    var html = '&nbsp;&nbsp;<span class="badge badge-danger" style="font-size:10px;">' + data.newMessages + '</span>';
                    $('#btnMessage').append(html);
                    var htmlNavBar = '<span class="fa-stack fa-1x has-badge" id="spanNewMessages" data-count="' + data.newMessages + '"><i class="fa fa-commenting fa-stack-1x fa-lg" aria-hidden="true"></i></span>';
                    $('#navBarMessages').html(htmlNavBar);
                } else {
                    var htmlNavBar = '<i class="fa fa-commenting fa-lg" aria-hidden="true"></i>';
                    $('#navBarMessages').html(htmlNavBar);
                }
            });
        });

        //pannello notifiche
        $(document).ready(function () {
            $.ajax({
                url: '/getnotifications',
                method: "POST",
                dataType: "json",
                data: {id_user: '{{ $logged_user->id_user}}'}
            }).done(function (data) {
                if (data.newNotifications > 0) {
                    var htmlNavBar = '<span class="fa-stack fa-1x has-badge" id="spanNewNotifications" data-count="' + data.newNotifications + '"><i class="fa fa-bell fa-stack-1x fa-lg" aria-hidden="true"></i></span>';
                    $('#navBarNotification').html(htmlNavBar);
                } else {
                    var htmlNavBar = '<i class="fa fa-bell fa-lg" aria-hidden="true"></i>';
                    $('#navBarNotification').html(htmlNavBar);
                }
            });
        });


        //pannello richieste amicizia
        $(document).ready(function () {
            $.ajax({
                url: '/getcountNewRequest',
                method: "POST",
                dataType: "json",
                data: {id_user: '{{ $logged_user->id_user}}'}
            }).done(function (data) {
                if (data.newRequest > 0) {
                    var htmlNavBar = '<span class="fa-stack fa-1x has-badge" id="spanNewFriend" data-count="' + data.newRequest + '"><i class="fa fa-user fa-stack-1x fa-lg" aria-hidden="true"></i></span>';
                    $('#navBarFriend').html(htmlNavBar);
                } else {
                    var htmlNavBar = '<i class="fa fa-user fa-lg" aria-hidden="true"></i>';
                    $('#navBarFriend').html(htmlNavBar);
                }
            });
        });
    </script>


</body>
</html>
