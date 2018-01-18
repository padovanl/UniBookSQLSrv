<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
html {
  box-sizing: border-box;
}

*, *:before, *:after {
  box-sizing: inherit;
}

.column {
  float: left;
  width: 33.3%;
  margin-bottom: 16px;
  padding: 0 8px;
}

@media (max-width: 400px) {
  .column {
    width: 80%;
    display: block;
  }
}

.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
}

.row {
  height: 50%;
}

.container {
  padding: 0 16px;
}

.container::after, .row::after {
  content: "";
  clear: both;
  display: table;
}

.title {
  color: grey;
}

.button {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
}

.button:hover {
  background-color: #555;
}

</style>
</head>
<body>

<h2>Meet The Team!</h2>
<p>Gruppo 9</p>
<br>

<div class="row">
  <div class="column">
    <div class="card">
      <img src="/assets/team/Arturo_Pesaro.jpg" alt="Jane" style="width:100%">
      <div class="container">
        <h2>Arturo Pesaro</h2>
        <p class="title">DevS</p
        <p>Studente presso Università degli Studi di Ferrara</p>
        <p>arturo.pesaro@student.unife.it</p>
        <p><button class="button">Contatta</button></p>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="card">
      <img src="/assets/team/luca_padovan.jpg" alt="Mike" style="width:100%">
      <div class="container">
        <h2>Luca Padovan</h2>
        <p class="title">Dev</p>
        <p>Studente presso Università degli Studi di Ferrara</p>
        <p>luca.padovan@student.unife.it</p>a
        <p><button class="button">Contatta</button></p>
      </div>
    </div>
  </div>
  <div class="column">
    <div class="card">
      <img src="/assets/team/Daniele_Lovato.jpg" alt="John" style="width:100%">
      <div class="container">
        <h2>Daniele Lovato</h2>
        <p class="title">Dev</p>
        <p>Studente presso Università degli Studi di Ferrara</p>
        <p>daniele01.lovato@student.unife.it</p>
        <p><button class="button">Contatta</button></p>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="column">
    <div class="card">
      <img src="/assets/team/Andrei_Jizdan.jpg" alt="Jane" style="width:100%">
      <div class="container">
        <h2>Andrei Jizdan</h2>
        <p class="title">Dev</p>
        <p>Studente presso Università degli Studi di Ferrara</p>
        <p>andrei.jizdan@student.unife.it</p>
        <p><button class="button">Contatta</button></p>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="card">
      <img src="/assets/team/Anonymous.jpg" alt="Mike" style="width:100%">
      <div class="container">
        <h2>Angelo Viro</h2>
        <p class="title">Dev</p>
        <p>Studente presso Università degli Studi di Ferrara</p>
        <p>angelo.viro@student.unife.it</p>
        <p><button class="button">Contatta</button></p>
      </div>
    </div>
  </div>
</div>
</body>
</html>
