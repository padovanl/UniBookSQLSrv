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
    <link href="assets/css/login.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Roboto Slab' rel='stylesheet'>
    <script src="https://use.fontawesome.com/1e803d693b.js"></script>
</head>
<body>


<div class="wrapper">
    <div class="login">
        <div class="name">
            <p>
                <span class="marcato">UNI</span>
                <span class="fino">BOOK</span>
            </p>
            </svg>
        </div>


        <form method="POST" action="/login/submit">
            {{csrf_field()}}

            <div class="group">
                <input type="email" name="email" id="email" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Email</label>
            </div>
            @if ($error = $errors->first('email'))
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
            @endif
            <div class="group">
                <input type="password" name="password" id="password" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Password</label>
            </div>
            @if ($error = $errors->first('password'))
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
            @endif
            <div id="rem-pwd">
                <div class="md-checkbox">
                    <input id="rem" type="checkbox" name="rem" checked>
                    <label for="rem">Ricordami</label>
                </div>
                <div class="pwd_dimenticata">
          <span>
            <a href="{{ route('forgotPassword') }}">Password dimeticata?</a>
          </span>
                </div>
            </div>

            <div class="lg-btn">
                <button type="submit" class="button">LOG IN</button>
            </div>

        </form>


        <div class="new_user">
            <p>Nuovo utente? <a href="{{ url('register') }}">Registrati!</a></p>
        </div>

    </div>
    <div class="side" style="background-image:url(assets/img/uni3.png)">
        <!--<img src="assets/img/uni3.png">-->
    </div>

</div>

</body>
</html>
