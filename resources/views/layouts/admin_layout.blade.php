<!doctype html>
<html lang="en">
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="stylesheet" href="../../assets/css/admin/grafici.css" />
  <link rel="stylesheet" href="../../assets/css/admin/morris.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
  <title>Unibook - Dashboard</title>

  <!-- Bootstrap core CSS -->
  <link href="../../assets/css/admin/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../../assets/css/admin/dashboard.css" rel="stylesheet">

  <!--Token per ajax-->
  <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
  <header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <a class="navbar-brand" href="/admin">Unibook Dashboard</a>
      <li class="nav-item">
        <a class="nav-link nav-item" href="/">Ritorna alla home</a>
      </li>

      <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>


    </nav>
  </header>


  @yield('content')





</body>

</html>
