@extends('layouts.app')

@section('content')



<article>
 <div class="container-full">
  <br />
  <div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10" id="requestContainer">
      @if(count($requestList) > 0)
        @foreach($requestList as $r)
          <div id="{{$r->id_request}}" class="row" style="border-style: solid; border-width: 1px; border-color: #008CBA; border-radius: 25px; padding: 10px;">
            <div class="col-md-1">
              <img src="/{{$r->user->pic_path}}" height="55px" width="55px" style="border-radius: 50%;">
            </div>
            <div class="col-md-9" style="display: flex; align-items: center;">
              <p>{{$r->content}}</p>
            </div>
            <div class="col-md-2">
              <button class="buttonPersonal" onclick="accetta({{$r->id_request}}, '{{$r->id_request_user}}')"><i class="fa fa-check" aria-hidden="true"></i></button>
              <button class="buttonPersonalRed" onclick="rifiuta({{$r->id_request}}, '{{$r->id_request_user}}')"><i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
          </div>
          <br id='br{{$r->id_request}}'/>
        @endforeach
      @else
        <div class="alert alert-success" role="alert" style="text-align: center;">
          <strong>Al momento non hai nessuna richiesta di amicizia in sospeso</strong>
        </div>
      @endif
    </div>
    <div class="col-md-1"></div>
  </div>
  </div>
</article>

<aside class="side">
  
</aside>

<style>
  .buttonPersonal {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 10px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 50%;
  }
  .buttonPersonalRed {
    background-color: #f44336;
    border: none;
    color: white;
    padding: 10px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 50%;
  }
</style>
<script>
  function accetta(id_request, id_request_user){
    $.ajax({
      dataType: 'json',
      type: 'POST',
      url: '/friend/accept',
      data: { id_request: id_request, id_user: id_request_user }
    }).done(function (data) {
      $('#' + id_request).remove();
      $('#br' + id_request).remove();
      if($('#requestContainer').children.length = 0){
        var html = '';
        html += '<div class="alert alert-success" role="alert" style="text-align: center;">';
        html += ' <strong>Al momento non hai nessuna richiesta di amicizia in sospeso</strong>';
        html += '</div>';
        $('#requestContainer').html(html);
      }
      //console.log(data);
    });
  }


    function rifiuta(id_request, id_request_user){
    $.ajax({
      dataType: 'json',
      type: 'POST',
      url: '/friend/decline',
      data: { id_request: id_request, id_user: id_request_user }
    }).done(function (data) {
      $('#' + id_request).remove();
      $('#br' + id_request).remove();
      if($('#requestContainer').children.length = 0){
        var html = '';
        html += '<div class="alert alert-success" role="alert" style="text-align: center;">';
        html += ' <strong>Al momento non hai nessuna richiesta di amicizia in sospeso</strong>';
        html += '</div>';
        $('#requestContainer').html(html);
      }
      //console.log(data);
    });

  }
</script>
  <!--<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
  <script src="../assets/js/admin/popper.min.js"></script>
  <script src="../assets/js/admin/bootstrap.min.js"></script>-->

@endsection