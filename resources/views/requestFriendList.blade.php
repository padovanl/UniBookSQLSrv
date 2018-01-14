@extends('layouts.app')

@section('content')



<article>
 <div class="container-full">
  <div class="row">
    <div class="col-md-12">
      @foreach($requestList as $r)
        <a href="#" id="request{{$r->id_request}}" onclick="accetta({{$r->id_request}}, '{{$r->id_request_user}}')">Accetta {{$r->id_request}}</a>
      @endforeach
    </div>
  </div>
  </div>
</article>

<aside class="side">
  
</aside>

<script>
  function accetta(id_request, id_request_user){
    $.ajax({
      dataType: 'json',
      type: 'POST',
      url: '/friend/accept',
      data: { id_request: id_request, id_user: id_request_user }
    }).done(function (data) {
      console.log(data);
    });
  }
</script>
  <!--<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
  <script src="../assets/js/admin/popper.min.js"></script>
  <script src="../assets/js/admin/bootstrap.min.js"></script>-->

@endsection