@extends('layouts.app')

@section('content')
  <article class="content">
  <div class="padding">
          <!-- content -->
              <!-- main col right -->
                  <div class="well">
                      <div>
                          <h4>New Post</h4>
                          <div class="input-group text-center">
                            <input id="_token" type="hidden" value="{{ csrf_token() }}">
                              <input class="form-control input-lg" id="new_post_content" placeholder="Hey, What's Up?" type="text">
                              <button onclick="newPost()" class="btn btn-lg btn-primary">Post</button>
                          </div>
                      </div>
                  </div>
                  {{-- <div class="panel panel-default" id="post">
                    <div class="panel-heading">
                      <ul class="nav navbar-nav navbar-right">
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
                        <!--Post Header-->
                        <div>
                          <img id="post_pic_path" style="width:50px; border-radius:50%" >
                          <a href="" id="post_u_name" style="">User Name</a>
                          <span id="creation_date"></span>
                        </div>
                    </div>

                    <!--Post Content-->
                    <div class="panel-body">
                    <p id="post_content">Content</p>
                    <div id="insert_after" class="clearfix"></div>
                    <!--Comment Panel-->
                    <!--Comment Form-->
                    <div class="input-group" id="input_panel">
                      <button id="like_butt" class="btn btn-default">+1</button><button class="btn btn-default"><i class="glyphicon glyphicon-share"></i></button>
                      <input onkeypress="newComment(event, this.id)" id="comment_insert" class="form-control" placeholder="Add a comment.." type="text">
                    </div>
                  </div>
                  <hr> --}}
                  <!--Pannello Post-->
                  <div class="container" id="post">
                  	<div class="col-md-7">
                          <div class="panel panel-default">
                              <div class="panel-body">
                                 <section class="post-heading">
                                      <div class="row">
                                          <div class="col-md-11">
                                              <div class="media">
                                                <div class="media-left">
                                                  <a href="#">
                                                    <img id="post_pic_path" class="media-object photo-profile" src="" width="40" height="40" alt="...">
                                                  </a>
                                                </div>
                                                <div class="media-body">
                                                  <a href="#" id="post_u_name" class="anchor-username"><h4 class="media-heading">User_name</h4></a>
                                                  <a href="#" id="creation_date" class="anchor-time">time</a>
                                                </div>
                                              </div>
                                          </div>
                                           <div class="col-md-1">
                                               <a href="#"><i class="glyphicon glyphicon-chevron-down"></i></a>
                                           </div>
                                      </div>
                                 </section>
                                 <section class="post-body">
                                     <p id="post_content">content</p>
                                 </section>
                                 <section class="post-footer">
                                     <hr>
                                     <div class="post-footer-option container">
                                          <ul class="list-unstyled">
                                              <li><a href="#"><i class="glyphicon glyphicon-thumbs-up"></i> Like</a></li>
                                              <li><a href="#"><i class="glyphicon glyphicon-thumbs-down"></i> Dislike</a></li>
                                              <li><a href="#"><i class="glyphicon glyphicon-comment"></i> Comment</a></li>
                                              <li><a href="#"><i class="glyphicon glyphicon-share-alt"></i> Share</a></li>
                                          </ul>
                                     </div>
                                     <div class="post-footer-comment-wrapper">
                                         <div id="comment_panel" class="comment">
                                              <div class="media">
                                                <div class="media-left">
                                                  <a href="#">
                                                    <img id="comm_pic_path" class="media-object photo-profile" src="" width="32" height="32" alt="...">
                                                  </a>
                                                </div>
                                                <div class="media-body">
                                                  <a href="#" id="comment_author" class="anchor-username"><h4 class="media-heading">Media heading</h4></a>
                                                  <a href="#" id="comment_created_at" class="anchor-time">51 mins</a>
                                                </div>
                                              </div>
                                              <span id="comment_content"></span>
                                         </div>
                                         <hr>

                                         <div class="comment-form">
                                           <input onkeypress="newComment(event, this.id)" id="comment_insert" class="form-control" placeholder="Add a comment.." type="text">
                                         </div>
                                     </div>
                                 </section>
                              </div>
                          </div>
                  	</div>
                  </div>

  </div><!-- /padding -->
  <button id="load" onclick="loadOlder()" type="button"/>Load More..
</article>
<aside class="side">Sidebar</aside>
</div>

<script>

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
