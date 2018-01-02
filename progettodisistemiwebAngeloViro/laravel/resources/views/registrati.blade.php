<!-- Registrati -->
<div class="w3-container1" id="contact" style="margin-top:75px">
  <h1 class="w3-xxxlarge w3-text-red"><b>Registrati</b></h1>
  <hr  class="w3-round">

  <br><br>
  Inserisci i tuoi dati e registrati.

  <br>
  <form>
    <fieldset  class="registrazione1">
    <p>
      <label for="nome">Nome</label>
      <input class="registrati" type="text" name="nome" id="nome">
      &nbsp;
      <label for="cognome">Cognome</label>
      <input class="registrati" type="text" name="cognome" id="cognome">
    </p>
       <label for="datepickerx">Data di nascita</label>
      <input class="registrati" type="text" name="datepickerx" id="datepickerx" class="text ui-widget-content ui-corner-all">
      &nbsp;
      <label for="citta">Citt&agrave;</label>
      <input class="registrati" type="text" name="citta" id="citta" class="text ui-widget-content ui-corner-all">
    </p>
    <p>
      <label for="e-mail">e-mail</label>
      <input class="registrati" type="text" name="e-mail" id="e-mail">
      &nbsp;
      <label for="password">Password</label>
      <input class="registrati" type="password" name="password" id="password">
    </p>
    </fieldset>
    <br>
    <input class="registrazione" type="button" value="Registrati" id="registrati" OnClick="registrazione()">
  </form>

</div>
<script>
$(document).ready( function() {

  $( "#datepickerx" ).datepicker({
    dateFormat: "yy-mm-dd"
  });

});
</script>
