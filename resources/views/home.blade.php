@extends('layouts.app')

@section('content')


<script>
  $(document).ready(function() {
      $('#submit').on('submit', function (e) {
          e.preventDefault();

          $.ajax({
              type: "GET",
              url: '/home/loadmore',
              datatype: 'json',
              data: {title: title, body: body, published_at: published_at},
              success: function( msg ) {
                  alert('ok');
              }
          });
      });
  });
</script>

  <div class="padding">
      <div class="full col-sm-12">
          <!-- content -->
          <div class="row">
              <!-- main col right -->
              <div class="col-sm-7">

                  <div class="well">
                      <form class="form" method="POST" action="/post">
                          <h4>New Post</h4>
                          <div class="input-group text-center">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                              <input class="form-control input-lg" name="content" placeholder="Hey, What's Up?" type="text">
                              <span class="input-group-btn"><button type="submit" class="btn btn-lg btn-primary">Post</button></span>
                          </div>
                      </form>
                  </div>
                  <!--Caricamento dei post-->
                  @foreach ($posts as $post)
                  <?php $author = $controller->ShowUser($post['id_author']); ?>
                  <!--Nuovo pannello commenti-->
                  <div class="panel panel-default">
                    <div class="panel-heading"><ul class="nav navbar-nav navbar-right">
                          <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                              </a>
                              <ul class="dropdown-menu">
                                  <li><a href="">Dettagli Post</a></li>
                                  <li><a href="">Visualizza Profilo</a></li>
                                  <li><a href="">Rimuovi dagli amici</a></li>
                                  <li><a href="">Segnala Post</a></li>
                              </ul>
                          </li>
                      </ul>
                      <div>
                          <h4>{{$controller->PrintName($post['id_author'])}}</h4>
                          <img src="{{$author['pic_path']}}" class="img-circle pull-left">
                      </div>
                    </div>
                    <div class="panel-body">
                    <p>{{$post['content']}}</p>
                    <div class="clearfix"></div>
                    @foreach ($list_comments as $comment)
                        @if ($comment['id_post'] === $post -> id_post)
                        <!--linea-->
                        <hr>
                        <!--TODO: immagine-->
                        <p><a href="/profile/user/{{$comment['id_author']}}">{{$controller->PrintName($comment -> id_author)}}  </a>{{$comment -> content}}</p>
                      @endif
                  @endforeach
                        <hr>
                    <form>
                    <div class="input-group">
                      <div class="input-group-btn">
                      <button class="btn btn-default">+1</button><button class="btn btn-default"><i class="glyphicon glyphicon-share"></i></button>
                      </div>
                      <input class="form-control" placeholder="Add a comment.." type="text">
                    </div>
                    </form>

                    </div>
                 </div>
                @endforeach
                <button type="button"/>Load More..
              </div>
              <div class="col-sm-5">
                  <div class="container">
                      <div class="row">
                          <div class="panel panel-default user_panel">
                              <div class="panel-heading">
                                  <h3 class="panel-title">Suggested Friends</h3>
                              </div>
                              <div class="panel-body">
                                  <div class="table-container">
                                      @foreach ($suggested_friends as $suggested)
                                      <table class="table-users table" border="0">
                                          <tbody>
                                          <tr>
                                              <td  align="center">
                                                  <i class="fa fa-2x fa-user fw"></i>
                                              </td>
                                              {{$suggested -> name . ' ' . $suggested -> surname}}
                                              <td>
                                              </td>

                                          </tr>
                                          </tbody>
                                      </table>
                                    @endforeach

                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div><!--/row-->

          <div class="row">
              <div class="col-sm-6">
                  <a href="#">Twitter</a> <small class="text-muted">|</small> <a href="#">Facebook</a> <small class="text-muted">|</small> <a href="#">Google+</a>
              </div>
          </div>

          <div class="row" id="footer">
              <div class="col-sm-6"/>
          </div>
          <hr>
          <h4 class="text-center">
              <a href="/" target="ext">UniBook</a>
          </h4>
          <hr>
      </div><!-- /col-9 -->
  </div><!-- /padding -->
@endsection

@section('post')
<!--post modal-->
<div id="postModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">\D7</button>
                Update Status
            </div>
            <div class="modal-body">
                <form class="form center-block">
                    <div class="form-group">
                        <textarea class="form-control input-lg" autofocus="" placeholder="What do you want to share?"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div>
                    <button class="btn btn-primary btn-sm" data-dismiss="modal" aria-hidden="true">Post</button>
                    <ul class="pull-left list-inline"><li><a href=""><i class="glyphicon glyphicon-upload"></i></a></li><li><a href=""><i class="glyphicon glyphicon-camera"></i></a></li><li><a href=""><i class="glyphicon glyphicon-map-marker"></i></a></li></ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="../assets/js/jquery.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle=offcanvas]').click(function() {
            $(this).toggleClass('visible-xs text-center');
            $(this).find('i').toggleClass('glyphicon-chevron-right glyphicon-chevron-left');
            $('.row-offcanvas').toggleClass('active');
            $('#lg-menu').toggleClass('hidden-xs').toggleClass('visible-xs');
            $('#xs-menu').toggleClass('visible-xs').toggleClass('hidden-xs');
            $('#btnShow').toggle();
        });
    });
</script>

<script>
$(document).ready(function(){
   $(document).on('click','#btn-more',function(){
       var id = $(this).data('id');
       $("#btn-more").html("Loading....");
       $.ajax({
           url : 'home/loadmore',
           method : "POST",
           data : {id:id, _token:"{{csrf_token()}}"},
           dataType : "json",
           success : function (data)
           {
              if(data != '')
              {
                  $('#remove-row').remove();
                  $('#load-data').append(data);
              }
              else
              {
                  $('#btn-more').html("No Data");
              }
           }
       });
   });
});
</script>

@endsection



