@extends('layouts.app')
@section('content')
<article class="content">
    <div class="padding pre-scrollable" style="max-height: 800px;">
            <!-- content -->
                <!-- main col right -->
                    <div class="well">
                        <div>
                            <h4>Nuovo post</h4>
                            <div class="form-group text-center"> <!--se non vi piace mettete quello di prima: input-group-->
                              <input id="_token" type="hidden" value="{{ csrf_token() }}">
                                <textarea class="form-control input-lg form-rounded" id="new_post_content" placeholder="Hey, What's Up?" type="text"></textarea>
                                <button onclick="newPost()" class="btn btn-lg btn-primary">Post</button>
                            </div>
                        </div>
                    </div>
                    <!--Pannello Post-->
                    <div class="container" id="post">
                      <div class="row">
                          <div class="col-md-9" style="width: 1000px; margin: 0 auto;">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                   <section class="post-heading">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="media">
                                                  <div class="media-left">
                                                    <a id="img_container" href="#">
                                                      <img id="post_pic_path" class="media-object photo-profile" src="" width="40" height="40" alt="..." style="border-radius: 50%;">
                                                    </a>
                                                  </div>
                                                  <div class="media-body">
                                                    <a href="#" id="post_u_name" class="anchor-username"><h4 class="media-heading">User_name</h4></a>
                                                    <a href="#" id="creation_date" class="anchor-time">time</a>
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                              <a id="reportingPost" href="#reportModal" data-toggle="modal" data-whatever="5" style="font-size: 15px;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;Segnala</a>
                                            </div>

                                        </div>
                                   </section>
                                   <section class="post-body">
                                       <p id="post_content">content</p>
                                   </section>
                                   <section class="post-footer">
                                       <hr>
                                       <div class="post-footer-option container">
                                            <ul id="option_" class="list-unstyled">
                                                <li>
                                                  <a>
                                                    <i onclick="reaction(this.id)" style="cursor:pointer;" id="like" class="dropbtn glyphicon glyphicon-thumbs-up"></i>
                                                  </a>
                                                </li>
                                                <li><a><i onclick="reaction(this.id)" style="cursor:pointer;" id="dislike" class="glyphicon glyphicon-thumbs-down"></i></a></li>
                                                <li><a><i onclick="commentfocus(this.id)" style="cursor:pointer;" id="comment" class="glyphicon glyphicon-comment"></i> Comment</a></li>
                                            </ul>
                                       </div>
                                       <div class="post-footer-comment-wrapper">
                                           <div id="comment_panel" class="comment">
                                                <div class="media">
                                                  <div class="media-left">
                                                    <a href="#">
                                                      <img id="comm_pic_path" class="media-object photo-profile" src="" width="32" height="32" alt="..." style="border-radius: 50%;">
                                                    </a>
                                                  </div>
                                                  <div class="media-body">
                                                    <a href="#" id="comment_author" class="anchor-username"><h4 class="media-heading">Media heading</h4></a>
                                                    <a href="#" id="comment_created_at" class="anchor-time">51 mins</a>
                                                    <br>
                                                    <span id="comment_content"></span>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-md-12">
                                                      <a><i onclick="reaction(this.id)" style="cursor:pointer;" id="likecomm" class="glyphicon glyphicon-thumbs-up"></i></a>
                                                      <a><i onclick="reaction(this.id)" style="cursor:pointer;" id="dislikecomm" class="glyphicon glyphicon-thumbs-down"></i></a>
                                                      <a style="cursor: pointer;" id="reportingComment" href="#reportComment" data-toggle="modal" data-whatever="5"><i class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></i></a>
                                                  </div>
                                                  </div>
                                                </div>
                                           </div>
                                           <hr>

                                           <div class="comment-form">
                                             <textarea onkeypress="newComment(event, this.id)" id="comment_insert" class="form-control form-rounded" placeholder="Add a comment.." type="text"></textarea>
                                           </div>
                                       </div>
                                   </section>
                                </div>
                            </div>
                      </div>
                      </div>

                    </div>
    </div><!-- /padding -->

    <div class="row">
      <div class="col-md-12" style="text-align:center;">
          <button id="load" onclick="loadOlder()" type="button" class="button btn-primary" style="border-radius: 5px;">Carica post più vecchi...</button>
      </div>
    </div>

</article>

