<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Unibook</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="../assets/css/login.css" rel="stylesheet">
    <link href="../assets/css/confirm.css" rel="stylesheet">
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

        </div>

        <div class="row">
            <div class="col-md-12">
                <p style="text-align:justify"><strong>Ben fatto!</strong> La tua iscrizione a UniBook è quasi completa.
                    Per mantenere <strong>UniBook</strong> un luogo piacevole abbiamo bisogno di verificare la tua
                    email. Abbiamo inviato un messaggio alla tua casella di posta elettronica: per postare e commentare
                    sul nostro portale attiva il tuo account cliccando sul link presente nell'email.</p>
            </div>
        </div>
        <div class="letter">
            <a target="_blank" href="{{ session('email_domain') }}">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                     y="0px" width="200px"
                     height="200px" viewBox="0 0 250 250" enable-background="new 0 0 250 250" xml:space="preserve">
        <g id="Layer_1">
            <circle cx="124.667" cy="125" r="111.333"/>
        </g>
                    <g id="Layer_2">
                        <g>
                            <path fill="#FFFFFF" d="M172.053,157.967c0,4.621-3.781,8.401-8.401,8.401H86.363c-4.621,0-8.401-3.78-8.401-8.401v-57.125
        			c0-4.621,3.78-8.401,8.401-8.401h77.288c4.62,0,8.401,3.78,8.401,8.401V157.967z M163.651,99.161H86.363
        			c-0.893,0-1.68,0.788-1.68,1.68c0,5.986,2.993,11.184,7.718,14.912c7.036,5.513,14.071,11.079,21.055,16.645
        			c2.783,2.258,7.823,7.088,11.499,7.088h0.053h0.052c3.676,0,8.716-4.83,11.499-7.088c6.983-5.565,14.019-11.131,21.055-16.645
        			c3.413-2.678,7.719-8.506,7.719-12.969C165.332,101.471,165.646,99.161,163.651,99.161z M165.332,117.643
        			c-1.104,1.26-2.311,2.415-3.623,3.465c-7.509,5.775-15.069,11.656-22.367,17.747c-3.938,3.308-8.821,7.351-14.282,7.351h-0.052
        			h-0.053c-5.461,0-10.344-4.043-14.282-7.351c-7.298-6.091-14.859-11.972-22.367-17.747c-1.313-1.05-2.521-2.205-3.623-3.465
        			v40.324c0,0.894,0.788,1.681,1.68,1.681h77.288c0.893,0,1.681-0.787,1.681-1.681V117.643z"/>
                        </g>
                    </g>
        </svg>
            </a>
        </div>
        <!--<div class="row justify-content-center">
         <div class="col-md-12">
           <img class="displayed" src="../assets/img/sendEmail.png" >
         </div>
       </div>-->

    </div>
    <div class="side" style="background-image:url(../assets/img/uni3.png)">
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

</body>
</html>
