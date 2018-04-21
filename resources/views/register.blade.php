<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>UniBook</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="assets/css/registrazione.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Roboto Slab' rel='stylesheet'>
    <script src="https://use.fontawesome.com/1e803d693b.js"></script>
    <link rel="icon" href="/assets/img/icon2.png">
</head>
<body>

<div class="wrapper">
    <div class="register">
        <h1>Registrazione</h1></br>


        <form action="/register" method="post" id="registerForm" enctype="multipart/form-data">
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
                <input type="password" name="pwd_hash" id="password" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Password</label>
            </div>
            <div class="group">
                <input type="password" name="re_pwd_hash" id="re_password" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Conferma password</label>
            </div>
            <div class="group">
                <input type="text" name="citta" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Città</label>
            </div>
            <p>Data di nascita</p>
            <div class="form-row">
                <input class="form-control" type="date" name="birth_date" required>
            </div>
            </br>


            <div class="form-check form-check-inline" id="genderDiv">
                Sesso:&nbsp;
                <input class="form-check-input" type="radio" name="gender" class="gender" value="0" checked>
                <label class="form-check-label" for="gender">Donna</label>
                <input class="form-check-input" type="radio" name="gender" class="gender" value="1">
                <label class="form-check-label" for="gender">Uomo</label>
                <input class="form-check-input" type="radio" name="gender" class="gender" value="3">
                <label class="form-check-label" for="gender">Altro</label>
            </div>

            </br>

            <div class="group">
                <p>Foto profilo</p>
                <div>
                    <input type="file" name="file" id="file" onchange="showFileSize();">
                    <span class="highlight"></span>
                    <span class="bar"></span>
                </div>
            </div>

            <div class="lg-btn">
                <button type="submit" class="button" id="btnSubmit" value="Register">Regstrati</button>
            </div>
        </form>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        var err = '{{$error}}'
        if (err !== '')
            alert("{{$error}}");
    });


    function showFileSize() {
        var input, file;
        input = document.getElementById('file');
            file = input.files[0]; console.log(file);
            var filesizeMb = file.size/1024/1024;
            if(filesizeMb >= 2.0){
                alert('La dimensione dell\'immagine del profilo non deve superare i 2MB');
                $('#btnSubmit').prop('disabled', true);
            }
            else{
                $('#btnSubmit').prop('disabled', false);
            }
    }

</script>

</body>
</html>
