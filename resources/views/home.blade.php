@extends('layouts.app')

@section('content')
  <div class="padding">
          <!-- content -->
          <div class="row">
              <!-- main col right -->
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
                  <!--Nuovo pannello commenti-->
                  <div class="panel panel-default" id="post">
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
                          <h4 id="post_u_name">User Name</h4>
                          <img id="post_pic_path" src="" class="img-circle pull-left">
                      </div>
                    </div>
                    <div class="panel-body">
                    <p id="post_content">Content</p>
                    <div class="clearfix"></div>
                          <div id="commpanel">
                            <hr>
                            <!--TODO: immagine-->
                            <a id="author" href="Link_To_User">Comment User Name  </a>
                            <p id="comm_details">
                              Comment Body
                            </p>
                          </div>
                          <hr>
                    <form>
                    <div class="input-group">
                      <div class="input-group-btn">
                      <button id="like_butt" class="btn btn-default">+1</button><button class="btn btn-default"><i class="glyphicon glyphicon-share"></i></button>
                      </div>
                      <input class="form-control" placeholder="Add a comment.." type="text">
                    </div>
                    </form>

                    </div>
                 </div>
                <button type="button"/>Load More..
          </div><!--/row-->
          <hr>
  </div><!-- /padding -->

  <script>

  //Caricamento dei post
  $(document).ready(function(){
         //var id = $(this).data('id');
         //$("#btn-more").html("Loading....");
         $.ajax({
             url : '/home/loadmore',
             method : "GET",
             dataType : "json",
             success : function (data)
             {
               //ciclo su tutti i post:
               for(i = 0; i < data.length; i++)
               {
                 $("#post").hide();
                 $post_clone = $("#post").clone();
                 $post_clone.attr("id", "post_" + i);
                 $post_clone.find("#post_u_name").text(data[i].auth_name + " " + data[i].auth_surname);
                 $post_clone.find("#post_pic_path").attr('src', data[i].pic_path);
                 $post_clone.find("#post_content").text(data[i].content);
                 $post_clone.find("#like_butt").text(data[i].likes);
                 for(j = 0; j < data[i].comments.length; j++){
                   $panel = $("#commpanel").clone();
                   $panel.attr("id", "comm_panel_" + j);

<<<<<<< HEAD
                   //controllare che sia pagina
                   if(isNaN(data[i].comments[j].id_user)){
                     $panel.find("#author").attr("href", "/profile/user/" + data[i].comments[j].id_author);
                     $panel.find("#author").text(data[i].comments[j].auth_name + " " + data[i].comments[j].auth_surname);
                  }
                   else{
                     $panel.find("#author").attr("href", "/profile/page/" + data[i].comments[j].id_author);
                     $panel.find("#author").text(data[i].comments[j].auth_name);
                   }
                  $panel.find("#comm_details").text(data[i].comments[j].content);
                  $panel.insertAfter(".clearfix")
                 }
                 $post_clone.insertAfter(".form");
                 $post_clone.show();
               }
             }
         });
  });
  </script>
@endsection


{{-- @section('suggested_friends')
<h3 class="panel-title">Suggested Friends</h3>
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
@endsection --}}
=======
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



>>>>>>> 9e6fae337edba5e653811eba76748565b34a4bbd
