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
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'></style>
    <link href='https://fonts.googleapis.com/css?family=Roboto Slab' rel='stylesheet'></style>
    <script src="https://use.fontawesome.com/1e803d693b.js"></script>

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
        <p style="text-align:center"> <strong>Recupero password</strong></p>
      </div>
    </div>
    <br />
    <div id="container">
    <div class="row">
      <div class="col-md-12">
         <div class="group">
        <input type="text" name="email" id="email">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Inserisci email</label>
      </div>

        <!--<div class="alert alert-danger">

        </div>-->

      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="lg-btn">
          <a class="btn button" role="button" id="btnSendEmail" onclick="SendEmail()" disabled="true">Invia Email</a>
        </div>
      </div>
    </div>
  </div>

  </div>
  
  <div class="side"  style="background-image:url(../assets/img/uni3.png)">
    <!--<img src="assets/img/uni3.png">-->
  </div>

</div>

<style>
  img.displayed {
    display: block;
    margin-left: auto;
    margin-right: auto }
</style>

<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>

<script>

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });


  function SendEmail(){
    var email = $('#email').val();
    $.ajax({
      dataType: 'json',
      type: 'POST',
      url: '/register/sendEmailForgotPassword',
      data: { email: email }
    }).done( function(data){
      //alert(data.message);
      var html = '';
      html += '<div class="alert alert-danger">';
      html += '<p>Abbiamo inviato una password temporanea a questo indirizzo email. Una volta effettuato l\'accesso, verrai reindirizzato ad una pagina che ti consentirà di impostare una nuova password. La password che ti abbiamo mandato ha una validità di <strong>un giorno</strong>, dopodichè dovrai ripetere questa procedura.</p>';
      html += '</div>';
      $('#container').html(html);
    });
  }
   //$.ajax({
     // dataType: 'json',
      //type: 'POST',
      //url: '/admin/dashboard/ignoreReportComment',
      //data: { id_report: recipient }
    //}).done(function (data) {
      //console.log(data);
      //$('#labelStatus' + recipient + 'Comment').text('Esaminata').removeClass('badge-success').addClass('badge-secondary');
      //getPageComment(currentPageComment);
      //toastr.success('La segnalazione è stata esaminata con successo.', 'Operazione completata!', { timeOut: 5000 });
    //});

    $('#email').keyup(function(){
      var email = $('#email').val();
      if(email != '' && validateEmail(email))
        $('#btnSendEmail').removeAttr('disabled');
      else
        $('#btnSendEmail').attr('disabled', 'true');
    });
    function validateEmail(email) {
      return true;
    }

</script>

</body>
</html>

