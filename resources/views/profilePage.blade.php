@extends('layouts.profile_layout') @section('content')


<style>
  .w3-teal,
  .w3-hover-teal:hover {
    color: #fff!important;
    background-color: #4285f4!important;
  }

  .w3-text-teal,
  .w3-hover-text-teal:hover {
    color: #4285f4!important;
  }
</style>
<nav class="main-nav">
  <div class="side-sec">
    <!-- Left Column -->
    <div class="w3-display-container">
      <img src="/{{$page->pic_path}}" style="width:100%" alt="Avatar">
      <div class="w3-display-bottomleft w3-container w3-text-black">
        <h2>{{$page -> name}}</h2>
      </div>
    </div>
    <div class="w3-container">
      <br />
      <div id="divFollowPage">
        @if($alreadyFollow)
        <p id="stopFollowP" style="text-align: center; color: red;">
          <a style="cursor: pointer; font-size: 20px;" onclick="stopFollow({{$page->id_page}}, '{{$logged_user->id_user}}')">
            <i style="cursor:pointer; color: red;" id="follow" class="glyphicon glyphicon-thumbs-down"></i>&nbsp;Smetti di seguire la pagina</a>
        </p>
        @else
        <p id="followP" style="text-align: center; color: blue;">
          <a style="cursor: pointer; font-size: 20px;" onclick="follow({{$page->id_page}}, '{{$logged_user->id_user}}')">
            <i style="cursor:pointer; color: blue;" id="follow" class="glyphicon glyphicon-thumbs-up"></i>&nbsp;Segui</a>
        </p>
        @endif
        <br />
        <div id="totFollowers">
          <p style="text-align: center; color: blue; font-size: 20px;">
            <i style="color: blue;" id="like" class="glyphicon glyphicon-user"></i>&nbsp;{{$tot_followers}}&nbsp;persone seguono questa pagina</p>
        </div>
      </div>
      <!--<p><i class="fa fa-phone fa-fw w3-margin-right w3-large w3-text-teal"></i>1224435534</p> -->
      <hr> @if($logged_user->id_user == $page->id_user)
      <p class="w3-large">
        <b>
          <i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i>Opzioni</b>
      </p>
      <p>Invita i tuoi amici a mettere mi piace alla tua pagina!</p>
      <div style="text-align: center;">
        <button type="button" class="btn btn-primary" style="display: block; margin: 0 auto;" onclick="InvitaAmici({{$page->id_page}});">Invita</button>
        <br />
        <span id="spanInviti"></span>
      </div>
      <br> @endif
    </div>
  </div>
  <br>
  <!-- End Left Column -->
</nav>
<article class="content">
  <!-- Right Column -->
  <div class="padding pre-scrollable" style="max-height: 800px;">
    <?php if ($logged_user->id_user == $page->id_user): ?>
    <div class="well">
      <div>
        <h4>New Post</h4>
        <div class="form-group text-center">
          <!--se non vi piace mettete quello di prima: input-group-->
          <input id="_token" type="hidden" value="{{ csrf_token() }}">
          <textarea class="form-control input-lg" id="new_post_content" placeholder="Hey, What's Up?" type="text" style="border-radius: 20px;"></textarea>
          <button onclick="newPost()" class="btn btn-lg btn-primary">Post</button>
        </div>
      </div>
    </div>
    <?php endif; ?>
    <!--Pannello Post-->
    <div class="container" id="post">
      <div class="row">
        <div class="col-md-10" style="width: 1000px; margin: 0 auto;">
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
                        <a href="#" id="post_u_name" class="anchor-username">
                          <h4 class="media-heading">User_name</h4>
                        </a>
                        <a href="#" id="creation_date" class="anchor-time">time</a>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <a id="reportingPost" href="#reportModal" data-toggle="modal" data-whatever="5" style="font-size: 15px;">
                      <i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;Segnala</a>
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
                        <i onclick="reaction(this.id)" style="cursor:pointer;" id="like" class="glyphicon glyphicon-thumbs-up"></i>
                      </a>
                    </li>
                    <li>
                      <a>
                        <i onclick="reaction(this.id)" style="cursor:pointer;" id="dislike" class="glyphicon glyphicon-thumbs-down"></i>
                      </a>
                    </li>
                    <li>
                      <a>
                        <i onclick="commentfocus(this.id)" style="cursor:pointer;" id="comment" class="glyphicon glyphicon-comment"></i> Comment</a>
                    </li>
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
                        <a href="#" id="comment_author" class="anchor-username">
                          <h4 class="media-heading">Media heading</h4>
                        </a>
                        <a href="#" id="comment_created_at" class="anchor-time">51 mins</a>
                        <br>
                        <span id="comment_content"></span>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <a>
                            <i onclick="reaction(this.id)" style="cursor:pointer;" id="likecomm" class="glyphicon glyphicon-thumbs-up"></i>
                          </a>
                          <a>
                            <i onclick="reaction(this.id)" style="cursor:pointer;" id="dislikecomm" class="glyphicon glyphicon-thumbs-down"></i>
                          </a>
                          <a style="cursor: pointer;" id="reportingComment" href="#reportComment" data-toggle="modal" data-whatever="5">
                            <i class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr>

                  <div class="comment-form">
                    <textarea onkeypress="newComment(event, this.id)" id="comment_insert" class="form-control form-rounded" placeholder="Add a comment.."
                      type="text"></textarea>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>
  <!-- /padding -->
  <div class="row">
    <div class="col-md-12" style="text-align:center;">
      <button id="load" onclick="loadOlder()" type="button" class="button btn-primary" style="border-radius: 5px;">Carica post più vecchi...</button>
    </div>
  </div>
  <!-- End Right Column -->
  </div>

  <!-- End Grid -->
  </div>

  </div>
  <!-- /padding -->
  <!-- End Right Column -->
