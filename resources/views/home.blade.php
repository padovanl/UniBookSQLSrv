@extends('layouts.app')

@section('content')
  <article class="content">
  <div class="padding pre-scrollable" style="max-height: 800px;">
          <!-- content -->
              <!-- main col right -->
                  <div class="well">
                      <div>
                          <h4>New Post</h4>
                          <div class="form-group text-center"> <!--se non vi piace mettete quello di prima: input-group-->
                            <input id="_token" type="hidden" value="{{ csrf_token() }}">
                              <textarea class="form-control input-lg" id="new_post_content" placeholder="Hey, What's Up?" type="text"></textarea>
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
                                                  <a href="#">
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
                                            <a href="#" style="font-size: 15px;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;Segnala</a>
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
                                              <li><a><i onclick="reaction(this.id)" style="cursor:pointer;" id="like" class="glyphicon glyphicon-thumbs-up"> Like</i></a></li>
                                              <li><a><i onclick="reaction(this.id)" style="cursor:pointer;" id="dislike" class="glyphicon glyphicon-thumbs-down"> Dislike</i></a></li>
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
                                                  <li><a><i onclick="reaction(this.id)" style="cursor:pointer;" id="likecomm" class="glyphicon glyphicon-thumbs-up">Like</i></a></li>
                                                  <li><a><i onclick="reaction(this.id)" style="cursor:pointer;" id="dislikecomm" class="glyphicon glyphicon-thumbs-down">Dislike</i></a></li>
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

</article>
<aside class="side">Sidebar</aside>
</div>

<style>
  .pre-scrollable {
    overflow-y: scroll;
    overflow-x: hidden;
  }
</style>

<script>
  $('.pre-scrollable').attr('style', 'max-height:' + $(window).height() + 'px;');
  $
</script>

<script>

function commentfocus(id){
    $("#comment_insert_" + id.split("_")[1]).focus();
}


function reaction(id){
  console.log(id)
  $.ajax({
    method: "POST",
    url: "/home/reaction",
    dataType: "json",
    data: {action: id.split("_")[0], id: id.split("_")[1], _token: '{{csrf_token()}}'},
     success : function (data)
     {
       switch (data.type) {
         case "post":
           $("#like_" + data.id_post).css({ 'color': data.status_like })
           $("#dislike_" + data.id_post).css({ 'color': data.status_dislike });
           break;
         case "comm":
          console.log("like: " + data.status_like + " dislike: " + data.status_dislike);
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

function createPost(data){
  console.log(data);
  $post_clone = $("#post").clone();
  $post_clone.attr("id", "post_" + data.id_post);
  $post_clone.find("#input_panel").attr("id", "input_panel_" + data.id_post);
  $post_clone.find("#creation_date").text(data.created_at);
  $post_clone.find("#comment_insert").attr("id", "comment_insert_" + data.id_post);
  $post_clone.find("#post_u_name").html("&nbsp;&nbsp;" + data.auth_name + " " + data.auth_surname);
  $post_clone.find("#post_pic_path").attr('src', data.pic_path);
  $post_clone.find("#post_content").text(data.content);
  $post_clone.find("#like_butt").text(data.likes);
  $post_clone.find("#insert_after").attr('id', "insert_after" + data.id_post);
  if(data.userlike == '0'){
    $post_clone.find("#dislike").css({ 'color': 'red'}).attr('id', 'like_' + data.id_post);;
    $post_clone.find("#like").css({ 'color': 'black'}).attr('id', 'dislike_' + data.id_post);
  }
  else if(data.userlike == '1'){
    $post_clone.find("#like").css({ 'color': 'blue'}).attr('id', 'like_' + data.id_post);
    $post_clone.find("#dislike").css({ 'color': 'black'}).attr('id', 'dislike_' + data.id_post);
  }
  else{
    $post_clone.find("#like").css({ 'color': 'black'}).attr('id', 'like_' + data.id_post);
    $post_clone.find("#dislike").css({ 'color': 'black'}).attr('id', 'dislike_' + data.id_post);
  }
  $post_clone.find("#comment").attr('id', 'comment_' + data.id_post);
  $post_clone.find("#share").attr('id', 'share_' + data.id_post);

  return($post_clone);
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
               if(data.ban != 1){
                 $("#comment_insert_" + id.split("_")[2]).val('');
                 createcomment(data);
                 $comment_clone.insertBefore("#comment_insert_" + data.id_post);
                 $comment_clone.show();
               }
               else{
                 alert("Non puoi commentare, sei bannato!");
               }
             }
          })
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
            if(data.ban != 1){
              $("#new_post_content").val('');
              $post_clone = createPost(data)
              $post_clone.insertAfter(".well");
              $post_clone.show();
              $("#comment_panel").hide();
              if(data.comments.length > 0){
                for(j = 0; j < data.comments.length; j++){
                  $comment_clone = createcomment(data.comments[j]);
                  $comment_clone.insertBefore("#comment_insert_" + data.id_comment);
                  $comment_clone.show();
              }
            }
            }
            else{
              alert("non puoi fare post, sei bannato!");
            }

        }
      });
}


function onLoad(data){
  $("#post").hide();
  $("#comment_panel").hide();
  //ciclo su tutti i post, al contrario perchè prendo dal più recente al più vecchio
  console.log(data);
  for(var i = data.length - 1; i >= 0; i--)
  {
    $post_clone = createPost(data[i]);
    $post_clone.insertAfter(".well");
    $post_clone.show();
    }
    data.forEach(function(el) {
      //carico i commenti
      if(el.comments.length > 0 && el.id_post == el.comments[0].id_post){
        for(j = 0; j < el.comments.length; j++){
          $comment_clone = createcomment(el.comments[j]);
          $comment_clone.insertBefore("#comment_insert_" + el.id_post);
          $comment_clone.show();
    }
  }
})
}

function loadOlder(){
  $prev_post = $("#post").prev();
  $post_id = $prev_post.attr("id").split("_")[1];
  $.ajax({
          method: "GET",
          url: "/home/loadmore",
          data: { post_id: $post_id },
          dataType : "json",
          success : function (posts)
          {
            if(posts.length != 0)
            {
              for(var x = posts.length - 1; x >= 0 ; x--)
              {
                $post_clone = createPost(posts[x]);
                $post_clone.insertAfter("#post_" + $post_id);
                $post_clone.show();
                $("#comment_panel").hide();

                }
                posts.forEach(function(el) {
                  //carico i commenti
                  if(el.comments.length > 0 && el.id_post == el.comments[0].id_post){
                    for(j = 0; j < el.comments.length; j++){
                      $comment_clone = createcomment(el.comments[j]);
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
$(document).ready(function(){
     $.ajax({
         url : '/home/loadmore',
         method : "GET",
         dataType : "json",
         data: { post_id: -1 },
         success : function (posts)
         {
           onLoad(posts);
         }
     });
});

</script>

@endsection
