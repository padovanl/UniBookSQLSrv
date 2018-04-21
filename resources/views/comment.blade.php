
<!--
Vanno sostituiti i valori di id_user e
id_post con quelli dell'utente
loggato(quindi attraverso il cookie)
e del post che si sta commentando.
Io ora gli ho messi prendendo l'id
dell'utente che avevo già creato nel DB
e quello del post a random.
-->


<form action="/comment" method="post">
  {{csrf_field()}}
  Comment: <input type="text" name="content" required><br>
  <input name="id_user" type="hidden" value=<?php echo "5a41211d03ca6"?>>
  <input name="id_post" type="hidden" value=<?php echo "5"?>>
  <input type="submit" value="COMMENTA">
</form>
