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
    <link href='https://fonts.googleapis.com/css?family=Roboto Slab' rel='stylesheet'></style>
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'></style>
    <link href="assets/css/home.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/1e803d693b.js"></script>
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

          <div id="notifiche">
            <i class="fa fa-user fa-lg" aria-hidden="true"></i>
            <i class="fa fa-bell fa-lg" aria-hidden="true"></i>
            <i class="fa fa-commenting fa-lg" aria-hidden="true"></i>
          </div>
        </div>

        <div id="avatar"><div id="name-nav">Igor</div><img src="assets/img/igor_avatar.png" alt="Avatar"></div>

      </header>


      <nav class="main-nav">
        <div class="side-sec">
          <img id="main_avatar" src="assets/img/igor_avatar.png" alt="Avatar">
          <span id="side-name">Igor Igor</span>
          <hr>
          <ul class="nav-links">
              <li><button class="btn btn-round color-1 material-design" data-color="#ffffff"><span class="fa fa-home" aria-hidden="true"></span> Timeline</button></li>
              <li><button class="btn btn-border btn-round color-1 material-design" data-color="#426FC5"><span class="fa fa-commenting" aria-hidden="true"></span> Messaggi</button></li>
              <li><button class="btn btn-border btn-round color-1 material-design" data-color="#426FC5"><span class="fa fa-book" aria-hidden="true"></span> Pagine</button></li>
          </ul>
        </div>
      </nav>

      <article class="content">
          <h1>Main article area</h1>
          <p>In this layout, we display the areas in source order for any screen less that 500 pixels wide. We go to a two column layout, and then to a three column layout by redefining the grid, and the placement of items on the grid.</p>
      </article>
      <aside class="side">Sidebar</aside>
</div>
</body>
</html>