</article>SSS

<script>
  $('.pre-scrollable').attr('style', 'max-height:' + $(window).height() + 'px;');
</script>

<script>
  function stopFollow(id_page, id_user) {
    $.ajax({
      dataType: 'json',
      type: 'POST',
      url: '/profile/page/stopFollow',
      data: { id_page: id_page, id_user: id_user }
    }).done(function (data) {
      $('#stopFollowP').remove();
      var html = '<p id="followP" style="text-align: center; color: blue;"><a style="cursor: pointer; font-size: 20px;" onclick="follow({{$page->id_page}}, \'{{$logged_user->id_user}}\')"><i style="cursor:pointer; color: blue;" id="follow" class="glyphicon glyphicon-thumbs-up"></i>&nbsp;Segui</a></p>';
      $('#divFollowPage').html(html);

      var t = $('#totFollowers');
      $('#totFollowers').html('<p style="text-align: center; color: blue; font-size: 20px;"><i style="color: blue;" id="like" class="glyphicon glyphicon-user"></i>&nbsp;' + data.tot_followers + ' persone seguono questa pagina</p>');
    });



  }

  function follow(id_page, id_user) {
    $.ajax({
      dataType: 'json',
      type: 'POST',
      url: '/profile/page/follow',
      data: { id_page: id_page, id_user: id_user }
    }).done(function (data) {
      $('#followP').remove();
      var html = ' <p id="stopFollowP" style="text-align: center; color: red;"><a style="cursor: pointer; font-size: 20px;" onclick="stopFollow({{$page->id_page}}, \'{{$logged_user->id_user}}\')"><i style="cursor:pointer; color: red;" id="follow" class="glyphicon glyphicon-thumbs-down"></i>&nbsp;Smetti di seguire la pagina</a></p>';
      $('#divFollowPage').html(html);

      var t = $('#totFollowers');
      $('#totFollowers').html('<p style="text-align: center; color: blue; font-size: 20px;"><i style="color: blue;" id="like" class="glyphicon glyphicon-user"></i>&nbsp;' + data.tot_followers + ' persone seguono questa pagina</p>');
    });
  }

  function createTooltipData(data) {
    if (data.length > 0 && data.length <= 4) {
      var toreturn = '<ul>';
      data.forEach(function (el) {
        toreturn += "<li><a href='/profile/user/" + el.id_user + "'>" + el.name + " " + el.surname + "</a></li>";
      });
      toreturn += '</ul>';
      return toreturn;
    }
    else if (data.length > 4) {
      var toreturn = '<ul>';
      for (i = 0; i < 4; i++) {
        toreturn += "<li><a href='/profile/user/" + data[i].id_user + "'>" + data[i].name + " " + data[i].surname + "</a></li>";
      }
      toreturn += "<li>e altri " + (data.length - 3) + "</li>";
      toreturn += '</ul>';
      return toreturn;
    }
    else {
      return "Ancora niente";
    }
  }

  function commentfocus(id) {
    $("#comment_insert_" + id.split("_")[1]).focus();
  }

  function getTimeDelta(time) {
    var now = new Date().getTime();
    if (navigator.userAgent.indexOf("Chrome") !== -1) {
      var time_past = new Date(time);
    }
    else {
      var time_past = new Date(time.replace(/\s+/g, 'T').concat('.000+01:00')).getTime();
    }
    var minutes = Math.floor((now - time_past) / 60000);
    var delta = 0;
    if (minutes == 0) {
      delta = "Adesso";
    }
    else if (minutes < 60) {
      delta = minutes + " minuti fa";
    }
    else if ((minutes >= 60) && (minutes < 86400)) {
      delta = Math.floor((minutes / 60)) + " ore fa";
    }
    else if ((minutes >= 86400) && (minutes < 604800)) {
      delta = Math.floor((minutes / 86400)) + " giorni fa.";
    }
    else if ((minutes >= 604800) && (minutes < 42033600)) {
      delta = Math.floor((minutes / 604800)) + " settimane fa";
    }
    else {
      delta = "Molto tempo fa"
    }
    return (delta);



  }

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  function InvitaAmici(id_page) {
    $.ajax({
      dataType: 'json',
      type: 'POST',
      url: '/page/invite',
      data: { id_page: id_page }
    }).done(function (data) {
      var html = '<i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;' + data.totInviti + ' inviti inviati!';
      $('#spanInviti').html(html);
    });
  }


  function createcomment(comment) {
    $comment_clone = $("#comment_panel").clone();
    $comment_clone.attr("id", "comment_panel_" + comment.id_comment);
    $comment_clone.find("#comm_pic_path").attr('src', + "/" + comment.pic_path);
    if (comment.auth_surname != null) {
      $comment_clone.find("#comment_author").html('&nbsp;&nbsp;' + comment.auth_name + " " + comment.auth_surname);
    }
    else {
      $comment_clone.find("#comment_author").html('&nbsp;&nbsp;' + comment.auth_name);
    }
    $comment_clone.find("#comment_created_at").text(getTimeDelta(comment.created_at));
    $comment_clone.find("#comment_content").text(comment.content);
    //segnalazione
    $comment_clone.find('#reportingComment').attr('data-whatever', comment.id_comment);

    if (comment.userlike == '0') {
      $comment_clone.find("#dislikecomm").css({ 'color': 'red' }).attr('id', 'dislikecomm_' + comment.id_comment);;
      $comment_clone.find("#likecomm").css({ 'color': 'black' }).attr('id', 'likecomm_' + comment.id_comment);
    }
    else if (comment.userlike == '1') {
      $comment_clone.find("#likecomm").css({ 'color': 'blue' }).attr('id', 'likecomm_' + comment.id_comment);
      $comment_clone.find("#dislikecomm").css({ 'color': 'black' }).attr('id', 'dislikecomm_' + comment.id_comment);
    }
    else {
      $comment_clone.find("#likecomm").css({ 'color': 'black' }).attr('id', 'likecomm_' + comment.id_comment);
      $comment_clone.find("#dislikecomm").css({ 'color': 'black' }).attr('id', 'dislikecomm_' + comment.id_comment);
    }
    $comment_clone.find('#likecomm_' + comment.id_comment).data('powertip', createTooltipData(comment.likes));
    $comment_clone.find('#likecomm_' + comment.id_comment).powerTip({
      placement: 's',
      mouseOnToPopup: true
    });
    $comment_clone.find('#dislikecomm_' + comment.id_comment).data('powertip', createTooltipData(comment.dislikes));
    $comment_clone.find('#dislikecomm_' + comment.id_comment).powerTip({
      placement: 's',
      mouseOnToPopup: true
    });
    return ($comment_clone);
  }

  function createPost(data) {
    $post_clone = $("#post").clone();
    $post_clone.attr("id", "post_" + data.id_post);
    $post_clone.find("#input_panel").attr("id", "input_panel_" + data.id_post);
    $post_clone.find("#creation_date").text(getTimeDelta(data.created_at)).attr('href', '/post/details/' + data.id_post);
    $post_clone.find("#comment_insert").attr("id", "comment_insert_" + data.id_post);
    if (data.auth_surname != null) {
      $post_clone.find("#post_u_name").html("&nbsp;&nbsp;" + data.auth_name + " " + data.auth_surname).attr('href', '/profile/user/' + data.id_auth);
    }
    else {
      $post_clone.find("#post_u_name").html("&nbsp;&nbsp;" + data.auth_name);
    }
    $post_clone.find("#post_pic_path").attr('src', "/" + data.pic_path);
    $post_clone.find("#post_content").text(data.content);
    //segnalazione
    $post_clone.find('#reportingPost').attr('data-whatever', data.id_post);
    $post_clone.find('#img_container').attr('href', '/profile/user/' + data.id_auth);
    $post_clone.find("#insert_after").attr('id', "insert_after" + data.id_post);
    //Mostro il numero di like
    $post_clone.find('#like').data('powertip', createTooltipData(data.likes));
    $post_clone.find('#like').powerTip({
      placement: 's',
      mouseOnToPopup: true
    });
    $post_clone.find('#dislike').data('powertip', createTooltipData(data.dislike));
    $post_clone.find('#dislike').powerTip({
      placement: 's',
      mouseOnToPopup: true
    });
    if (data.userlike == '0') {
      $post_clone.find("#dislike").css({ 'color': 'red' }).attr('id', 'dislike_' + data.id_post);;
      $post_clone.find("#like").css({ 'color': 'black' }).attr('id', 'like_' + data.id_post);
    }
    else if (data.userlike == '1') {
      $post_clone.find("#like").css({ 'color': 'blue' }).attr('id', 'like_' + data.id_post);
      $post_clone.find("#dislike").css({ 'color': 'black' }).attr('id', 'dislike_' + data.id_post);
    }
    else {
      $post_clone.find("#like").css({ 'color': 'black' }).attr('id', 'like_' + data.id_post);
      $post_clone.find("#dislike").css({ 'color': 'black' }).attr('id', 'dislike_' + data.id_post);
    }
    $post_clone.find("#comment").attr('id', 'comment_' + data.id_post);

    return ($post_clone);
  }

  function newPost() {
    //manca controllo che il campo non sia vuoto!
    $.ajax({
      method: "POST",
      url: "/page/newpost",
      data: { content: $("#new_post_content").val(), is_fixed: 0, id: location.href.match(/([^\/]*)\/*$/)[1] },
      dataType: "json",
      beforeSend: function (xhr) {
        var token = '{{csrf_token()}}';

        if (token) {
          return xhr.setRequestHeader('X-CSRF-TOKEN', token);
        }
      },
      success: function (data) {
        console.log(data);
        if (data.ban != 1) {
          $("#new_post_content").val('');
          $post_clone = createPost(data)
          $post_clone.insertAfter(".well");
          $post_clone.show();
          $("#comment_panel").hide();
          if (data.comments.length > 0) {
            for (j = 0; j < data.comments.length; j++) {
              $comment_clone = createcomment(data.comments[j]);
              $comment_clone.insertBefore("#comment_insert_" + data.id_comment);
              $comment_clone.show();
            }
          }
        }
        else {
          alert("Non puoi scrivere post, sei bannato!");
        }

      }
    });
  }

  function onLoad(data) {
    $("#post").hide();
    $("#comment_panel").hide();
    //manca controllo che se non c'è nessun post lo scrivo!!

    //ciclo su tutti i post, al contrario perchè prendo dal più recente al più vecchio
    for (var i = data.length - 1; i >= 0; i--) {
      $post_clone = createPost(data[i]);
      $post_clone.insertAfter(".well");
      $post_clone.show();
    }
    data.forEach(function (el) {
      //carico i commenti
      if (el.comments.length > 0 && (el.id_post == el.comments[0].id_post)) {
        for (j = 0; j < el.comments.length; j++) {
          $comment_clone = createcomment(el.comments[j]);
          $comment_clone.insertBefore("#comment_insert_" + el.id_post);
          $comment_clone.show();
        }
      }
    })
  }

  function loadOlder() {
    $prev_post = $("#post").prev();
    $post_id = $prev_post.attr("id").split("_")[1];
    $.ajax({
      method: "GET",
      url: "/home/loadmore",
      data: { post_id: $post_id },
      dataType: "json",
      success: function (posts) {
        if (posts.length != 0) {
          for (var x = posts.length - 1; x >= 0; x--) {
            $post_clone = createPost(posts[x]);
            $post_clone.insertAfter("#post_" + $post_id);
            $post_clone.show();
            $("#comment_panel").hide();

          }
          posts.forEach(function (el) {
            //carico i commenti
            if (el.comments.length > 0 && el.id_post == el.comments[0].id_post) {
              for (j = 0; j < el.comments.length; j++) {
                $comment_clone = createcomment(el.comments[j]);
                $comment_clone.insertBefore("#comment_insert_" + el.id_post);
                $comment_clone.show();
              }
            }
          })
        }
        else {
          $("#load").text("Nothing More!");
        }
      }
    })
  }

  //Caricamento dei post
  $(document).ready(function () {
    $.ajax({
      url: '/page/loadmore',
      method: "GET",
      dataType: "json",
      data: { post_id: -1, id: location.href.match(/([^\/]*)\/*$/)[1] },
      success: function (posts) {
        console.log(posts);
        onLoad(posts);
      }
    });
  });
</script> @endsection