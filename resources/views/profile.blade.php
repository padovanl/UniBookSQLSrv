@extends('layouts.profile_layout')

@section('content')

<style>
.w3-teal, .w3-hover-teal:hover{
color: #fff!important;
background-color: #4285f4!important;
}

.w3-text-teal, .w3-hover-text-teal:hover {
    color: #4285f4!important;
}

</style>

<!-- Page Container -->
<div class="w3-content w3-margin-top" style="max-width:1400px;">

  <!-- The Grid -->
  <div class="w3-row-padding">

    <!-- Left Column -->
    <div class="w3-third">

      <div class="w3-white w3-text-grey w3-card-4">
        <div class="w3-display-container">
          <img src="/{{$user->pic_path}}" style="width:100%" alt="Avatar">
          <div class="w3-display-bottomleft w3-container w3-text-black">
            <h2>{{$user -> name . " " . $user -> surname}}</h2>
          </div>
        </div>
        <div class="w3-container">
          <?php if ($logged_user->id_user != $user->id_user): ?>
            <p><i class="fa fa-user-circle-o fa-fw w3-margin-right w3-large w3-text-teal" ></i>
              <button type="button"  onclick='Addfriend()'>Add Friend</button>
            </p>
            <p><i class="fa fa-comment fa-fw w3-margin-right w3-large w3-text-teal" ></i>
              <button cursor='pointer'  data-toggle="modal" data-target="#messageUserModal">Message</button>
            </p>
          <?php endif; ?>
          <p><i class="fa fa-briefcase fa-fw w3-margin-right w3-large w3-text-teal"></i>Student</p>
          <p><i class="fa fa-home fa-fw w3-margin-right w3-large w3-text-teal"></i>{{$user -> citta}}</p>
          <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-teal"></i>{{$user -> email}}</p>
          <hr>
          <p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i>Friends</b></p>
            <p> Photoshop</p>
            <div class="w3-light-grey w3-round-xlarge w3-small">
              <div class="w3-container w3-center w3-round-xlarge w3-teal" style="width:90%">90%</div>
            </div>
          <br>
          <p class="w3-large w3-text-theme"><b><i class="fa fa-globe fa-fw w3-margin-right w3-text-teal"></i>Languages</b></p>
          <p>English</p>
          <div class="w3-light-grey w3-round-xlarge">
            <div class="w3-round-xlarge w3-teal" style="height:24px;width:100%"></div>
          </div>
          <p>Spanish</p>
          <div class="w3-light-grey w3-round-xlarge">
            <div class="w3-round-xlarge w3-teal" style="height:24px;width:55%"></div>
          </div>
          <p>German</p>
          <div class="w3-light-grey w3-round-xlarge">
            <div class="w3-round-xlarge w3-teal" style="height:24px;width:25%"></div>
          </div>
          <br>
        </div>
      </div><br>
    <!-- End Left Column -->
    </div>
    <!-- Right Column -->
    <div class="padding pre-scrollable" style="max-height: 800px;">
            <!-- content -->
                <!-- main col right -->
                    <div class="well">
                      <?php if ($logged_user->id_user == $user->id_user): ?>
                        <div>
                            <h4>New Post</h4>
                            <div class="form-group text-center"> <!--se non vi piace mettete quello di prima: input-group-->
                              <input id="_token" type="hidden" value="{{ csrf_token() }}">
                                <textarea class="form-control input-lg" id="new_post_content" placeholder="Hey, What's Up?" type="text"></textarea>
                                <button onclick="newPost()" class="btn btn-lg btn-primary">Post</button>
                            </div>
                        </div>
                        <?php endif; ?>
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
                                                    <a id="name_container" href="">
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
                                                <li><a><i onclick="reaction(this.id)" style="cursor:pointer;" id="like" class="glyphicon glyphicon-thumbs-up"></i></a></li>
                                                <li><a><i onclick="reaction(this.id)" style="cursor:pointer;" id="dislike" class="glyphicon glyphicon-thumbs-down"></i></a></li>
                                                <li><a><i onclick="commentfocus(this.id)" style="cursor:pointer;" id="comment" class="glyphicon glyphicon-comment"></i> Comment</a></li>
                                                <li><a><i onclick="share(this.id)" style="cursor:pointer;" id="share" class="glyphicon glyphicon-share-alt"></i> Share</a></li>
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
                                                    <span id="comment_content"></span>
                                                  </div>
                                                  <div class="post-footer-option-container">
                                                  <ul class="list-unstyled">
                                                    <li><a><i onclick="reaction(this.id)" style="cursor:pointer;" id="likecomm" class="glyphicon glyphicon-thumbs-up"></i></a></li>
                                                    <li><a><i onclick="reaction(this.id)" style="cursor:pointer;" id="dislikecomm" class="glyphicon glyphicon-thumbs-down"></i></a></li>
                                                  </ul>
                                                </div>
                                                </div>

                                           </div>
                                           <hr>

                                           <div class="comment-form">
                                             <textarea onkeypress="newComment(event, this.id)" id="comment_insert" class="form-control" placeholder="Add a comment.." type="text"></textarea>
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
    <!-- End Right Column -->
    </div>
  <!-- End Grid -->
  </div>
  <!-- End Page Container -->
