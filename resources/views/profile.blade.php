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
          <img src="/{{$logged_user ->pic_path}}" style="width:100%" alt="Avatar">
          <div class="w3-display-bottomleft w3-container w3-text-black">
            <h2>{{$logged_user -> name . " " . $logged_user -> surname}}</h2>
          </div>
        </div>
        <div class="w3-container">
          <p><i class="fa fa-briefcase fa-fw w3-margin-right w3-large w3-text-teal"></i>Designer</p>
          <p><i class="fa fa-home fa-fw w3-margin-right w3-large w3-text-teal"></i>{{$logged_user -> citta}}</p>
          <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-teal"></i>{{$logged_user -> email}}</p>
          <!--<p><i class="fa fa-phone fa-fw w3-margin-right w3-large w3-text-teal"></i>1224435534</p> -->
          <hr>

          <p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i>Skills</b></p>
          <p>Adobe Photoshop</p>
          <div class="w3-light-grey w3-round-xlarge w3-small">
            <div class="w3-container w3-center w3-round-xlarge w3-teal" style="width:90%">90%</div>
          </div>
          <p>Photography</p>
          <div class="w3-light-grey w3-round-xlarge w3-small">
            <div class="w3-container w3-center w3-round-xlarge w3-teal" style="width:80%">
              <div class="w3-center w3-text-white">80%</div>
            </div>
          </div>
          <p>Illustrator</p>
          <div class="w3-light-grey w3-round-xlarge w3-small">
            <div class="w3-container w3-center w3-round-xlarge w3-teal" style="width:75%">75%</div>
          </div>
          <p>Media</p>
          <div class="w3-light-grey w3-round-xlarge w3-small">
            <div class="w3-container w3-center w3-round-xlarge w3-teal" style="width:50%">50%</div>
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
    <div class="w3-twothird">

        <div class="padding">
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
    </div>
    <button id="load" onclick="loadOlder()" type="button"/>Load More..

    <!--
      <div class="w3-container w3-card w3-white w3-margin-bottom">
        <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-suitcase fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Work Experience</h2>
        <div class="w3-container">
          <h5 class="w3-opacity"><b>Front End Developer / w3schools.com</b></h5>
          <h6 class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i>Jan 2015 - <span class="w3-tag w3-teal w3-round">Current</span></h6>
          <p>Lorem ipsum dolor sit amet. Praesentium magnam consectetur vel in deserunt aspernatur est reprehenderit sunt hic. Nulla tempora soluta ea et odio, unde doloremque repellendus iure, iste.</p>
          <hr>
        </div>
        <div class="w3-container">
          <h5 class="w3-opacity"><b>Web Developer / something.com</b></h5>
          <h6 class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i>Mar 2012 - Dec 2014</h6>
          <p>Consectetur adipisicing elit. Praesentium magnam consectetur vel in deserunt aspernatur est reprehenderit sunt hic. Nulla tempora soluta ea et odio, unde doloremque repellendus iure, iste.</p>
          <hr>
        </div>
        <div class="w3-container">
          <h5 class="w3-opacity"><b>Graphic Designer / designsomething.com</b></h5>
          <h6 class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i>Jun 2010 - Mar 2012</h6>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p><br>
        </div>
      </div>
    -->
      <!--
      <div class="w3-container w3-card w3-white">
        <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-certificate fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Education</h2>
        <div class="w3-container">
          <h5 class="w3-opacity"><b>W3Schools.com</b></h5>
          <h6 class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i>Forever</h6>
          <p>Web Development! All I need to know in one place</p>
          <hr>
        </div>
        <div class="w3-container">
          <h5 class="w3-opacity"><b>London Business School</b></h5>
          <h6 class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i>2013 - 2015</h6>
          <p>Master Degree</p>
          <hr>
        </div>
        <div class="w3-container">
          <h5 class="w3-opacity"><b>School of Coding</b></h5>
          <h6 class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i>2010 - 2013</h6>
          <p>Bachelor Degree</p><br>
        </div>
      </div>
      -->
    <!-- End Right Column -->
    </div>

  <!-- End Grid -->
  </div>

  <!-- End Page Container -->
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
          url: "/profile/user/"+{{$logged_user -> id_user }}+"/loadmore",
          //url : '/profile/user/loadmore',
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
         url : "/profile/user/"+{{$logged_user -> id_user }}+"/loadmore",
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

</script>
@endsection
