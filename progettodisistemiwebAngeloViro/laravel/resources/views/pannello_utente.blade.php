<!-- User Panel -->
<div class="w3-container" id="contact" style="margin-top:75px">
  <h1 class="w3-xxxlarge w3-text-red"><b>Pannello Utente</b></h1>
  <hr style="width:50px; border: 5px solid red" class="w3-round">
</div>

  <fieldset class="pannello">
  <p>
    <label for="nome">Nome</label>
    <input class="w3-input1" type="text" name="nome" id="nome">
    &nbsp;
    <label for="cognome">Cognome</label>
    <input class="w3-input1" type="text" name="cognome" id="cognome">
  </p>
  <p>
        <label for="datepickerx">Data di nascita</label>
    <input class="w3-input1" type="text" name="datepickerx" id="datepickerx" class="text ui-widget-content ui-corner-all">
    &nbsp;
    <label for="citta">Citt&agrave;</label>
    <input class="w3-input1" type="text" name="citta" id="citta" class="text ui-widget-content ui-corner-all">
  </p>
  <p>
    <label for="e-mail">Username</label>
    <input class="w3-input1" type="text" name="e-mail" id="e-mail">
    &nbsp;
    <label for="password">Password</label>
    <input class="w3-input1" type="text" name="password" id="password">
  </p>
  </fieldset>
  <br>
  <input type="button" value="Modifica" id="modifica">
  <input type="button" value="Elimina account" id="elimina" OnClick="cancella_utente(utente.ID); logout()">
<script>
$(document).ready(function() {

  $("#nome").val(utente.Nome);
  $("#cognome").val(utente.Cognome);
  $("#citta").val(utente.Citta);
  $("#datepickerx").val(utente.Data_nascita);
  $("#e-mail").val(utente.email);

  $("#modifica").click(function() {

    var nome = $("#nome").val();
    var cognome = $("#cognome").val();
    var citta = $("#citta").val();
    var datepicker = $("#datepickerx").val();
    var email = $("#e-mail").val();
    var password = $("#password").val();

    var if_password = "";

    if (password != null && password != "")
      if_password = "&password="+MD5(password);

    $.ajax({
     type:"GET",
     url:"../laravel/public/index.php/modifica?idcitta="+citta+"&idusername="+email+"&idnome="+nome+"&idcognome="+cognome+"&iddatepicker="+datepicker+"&idutente="+utente.ID + if_password + "&token=" + token,
     dataType:"html",
     success: function() {

           utente.Nome = $("#nome").val();
           utente.Cognome = $("#cognome").val();
           utente.Citta = $("#citta").val();
           utente.Data_nascita = $("#datepickerx").val();
           utente.email = $("#e-mail").val();

           alert("Modifica effettuata!!!");
         },
         error: function(){
           alert("Chiamata fallita!!!");
         }
      });

  });

});
function cancella_utente(userId) {

  $.get( '../laravel/public/index.php/cancella_utente', {
      id: userId,
      token: token
  })
  .done(function(data) {
    load_user();
    alert("Utente cancellato!");
  });

}
</script>
