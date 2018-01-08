@extends('layouts.app')

@section('content')



<article>
 <div class="container-full">

      <div class="pre-scrollable" id="messaggi">
      @foreach($messages[0]->listMessage as $m)
        @if($m->sender == $logged_user->id_user)
          <div class="container darker">
            <img src="{{$messages[1]->picPathReceiver}}" alt="Avatar" class="right">
            <p>{{$m->content}}</p>
            <span class="time-left">11:01</span>
          </div>
        @else
          <div class="container">
            <img src="{{$messages[1]->picPath}}" alt="Avatar">
            <p>{{$m->content}}</p>
            <span class="time-right">11:01</span>
          </div>
        @endif
      @endforeach

      <div class="container darker">
        <form>
          <div class="form-group">
            <label for="messageUser" class="form-control-label">Nuovo messaggio:</label>
            <textarea class="form-control" id="messageUser" rows="4"></textarea>
            <button type="button" class="btn btn-primary" id="bthSendMessageUser" disabled="true">Invia messaggio</button>    
          </div>
        </form>
      </div>

          

    </div>
  </div>
</article>

<aside class="side">
   <div class="pre-scrollable">
      <div class="list-group" id="sidebar">
        @foreach($messages as $m)
        <a href="#" onclick="ChangeChat('{{$m->fromId}}')" class="list-group-item listMessagesLink" id="messages{{$m->fromId}}">
          <div class="row">
              <div class="col-md-2">
                  <img src="{{$m->picPath}}" alt="Avatar" width="50" height="50">
              </div>
              <div class="col-md-10">
                  <p>{{$m->from}}</p>
                  <p>{{$m->listMessage[0]->content}}</p>
              </div>
          </div>
        </a>
        @endforeach
      </div> 
    </div>
</aside>



    
    <style>
      img {
        border-radius: 50%;
      }
      .pre-scrollable {
          max-height: 800px;
          overflow-y: scroll;
          overflow-x: hidden; 
      }
    </style>
    <style>
     /* Chat containers */
      .container {
          border: 2px solid #dedede;
          background-color: #77c0eb;
          border-radius: 5px;
          padding: 10px;
          margin: 10px 0;
          width: 100%;
      }

      /* Darker chat container */
      .darker {
          border-color: #ccc;
          background-color: rgb(233, 194, 139);
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

  <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
    <script src="../assets/js/admin/popper.min.js"></script>
  <script src="../assets/js/admin/bootstrap.min.js"></script>

<script>

  $("#sidebar a:first-child").addClass("active");


  function ChangeChat(from){
    $.ajax({
      dataType: 'json',
      type: 'POST',
      url: '/message/changeChat',
      data: { from: from }
    }).done(function (data) {
      //console.log(data);
      $('.listMessagesLink').removeClass('active');
      $('#messages' + from).addClass('active');
      manageChatBox(data, from);
    });
  }

  function manageChatBox(data, from){
    var message = '';
    $.each(data, function (key, value) {
      if(value.tipo == 1){
        message += '   <div class="container darker">';
        message += '      <img src="' + value.picPath + '" alt="Avatar" class="right">';
        message += '      <p>'+ value.content + '</p>';
        message += '      <span class="time-left">' + value.time + '</span>';
        message += '   </div>';
      }else{
        message += '   <div class="container">';
        message += '      <img src="' + value.picPathReceiver + '" alt="Avatar">';
        message += '      <p>'+ value.content + '</p>';
        message += '      <span class="time-right">' + value.time + '</span>';
        message += '   </div>';       
      }
    });

    message += '      <div class="container darker">';
    message += '    <form>';
    message += '      <div class="form-group">';
    message += '        <label for="messageUser" class="form-control-label">Nuovo messaggio:</label>';
    message += '        <textarea class="form-control" id="messageUser" rows="4"></textarea>';
    message += '        <button type="button" class="btn btn-primary" id="bthSendMessageUser" disabled="true" onclick="addMessage(\'' + from + '\')">Invia messaggio</button> ';   
    message += '      </div>';
    message += '    </form>';
    message += '  </div>';

    $("#messaggi").html(message);


    $('#messageUser').keyup(function(event){
      var text = $('#messageUser').val();
      if(text == ''){
        $('#bthSendMessageUser').attr('disabled', true);
      }else{
        $('#bthSendMessageUser').attr('disabled', false);
      }
    });

  }


  function insertNewMessage(data, from, message){
    var message = '';
    $.each(data, function (key, value) {
      if(value.tipo == 1){
        message += '   <div class="container darker">';
        message += '      <img src="' + value.picPath + '" alt="Avatar" class="right">';
        message += '      <p>'+ value.content + '</p>';
        message += '      <span class="time-left">' + value.time + '</span>';
        message += '   </div>';
      }else{
        message += '   <div class="container">';
        message += '      <img src="' + value.picPathReceiver + '" alt="Avatar">';
        message += '      <p>'+ value.content + '</p>';
        message += '      <span class="time-right">' + value.time + '</span>';
        message += '   </div>';       
      }
    });

    var date = new Date();
    var message = '';
    message += '   <div class="container darker">';
    message += '      <img src="' +  + '" alt="Avatar" class="right">';
    message += '      <p>'+ message + '</p>';
    message += '      <span class="time-left">' + date.getHours() + ':' + date.getMinutes() + '</span>';
    message += '   </div>';

    message += '      <div class="container darker">';
    message += '    <form>';
    message += '      <div class="form-group">';
    message += '        <label for="messageUser" class="form-control-label">Nuovo messaggio:</label>';
    message += '        <textarea class="form-control" id="messageUser" rows="4"></textarea>';
    message += '        <button type="button" class="btn btn-primary" id="bthSendMessageUser" disabled="true" onclick="addMessage(\'' + from + '\')">Invia messaggio</button> ';   
    message += '      </div>';
    message += '    </form>';
    message += '  </div>';

    $("#messaggi").html(message);


    $('#messageUser').keyup(function(event){
      var text = $('#messageUser').val();
      if(text == ''){
        $('#bthSendMessageUser').attr('disabled', true);
      }else{
        $('#bthSendMessageUser').attr('disabled', false);
      }
    });

  }

  function addMessage(to){
    var newMessage = $('#messageUser').val();
    $.ajax({
      dataType: 'json',
      type: 'POST',
      url: '/message/newMessage',
      data: { to: to, message: newMessage }
    }).done(function (data) {
      insertNewMessage(data, to, newMessage);
    });
  }


  $('#messageUser').keyup(function(event){
    var text = $('#messageUser').val();
    if(text == ''){
      $('#bthSendMessageUser').attr('disabled', true);
    }else{
      $('#bthSendMessageUser').attr('disabled', false);
    }
  });


  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
</script>

@endsection