<article class="side">Amici Suggeriti
  @foreach($suggested_friends as $suggested)
    <a href="/profile/user/{{$suggested->id_user}}">
      <div class="container">
      	<div class="row">
              <div class="profile-header-container">
          		<div class="profile-header-img">
                      <img class="img-circle" src="{{$suggested->pic_path}}" />
                      <!-- badge -->
                      <div class="rank-label-container">
                          <span class="label label-default rank-label">{{$suggested->name . " " . $suggested->surname}}</span>
                      </div>
                  </div>
              </div>
      	</div>
      </div>
    </a>

@endforeach
</article>

<!--Report modal-->
<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Segnala post</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal-body-post">
        <div class="form-group">
          <label for="reasonReportPost">Selezione il motivo della segnalazione:</label>
          <select class="form-control" id="reasonReportPost">
            <option selected>Incita all'odio</option>
            <option>È una minaccia</option>
            <option>È una notizia falsa</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
          <div class="col-md-5">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
          </div>
          <div class="col-md-5">
            <button type="button" class="btn btn-primary" id="btnReportPost">Segnala</button>
          </div>
      </div>
    </div>
  </div>
</div>

<!--Report comment modal-->
<div class="modal fade" id="reportComment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Segnala commento</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal-body-comment">
        <div class="form-group">
          <label for="reasonReportComment">Selezione il motivo della segnalazione:</label>
          <select class="form-control" id="reasonReportComment">
            <option selected>Incita all'odio</option>
            <option>È una minaccia</option>
            <option>È una notizia falsa</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
          <div class="col-md-5">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
          </div>
          <div class="col-md-5">
            <button type="button" class="btn btn-primary" id="btnReportComment">Segnala</button>
          </div>
      </div>
    </div>
  </div>
</div>


<script>
$('#reportModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  $('#btnReportPost').click(function(){
    var motivo = $('#reasonReportPost').find(":selected").text();
    $.ajax({
      dataType: 'json',
      type: 'POST',
      url: '/home/reportPost',
      data: { id_post: recipient, motivo: motivo }
    }).done(function (data) {
      var html = '<h3>La segnalazione è stata inviata con successo agli amministratori di UniBook, grazie per la tua collaborazione!</h3>';
      $('#modal-body-post').html(html);
      $('#btnReportPost').hide();
    });
  });


  var modal = $(this);
  modal.find('.modal-title').text('Segnala post');
});

$('#reportModal').on('hidden.bs.modal', function(event){
  //rimuovo gli eventi una volta che chiudo il modal
  $('#btnReportPost').unbind();
  $('#btnReportPost').show();
  var html =  '<div class="form-group">';
  html +=     ' <label for="reasonReportPost">Selezione il motivo della segnalazione:</label>';
  html +=     ' <select class="form-control" id="reasonReportPost">';
  html +=     '   <option selected>Incita all\'odio</option>';
  html +=     '   <option>È una minaccia</option>';
  html +=     '   <option>È una notizia falsa</option>';
  html +=     ' </select>';
  html +=     '</div>';
  $('#modal-body-post').html(html);
});

$('#reportComment').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  $('#btnReportComment').click(function(){
    var motivo = $('#reasonReportComment').find(":selected").text();
    $.ajax({
      dataType: 'json',
      type: 'POST',
      url: '/home/reportComment',
      data: { id_comment: recipient, motivo: motivo }
    }).done(function (data) {
      var html = '<h3>La segnalazione è stata inviata con successo agli amministratori di UniBook, grazie per la tua collaborazione!</h3>';
      $('#modal-body-comment').html(html);
      $('#btnReportComment').hide();
    });
  });


  var modal = $(this);
  modal.find('.modal-title').text('Segnala commento');
});

$('#reportComment').on('hidden.bs.modal', function(event){
  //rimuovo gli eventi una volta che chiudo il modal
  $('#btnReportComment').unbind();
  $('#btnReportComment').show();
  var html =  '<div class="form-group">';
  html +=     ' <label for="reasonReportComment">Selezione il motivo della segnalazione:</label>';
  html +=     ' <select class="form-control" id="reasonReportComment">';
  html +=     '   <option selected>Incita all\'odio</option>';
  html +=     '   <option>È una minaccia</option>';
  html +=     '   <option>È una notizia falsa</option>';
  html +=     ' </select>';
  html +=     '</div>';
  $('#modal-body-comment').html(html);
});

$('.pre-scrollable').attr('style', 'max-height:' + $(window).height() + 'px;');

//Caricamento dei post
$(document).ready(function(){
     $.ajax({
         url : '/home/loadmore',
         method : "GET",
         dataType : "json",
         data: { post_id: -1, home: 1 },
         success : function (posts)
         {
           console.log(posts);
           onLoad(posts);
         }
     });
});

</script>



@endsection
