  <!-- Accedi -->
  <!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">

  <title></title>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS -->
  <link rel="stylesheet" href="css/w3.css">
  <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/style.css">

  <!-- Javascript Libraries -->
  <script src="js/jquery-1.12.4.js"></script>
  <script src="js/jquery.dataTables.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  
  <script src="js/md5.js"></script>
  </head>
<body contenteditable="false">
  <div class="w3-container1" id="contact" style="margin-top:75px">
    <h1 class="w3-xxxlarge w3-text-red"><b>Accedi</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
    
      <div class="w3-section">
      <label> E-mail </label>
      <input class="w3-input" style="width:100%;"  type='text' id="e-mail" name='e-mail'><br>
      </div>
      <div class="w3-section">
      <label> Password </label>
      <input class="w3-input" style="width:100%;"  type='password' id="password" name='password'><br>
      
      </div>
      <button type="submit" class="w3-button w3-teal w3-right" Onclick="checkForm()">Vai</button>
  </div>
  <script>
  function login() {
    $.post("../laravel/public/index.php/login", { email: $("#e-mail").val(), password: $("#password").val()}, function(result) {

      localStorage.setItem("token", result.result);
      token = result.result;

      $.post("../laravel/public/index.php/get_user_details", { token: token}, function(result) {
        localStorage.setItem("utente", JSON.stringify(result.result));
        utente = result.result;

        if (token == null || token == "" || utente == null) {
          alert("Dati errati");
          return;
        }

    /*    $("#accedi").hide();
        $("#registrati").hide();
        $("#user-panel").show();
        $("#logout").show();
        go_to('page/home');
        handle_menu(utente);*/
      });

    });
  }
   function checkForm()
  {
    // Controlla che username e password non siano vuoti
    if($("#e-mail").val() == '' && $("#password").val() == '')
    {
      alert('Inserire e-mail e password');
      return false;
    }
    if($("#e-mail").val() == '')
    {
      alert('Inserire e-mail');
      return false;
    }

      if( $("#password").val() == '')
        {
      alert('Inserire password');
      return false;
    }

    // Se arriviamo qui, tutto ok
    login();
  }

  // Script to open and close sidebar
  </script>
  </body>
</html>
