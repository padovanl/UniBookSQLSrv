<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>UniBook</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="../../assets/css/bootstrap.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="../../assets/css/login.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Roboto Slab' rel='stylesheet'>
    <script src="https://use.fontawesome.com/1e803d693b.js"></script>
    <link rel="icon" href="/assets/img/icon2.png">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>


<div class="wrapper">
    <div class="login">
        <div class="name">
            <p>
                <span class="marcato">UNI</span>
                <span class="fino">BOOK</span>
            </p>

        </div>


        <div class="row">
            <div class="col-md-12">
                <p style="text-align:center">
                    <strong>Reset password</strong>
                </p>
            </div>
        </div>
        <div id="container">
            <div class="row">
                <div class="col-md-12">
                    <p style="text-align:justify">Sei stato reindirizzato a questa pagina perchè hai richiesto il reset
                        della password. Prima di continuare a navigare su UniBook devi impostarne una nuova.</p>
                </div>
            </div>
            <br/>
            <br/>
            <form method="POST" action="/register/resetPassword/{{$id_user}}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-12">
                        <div class="group">
                            <input type="password" name="newPwd" id="newPwd" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Inserisci la nuova password</label>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="group">
                            <input type="password" name="reNewPwd" id="reNewPwd" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Ripeti password</label>
                        </div>
                        @if ($error = $errors->first('reNewPwd'))
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="lg-btn">
                            <button type="submit" class="button">Cambia password</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="idUser" value="{{$id_user}}">
            </form>
        </div>

    </div>

    <div class="side" style="background-image:url(../../assets/img/uni3.png)">
        <!--<img src="assets/img/uni3.png">-->
    </div>

</div>

<style>
    img.displayed {
        display: block;
        margin-left: auto;
        margin-right: auto
    }
</style>

<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
        crossorigin="anonymous"></script>


</body>

</html>