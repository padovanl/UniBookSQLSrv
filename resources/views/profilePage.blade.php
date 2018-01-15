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
          <img src="/{{$page->pic_path}}" style="width:100%" alt="Avatar">
          <div class="w3-display-bottomleft w3-container w3-text-black">
            <h2>{{$page -> name}}</h2>
          </div>
        </div>
        <div class="w3-container">
          <br />
          <div id="divFollowPage">
            @if($alreadyFollow)
              <p id="stopFollowP" style="text-align: center; color: red;"><a style="cursor: pointer; font-size: 20px;" onclick="stopFollow({{$page->id_page}}, '{{$logged_user->id_user}}')"><i style="cursor:pointer; color: red;" id="follow" class="glyphicon glyphicon-thumbs-down"></i>&nbsp;Smetti di seguire la pagina</a></p>
            @else
              <p id="followP" style="text-align: center; color: blue;"><a style="cursor: pointer; font-size: 20px;" onclick="follow({{$page->id_page}}, '{{$logged_user->id_user}}')"><i style="cursor:pointer; color: blue;" id="follow" class="glyphicon glyphicon-thumbs-up"></i>&nbsp;Segui</a></p>
            @endif
            <br />
             <p id="totFollowers" style="text-align: center; color: blue; font-size: 20px;"><i style="color: blue;" id="like" class="glyphicon glyphicon-user"></i>&nbsp;{{$tot_followers}}&nbsp;persone seguono questa pagina</p>
          </div>
          <!--<p><i class="fa fa-phone fa-fw w3-margin-right w3-large w3-text-teal"></i>1224435534</p> -->
          <hr>
          @if($logged_user->id_user == $page->id_user)
            <p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i>Opzioni</b></p>
            <p>Invita i tuoi amici a mettere mi piace alla tua pagina!</p>
            <div>
              <button type="button" class="btn btn-primary" style="display: block; margin: 0 auto;">Invita</button>
            </div>
            <br>
            @endif
        </div>
      </div><br>

    <!-- End Left Column -->
    </div>

    <!-- Right Column -->
    <div class="padding pre-scrollable" style="max-height: 800px;">
            <!-- content -->
                <!-- main col right -->
                <?php if ($logged_user->id_user == $page->id_user): ?>
                    <div class="well">
                        <div>
                            <h4>New Post</h4>
                            <div class="form-group text-center"> <!--se non vi piace mettete quello di prima: input-group-->
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
    <!-- End Right Column -->
    </div>

  <!-- End Grid -->
  </div>

  <!-- End Page Container -->
</div>
<script>

</script>

<script>
$('.pre-scrollable').attr('style', 'max-height:' + $(window).height() + 'px;');
</script>

<script>
  function stopFollow(id_page, id_user){
    $.ajax({
      dataType: 'json',
      type: 'POST',
      url: '/profile/page/stopFollow',
      data: { id_page: id_page, id_user:id_user }
    }).done(function (data) {
      $('#stopFollowP').remove();
      var html = '<p id="followP" style="text-align: center; color: blue;"><a style="cursor: pointer; font-size: 20px;" onclick="follow({{$page->id_page}}, \'{{$logged_user->id_user}}\')"><i style="cursor:pointer; color: blue;" id="follow" class="glyphicon glyphicon-thumbs-up"></i>&nbsp;Segui</a></p>';
      $('#divFollowPage').html(html);
      var t = $('#totFollowers');
      $('#totFollowers').html('<i style="color: blue;" id="like" class="glyphicon glyphicon-user"></i>&nbsp;' + data.tot_followers + ' persone seguono questa pagina');
    });              
  }

  function follow(id_page, id_user){
    $.ajax({
      dataType: 'json',
      type: 'POST',
      url: '/profile/page/follow',
      data: { id_page: id_page, id_user:id_user }
    }).done(function (data) {
      $('#followP').remove();
      var html = ' <p id="stopFollowP" style="text-align: center; color: red;"><a style="cursor: pointer; font-size: 20px;" onclick="stopFollow({{$page->id_page}}, \'{{$logged_user->id_user}}\')"><i style="cursor:pointer; color: red;" id="follow" class="glyphicon glyphicon-thumbs-down"></i>&nbsp;Smetti di seguire la pagina</a></p>';
      $('#divFollowPage').html(html);
      var t = $('#totFollowers');
      $('#totFollowers').html('<i style="color: blue;" id="like" class="glyphicon glyphicon-user"></i>&nbsp;' + data.tot_followers + ' persone seguono questa pagina');
    });              
  }

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

</script>

@endsection