</div>


<!-- Message user modal -->
<div class="modal fade bd-example-modal-lg" id="messageUserModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titleReportComment">Nuovo messaggio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form>
          <div class="form-group">
            <label for="messageUser" class="form-control-label">Messaggio:</label>
            <textarea class="form-control" id="messageUser" rows="7"></textarea>
            <h5 id="errorMessage"></h5>
          </div>
        </form>
      </div>
      <div class="modal-footer">
         <div class="row">
          <div class="col-md-12">
           <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
           <button type="button" class="btn btn-primary" data-dismiss="modal" id="bthSendMessageUser" disabled="true">Invia messaggio</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script>

  function Addfriend(){
    var id = document.URL.split("/")[5];
    console.log(id);
    $.ajax({
       dataType: "json",
       method: "POST",
       url: "/friend/Addfriend",
       data: {id:id, _token: '{{csrf_token()}}'},
       success: function(data) {
         console.log(data.message);
       }
     });
    }

  function newComment(e, id){
    //manca controllo campo vuoto!!
    if(e.keyCode === 13){
            e.preventDefault();
            $.ajax({
              method: "POST",
              url: "/home/comment",
              dataType : "json",
              data: {content: $("#comment_insert_" + id.split("_")[2]).val(), id_post: id.split("_")[2], _token: '{{csrf_token()}}'},
               success : function (data)
               {
                 $("#comment_insert_" + id.split("_")[2]).val('');
                 $comment_clone = $("#comment_panel").clone();
                 $comment_clone.attr("id", "comment_panel_" + data.id_comment);
                 $comment_clone.find("#comm_pic_path").attr('src', data.pic_path);
                 $comment_clone.find("#comment_author").text(data.auth_name + " " + data.auth_surname);
                 $comment_clone.find("#comment_created_at").text(data.created_at);
                 $comment_clone.find("#comment_content").text(data.content);
                 $comment_clone.insertBefore("#comment_insert_" + data.id_post);
                 $comment_clone.show();
               }
            });
        }
    }

  function newPost(){
    //manca controllo che il campo non sia vuoto!
    $.ajax({
            method: "POST",
            url: "/home/post",
            data: {content: $("#new_post_content").val(), is_fixed: 0},
            dataType : "json",
            beforeSend: function (xhr) {
                 var token = '{{csrf_token()}}';

                 if (token) {
                     return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                 }
             },
            success : function (data)
            {
              $("#new_post_content").val('');
              $post_clone = $("#post").clone();
              $post_clone.attr("id", "post_" + data.id_post);
              $post_clone.find("#input_panel").attr("id", "input_panel_" + data.id_post);
              $post_clone.find("#creation_date").text(data.created_at);
              $post_clone.find("#comment_insert").attr("id", "comment_insert_" + data.id_post);
              $post_clone.find("#post_u_name").text(data.auth_name + " " + data.auth_surname);
              $post_clone.find("#post_pic_path").attr('src', data.pic_path);
              $post_clone.find("#post_content").text(data.content);
              $post_clone.find("#like_butt").text(data.likes);
              $post_clone.find("#insert_after").attr('id', "insert_after" + data.id_post);
              $post_clone.find("#name_container").attr('id', "name_container_" + data.id_post).attr('href','/profile/'+data.id_author);
              $post_clone.insertAfter(".well");
              $post_clone.show();
              $("#comment_panel").hide();

              if(data.comments.length > 0){
                for(j = 0; j < data.comments.length; j++){
                  $comment_clone = $("#comment_panel").clone();
                  $comment_clone.attr("id", "comment_panel_" + data.comments[j].id_comment);
                  $comment_clone.find("#comm_pic_path").attr('src', data.comments[j].pic_path);
                  $comment_clone.find("#comment_author").text(data.comments[j].auth_name + " " + data.comments[j].auth_surname);
                  $comment_clone.find("#comment_created_at").text(data.comments[j].created_at);
                  $comment_clone.find("#comment_content").text(data.comments[j].content);
                  $comment_clone.insertBefore("#comment_insert_" + data.id_post);
                  $comment_clone.show();
              }
            }
          }
        });
  }

  function onLoad(data){
      $("#post").hide();
      $("#comment_panel").hide();
      //ciclo su tutti i post, al contrario perchè prendo dal più recente al più vecchio
      for(var i = data.length - 1; i >= 0; i--)
      {
        $post_clone = $("#post").clone();
        $post_clone.find("#input_panel").attr("id", "input_panel_" + data[i].id_post);
        $post_clone.find("#comment_insert").attr("id", "comment_insert_" + data[i].id_post);
        $post_clone.find("#creation_date").text(data[i].created_at);
        $post_clone.attr("id", "post_" + data[i].id_post);
        $post_clone.find("#post_u_name").text(data[i].auth_name + " " + data[i].auth_surname);
        $post_clone.find("#post_pic_path").attr('src', data[i].pic_path);
        $post_clone.find("#post_content").text(data[i].content);
        $post_clone.find("#like_butt").text(data[i].likes);
        $post_clone.find("#insert_after").attr('id', "insert_after" + data[i].id_post);
        $post_clone.insertAfter(".well");
        $post_clone.show();
        }
        data.forEach(function(el) {
          //carico i commenti
          if(el.comments.length > 0 && el.id_post == el.comments[0].id_post){
            for(j = 0; j < el.comments.length; j++){
              $comment_clone = $("#comment_panel").clone();
              $comment_clone.attr("id", "comment_panel_" + el.comments[j].id_comment);
              $comment_clone.find("#comm_pic_path").attr('src', el.comments[j].pic_path);
              $comment_clone.find("#comment_author").text(el.comments[j].auth_name + " " + el.comments[j].auth_surname);
              $comment_clone.find("#comment_created_at").text(el.comments[j].created_at);
              $comment_clone.find("#comment_content").text(el.comments[j].content);
              $comment_clone.insertBefore("#comment_insert_" + el.id_post);
              $comment_clone.show();
        }
      }
    })
  }

  function loadOlder(){
    $prev_post = $("#post").prev();
    $post_id = $prev_post.attr("id").split("_")[1];
    var id = document.URL.split("/")[5];
    //console.log(id);
    $.ajax({
            method: "GET",
            url: "/profile/user/{{$user -> id_user}}/loadmore",
            data: { post_id: $post_id, id: id },
            dataType : "json",
            success : function (posts)
            {
              if(posts.length != 0)
              {
                for(var x = posts.length - 1; x >= 0 ; x--)
                {
                  $post_clone = $("#post").clone();
                  $post_clone.find("#input_panel").attr("id", "input_panel_" + posts[x].id_post);
                  $post_clone.find("#comment_insert").attr("id", "comment_insert_" + posts[x].id_post);
                  $post_clone.find("#creation_date").text(posts[x].created_at);
                  $post_clone.attr("id", "post_" + posts[x].id_post);
                  $post_clone.find("#post_u_name").text(posts[x].auth_name + " " + posts[x].auth_surname);
                  $post_clone.find("#post_pic_path").attr('src', posts[x].pic_path);
                  $post_clone.find("#post_content").text(posts[x].content);
                  $post_clone.find("#like_butt").text(posts[x].likes);
                  $post_clone.find("#insert_after").attr('id', "insert_after" + posts[x].id_post);
                  $post_clone.insertAfter("#post_" + $post_id);
                  $post_clone.show();
                  $("#comment_panel").hide();

                  }
                  posts.forEach(function(el) {
                    //carico i commenti
                    if(el.comments.length > 0 && el.id_post == el.comments[0].id_post){
                      for(j = 0; j < el.comments.length; j++){
                        $comment_clone = $("#comment_panel").clone();
                        $comment_clone.attr("id", "comment_panel_" + el.comments[j].id_comment);
                        $comment_clone.find("#comm_pic_path").attr('src', el.comments[j].pic_path);
                        $comment_clone.find("#comment_author").text(el.comments[j].auth_name + " " + el.comments[j].auth_surname);
                        $comment_clone.find("#comment_created_at").text(el.comments[j].created_at);
                        $comment_clone.find("#comment_content").text(el.comments[j].content);
                        $comment_clone.insertBefore("#comment_insert_" + el.id_post);
                        $comment_clone.show();
                  }
                }
              })
              }
              else{
                $("#load").text("Nothing More!");
              }
            }
          })
  }
  //Caricamento dei post
  var pathArray = window.location.pathname.split( '/' );
  var profileId = pathArray[3];
  //console.log(profileId);
  $(document).ready(function(){
         $.ajax({
             url : "/profile/user/" + profileId + "/loadmore",
             //url : '/profile/user/loadmore',
             method : "GET",
             dataType : "json",
             data: { post_id: -1 },
             success : function (posts)
             {
               onLoad(posts);
             }
         });
    });

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

  $('#reportModal').on('hide.bs.modal', function(event){
    //rimuovo gli eventi una volta che chiudo il modal
    $('#btnReportPost').unbind();
  });

  $('.pre-scrollable').attr('style', 'max-height:' + $(window).height() + 'px;');

  function commentfocus(id){
    $("#comment_insert_" + id.split("_")[1]).focus();
  }

  function reaction(id){
    //console.log(id);
    $.ajax({
      method: "POST",
      dataType: "json",
      url: "/home/reaction",
      data: {action: id.split("_")[0], id: id.split("_")[1], _token: '{{csrf_token()}}'},
       success : function (data)
       {
         console.log(data);
         switch (data.type) {
           case "post":
             $("#like_" + data.id_post).css({ 'color': data.status_like })
             $("#dislike_" + data.id_post).css({ 'color': data.status_dislike });
             break;
           case "comm":
             $("#likecomm_" + data.id_comment).css({ 'color': data.status_like })
             $("#dislikecomm_" + data.id_comment).css({ 'color': data.status_dislike });
             break;
         }
       }
    })
  }

  function createcomment(comment){
    $comment_clone = $("#comment_panel").clone();
    $comment_clone.attr("id", "comment_panel_" + comment.id_comment);
    $comment_clone.find("#comm_pic_path").attr('src', comment.pic_path);
    $comment_clone.find("#comment_author").html('&nbsp;&nbsp;' + comment.auth_name + " " + comment.auth_surname);
    $comment_clone.find("#comment_created_at").text(comment.created_at);
    $comment_clone.find("#comment_content").text(comment.content);
    if(comment.userlike == '0'){
      $comment_clone.find("#dislikecomm").css({ 'color': 'red'}).attr('id', 'dislikecomm_' + comment.id_post);;
      $comment_clone.find("#likecomm").attr('id', 'likecomm_' + comment.id_post);
    }
    else if(comment.userlike == '1'){
      $comment_clone.find("#likecomm").css({ 'color': 'blue'}).attr('id', 'likecomm_' + comment.id_post);
      $comment_clone.find("#dislikecomm").attr('id', 'dislikecomm_' + comment.id_post);
    }
    else{
      $comment_clone.find("#likecomm").attr('id', 'likecomm_' + comment.id_post);
      $comment_clone.find("#dislikecomm").attr('id', 'dislikecomm_' + comment.id_post);
    }
    return($comment_clone);
  }

  $('#messageUserModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    //var recipient = button.data('whatever') // Extract info from data-* attributes
    var post;

    $('#bthSendMessageUser').click(function(){
      var message = $('#messageUser').val();
      var recipient = document.URL.split("/")[5];
      console.log(recipient);
      $.ajax({
        dataType: 'json',
        type: 'POST',
        url: '/admin/dashboard/sendMessageUser',
        data: { id_user: recipient, message: message }
      }).done(function (data) {
        $('#messageUser').val('');
        toastr.success(data.body, data.message , { timeOut: 5000 });
      });
    });

    $('#messageUser').keyup(function(event){
      var text = $('#messageUser').val();
      if(text == ''){
        $('#bthSendMessageUser').attr('disabled', true);
      }else{
        $('#bthSendMessageUser').attr('disabled', false);
      }
    });



  });

  $('#messageUserModal').on('hide.bs.modal', function(event){
    //rimuovo gli eventi una volta che chiudo il modal
    $('#bthSendMessageUser').unbind();
    $('#messageUser').unbind();
  });



</script>
@endsection
