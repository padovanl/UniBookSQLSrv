@extends('layouts.app')

@section('content')






 <div style="padding: 75px 30px" class="container-full ">
  <div class="row">
    <div class="col-md-4">
      <div class="list-group">
        <a href="#" class="list-group-item active">
          <div class="row">
              <div class="col-md-2">
                  <img src="../assets/images/facebook2.jpg" alt="Avatar" width="50" height="50">
              </div>
              <div class="col-md-10">
                  <p>Luca Padovan</p>
                  <p>Questo e' l'ultimo messaggio di Luca</p>
              </div>
          </div>
        </a>
        <a href="#" class="list-group-item">
            <div class="row">
              <div class="col-md-2">
                  <img src="../assets/images/facebook2.jpg" alt="Avatar" width="50" height="50">
              </div>
              <div class="col-md-10">
                  <p>Luca Padovan</p>
                  <p>Questo e' l'ultimo messaggio di Luca</p>
              </div>
          </div>
        </a>
        <a href="#" class="list-group-item">
          <div class="row">
              <div class="col-md-2">
                  <img src="../assets/images/facebook2.jpg" alt="Avatar" width="50" height="50">
              </div>
              <div class="col-md-10">
                  <p>Luca Padovan</p>
                  <p>Questo e' l'ultimo messaggio di Luca</p>
              </div>
          </div>
          </a>
      </div> 
      
    </div>
    <div class="col-md-8">
        <div class="pre-scrollable">
          <div class="container">
            <img src="/w3images/bandmember.jpg" alt="Avatar">
            <p>Hello. How are you today?</p>
            <span class="time-right">11:00</span>
          </div>

          <div class="container darker">
            <img src="/w3images/avatar_g2.jpg" alt="Avatar" class="right">
            <p>Hey! I'm fine. Thanks for asking!</p>
            <span class="time-left">11:01</span>
          </div>

          <div class="container">
            <img src="/w3images/bandmember.jpg" alt="Avatar">
            <p>Sweet! So, what do you wanna do today?</p>
            <span class="time-right">11:02</span>
          </div>

          <div class="container darker">
            <img src="/w3images/avatar_g2.jpg" alt="Avatar" class="right">
            <p>Nah, I dunno. Play soccer.. or learn more coding perhaps?</p>
            <span class="time-left">11:05</span>
          </div> 
          <div class="container darker">
            <form>
              <div class="form-group">
                <label for="messageUser" class="form-control-label">Nuovo messaggio:</label>
                <textarea class="form-control" id="messageUser" rows="7"></textarea>
                <h5 id="errorMessage"></h5>
              </div>
            </form>
          </div> 
        </div>
          
      </div>
    </div>
  </div>

    
    <style>
      img {
        border-radius: 50%;
      }
      .pre-scrollable {
          max-height: 400px;
          overflow-y: scroll;
          overflow-x: hidden; 
      }
    </style>
    <style>
     /* Chat containers */
      .container {
          border: 2px solid #dedede;
          background-color: #f1f1f1;
          border-radius: 5px;
          padding: 10px;
          margin: 10px 0;
          width: 100%;
      }

      /* Darker chat container */
      .darker {
          border-color: #ccc;
          background-color: #ddd;
      }

      /* Clear floats */
      .container::after {
          content: "";
          clear: both;
          display: table;
      }

      /* Style images */
      .container img {
          float: left;
          max-width: 60px;
          width: 100%;
          margin-right: 20px;
          border-radius: 50%;
      }

      /* Style the right image */
      .container img.right {
          float: right;
          margin-left: 20px;
          margin-right:0;
      }

      /* Style time text */
      .time-right {
          float: right;
          color: #aaa;
      }

      /* Style time text */
      .time-left {
          float: left;
          color: #999;
      } 
    </style>

<script type="text/javascript" src="../assets/js/jquery.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.js"></script>


@endsection