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
    <link href="assets/css/registrazione.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'></style>
    <link href='https://fonts.googleapis.com/css?family=Roboto Slab' rel='stylesheet'></style>
    <script src="https://use.fontawesome.com/1e803d693b.js"></script>
</head>
<body>

  <div class="wrapper">
    <div class="register">
      <h1>Registrazione</h1></br>


      <form action="/register" method="post" enctype="multipart/form-data">
        {{csrf_field()}}

        <div class="group">
          <input type="text" name="name" required>
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Nome</label>
        </div>
        <div class="group">
          <input type="text" name="surname" required>
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Cognome</label>
        </div>
        <div class="group">
          <input type="email" name="email" required>
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Email</label>
        </div>

        <div class="group">
          <input type="password" name="pwd_hash" required>
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Password</label>
        </div>

        <div class="group">
          <input type="text" name="citta" required>
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Città</label>
        </div>



        <p>Data di nascità</p>
        <div class="form-row">
            <input class="form-control" type="date" name="birth_date" required>
        </div></br>


        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="gender" id="gender" value="0" checked>
          <label class="form-check-label" for="gender">Donna</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="gender" id="gender" value="1">
          <label class="form-check-label" for="gender">Uomo</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="gender" id="gender" value="3">
          <label class="form-check-label" for="gender">Other</label>
        </div></br>

        <div class="group">
          <div class="row">
            <div class="col-md-2">
                <label>Foto profilo</label>
            </div>
            <div class="col-md-10">
              <input type="file" name="file" id="file" required>
              <span class="highlight"></span>
              <span class="bar"></span>
            </div>
          </div>
        </div>
        
        @if($error != '')
          {{$error}}
        @endif

        <div class="lg-btn">
          <button type="submit" class="button" value="Register">Registrati</button>
        </div>

      </form>

    </div>
  </div>

</body>
</html>
