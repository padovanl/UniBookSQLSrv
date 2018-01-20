@extends('layouts.profile_layout')

@section('content')

    <style>
        .w3-teal, .w3-hover-teal:hover {
            color: #fff !important;
            background-color: #4285f4 !important;
        }

        .w3-text-teal, .w3-hover-text-teal:hover {
            color: #4285f4 !important;
        }

        .rowI {
            display: flex;
            flex-wrap: wrap;
            padding: 0 4px;
            width: 100%;
        }

        /* Create four equal columns that sits next to each other */
        .columnI {
            flex: 25%;
            max-width: 100%;
            padding: 0 4px;
            width: 100%;
        }

        .columnI img {
            margin-top: 8px;
            vertical-align: middle;
            width: 20%;

        }
        .avatar-container img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 1px;
            margin-bottom: 14px;
            /*margin: auto;
            right: 50px;*/
        }

        .content {
            max-width: 900px;
        }
    </style>

@switch($case)
    @case(0)
      <!--sono nel mio profilo-->
      <nav class="main-nav">
          <div class="side-sec">
              <!-- Left Column -->
              <div class="avatar-container">
                  <img src="{{$user->pic_path}}" alt="Avatar">
                  <div class="w3-display-bottomleft w3-container w3-text-black">
                      <h2>{{$user -> name . " " . $user -> surname}}</h2>
                  </div>
              </div>
              <!--Add Friend and Message-->
              <div class="w3-container">
                  <p><i class="fa fa-home fa-fw w3-margin-right w3-large w3-text-teal"></i>{{$user -> citta}}</p>
                  <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-teal"></i>{{$user -> email}}</p>
                  <p>
                      <i class="fa fa-birthday-cake fa-fw w3-margin-right w3-large w3-text-teal"></i>{{$user -> birth_date}}
                  </p>
                  <hr>
                  <!--grid images friends-->
                  <p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i>Friends</b></p>
                  <div class="rowI">
                      <div class="columnI">
                          @foreach($friends_array as $array)
                              <a href="/profile/user/{{ $array->id_user }}">
                                  <img src="{{$array->pic_path}}" title="{{$array -> name . " " . $array -> surname}}">
                              </a>
                          @endforeach
                      </div>
                  </div>
                  <br>
                  <!--Settings-->
                  <p class="w3-large w3-text-theme">
                      <b><i class="fa fa-globe fa-fw w3-margin-right w3-text-teal"></i>
                          <a href="/profile/user/<?php echo "$logged_user->id_user" ?>/settings">Settings</a>
                      </b>
                  </p>
                  <br>
              </div>
          </div>

          <!-- End Left Column -->
      </nav>


      <article class="content">

          <div class="new_post">
              <div><textarea class="post_text" id="new_post_content" placeholder="Hey, What's Up?" type="text"></textarea></div>
              <div class="btn_post"><button onclick="newPost()" class="btn btn-lg btn-primary ">Post</button></div>
          </div>
          <div class="main_posts_list">
              <div class="insert_after_me" style="display: none;"></div>

              <!--Pannello Post-->
              <div class="container_post" id="post">

                  <div class="panel panel-default">
                      <div class="panel-body">
                          <section class="post-heading">
                              <div class="post_header">
                                  <div class="">
                                      <div class="media">
                                          <div class="media-left">
                                              <a id="img_container" href="#">
                                                  <img id="post_pic_path" class="media-object photo-profile"
                                                       src="" width="40" height="40" alt="..."
                                                       style="border-radius: 50%;">
                                              </a>
                                          </div>
                                          <div class="">
                                              <a href="#" id="post_u_name" class="anchor-username"><h4
                                                          class="media-heading">User_name</h4></a>
                                              <a href="#" id="creation_date" class="anchor-time">time</a>
                                          </div>
                                      </div>
                                  </div>
                                  <div >
                                      <a id="reportingPost" href="#reportModal" data-toggle="modal" data-whatever="5" style="font-size: 15px;">
                                          <i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;Segnala</a>
                                  </div>

                              </div>
                          </section>


                                  <section class="post-body">
                                      <p id="post_content">content</p>
                                  </section>

                                  <section class="post-footer">
                                      <div class="post-footer-option">
                                          <ul id="option_" class="list-unstyled">
                                              <li><a><i onclick="reaction(this.id)" style="cursor:pointer; " id="like"
                                                        class="glyphicon glyphicon-thumbs-up"></i></a></li>
                                              <li><a><i onclick="reaction(this.id)" style="cursor:pointer;" id="dislike"
                                                        class="glyphicon glyphicon-thumbs-down"></i></a></li>
                                              <li><a><i onclick="commentfocus(this.id)" style="cursor:pointer;"
                                                        id="comment" class="glyphicon glyphicon-comment"></i> Comment</a>
                                              </li>
                                          </ul>
                                      </div>
                                      <div class="post-footer-comment-wrapper">
                                          <div id="comment_panel" class="comment">
                                              <div class="media">
                                                  <div class="media-left">
                                                      <a href="#">
                                                          <img id="comm_pic_path" class="media-object photo-profile"
                                                               src="" width="32" height="32" alt="..."
                                                               style="border-radius: 50%;">
                                                      </a>
                                                  </div>
                                                  <div class="">
                                                      <a href="#" id="comment_author" class="anchor-username"><h4
                                                                  class="media-heading">Media heading</h4></a>
                                                      <a href="#" id="comment_created_at" class="anchor-time">51 mins</a>
                                                      <br>
                                                      <span id="comment_content"></span>
                                                  </div>
                                                  <div class="row">
                                                      <div class="col-md-12">
                                                          <a><i onclick="reaction(this.id)" style="cursor:pointer;"
                                                                id="likecomm"
                                                                class="glyphicon glyphicon-thumbs-up"></i></a>
                                                          <a><i onclick="reaction(this.id)" style="cursor:pointer;"
                                                                id="dislikecomm"
                                                                class="glyphicon glyphicon-thumbs-down"></i></a>
                                                          <a style="cursor: pointer;" id="reportingComment"
                                                             href="#reportComment" data-toggle="modal"
                                                             data-whatever="5"><i
                                                                      class="glyphicon glyphicon-exclamation-sign"
                                                                      aria-hidden="true"></i></a>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>

                                          <div class="comment-form">
                                              <textarea onkeypress="newComment(event, this.id)" id="comment_insert"
                                                        class="form-control form-rounded" placeholder="Add a comment.."
                                                        type="text"></textarea>
                                          </div>
                                      </div>
                                  </section>
                              </div>
                          </div>



                      </div> <!--/Panello post-->

                      <div class="load_altri_post">
                          <button id="load_home" onclick="loadOlder(this.id)" type="button" class="button btn-default">Carica altri post...</button>
                      </div>

                  </div>
      </article>


    @break
    @case(1)
      <!--sono nel profilo di un altro utente non mio amico con profilo privato-->
      <nav class="main-nav">
          <div class="side-sec">
              <!-- Left Column -->
              <div class="avatar-container">
                  <img src="{{$user->pic_path}}" alt="Avatar">
                  <div class="w3-display-bottomleft w3-container w3-text-black">
                      <h2>{{$user -> name . " " . $user -> surname}}</h2>
                  </div>
              </div>
              <!--Add Friend and Message-->
              @if($ban == 1)
                <div class="w3-container">
                  <p>Sei stato BLOCCATO!</p>
                </div>
              @else
                @if($check_friend == 0)
                  <div class="w3-container">
                      <p>
                          <i class="fa fa-user-circle-o fa-fw w3-margin-right w3-large w3-text-teal"></i>
                          <button type="button" onclick='AddFriend(this.value)' value="1" class="submit-btn">Invia Richiesta</button>
                      </p>
                @else
                  <div class="w3-container">
                      <p>
                          <i class="fa fa-user-circle-o fa-fw w3-margin-right w3-large w3-text-teal"></i>
                          <button type="button" onclick='AddFriend(this.value)' value="0" class="submit-btn">Cancella Richiesta</button>
                      </p>
                @endif
              @endif
                  <p><i class="fa fa-comment fa-fw w3-margin-right w3-large w3-text-teal"></i>
                      <button cursor='pointer' data-toggle="modal" data-target="#messageUserModal">Message</button>
                  </p>
                  <br>
              </div>
          </div>
          <br>
          <!-- End Left Column -->
      </nav>
      <article class="content">
          <!-- Right Column -->
          <!-- End Right Column -->
      </article>
    @break
    @case(2)
      <!--sono nel profilo di un altro utente non mio amico con profilo pubblico-->
      <nav class="main-nav">
          <div class="side-sec">
              <!-- Left Column -->
              <div class="w3-display-container">
                  <img src="{{$user->pic_path}}" alt="Avatar">
                  <div class="w3-display-bottomleft w3-container w3-text-black">
                      <h2>{{$user -> name . " " . $user -> surname}}</h2>
                  </div>
              </div>
              <!--Add Friend and Message-->
              @if($ban == 1)
                <div class="w3-container">
                  <p>Sei stato BLOCCATO!</p>
                </div>
                @else
                @if($check_friend == 0)
                  <div class="w3-container">
                      <p><i class="fa fa-user-circle-o fa-fw w3-margin-right w3-large w3-text-teal"></i>
                          <button type="button" onclick='AddFriend(this.value)' value="1" class="submit-btn">Invia Richiesta
                          </button>
                      </p>
                @else
                  <div class="w3-container">
                      <p><i class="fa fa-user-circle-o fa-fw w3-margin-right w3-large w3-text-teal"></i>
                          <button type="button" onclick='AddFriend(this.value)' value="0" class="submit-btn">Cancella Richiesta
                          </button>
                      </p>
                @endif
              @endif
                  <p><i class="fa fa-comment fa-fw w3-margin-right w3-large w3-text-teal"></i>
                      <button cursor='pointer' data-toggle="modal" data-target="#messageUserModal">Message</button>
                  </p>
              <!--se è pubblico vedo le info e posso commentare, se è il proprio profilo vedo tutto-->
                  <p><i class="fa fa-home fa-fw w3-margin-right w3-large w3-text-teal"></i>{{$user -> citta}}</p>
                  <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-teal"></i>{{$user -> email}}</p>
                  <p>
                      <i class="fa fa-birthday-cake fa-fw w3-margin-right w3-large w3-text-teal"></i>{{$user -> birth_date}}
                  </p>
                  <hr>
                  <!--grid images friends-->
                  <p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i>Friends</b></p>
                  <div class="rowI">
                      <div class="columnI">
                          @foreach($friends_array as $array)
                              <a href="/profile/user/{{ $array->id_user }}">
                                  <img src="{{$array->pic_path}}" title="{{$array -> name . " " . $array -> surname}}">
                              </a>
                          @endforeach
                      </div>
                  </div>
                  <br>
              </div>
          </div>
          <br>
          <!-- End Left Column -->
      </nav>
      <article class="content">
          <!-- Right Column -->
          <div class="padding pre-scrollable" style="max-height: 800px;">
              <!-- content -->
              <!-- main col right -->
              <!--Pannello Post-->
              <div class="insert_after_me"></div>
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
                                                          <img id="post_pic_path" class="media-object photo-profile"
                                                               src="" width="40" height="40" alt="..."
                                                               style="border-radius: 50%;">
                                                      </a>
                                                  </div>
                                                  <div class="">
                                                      <a href="#" id="post_u_name" class="anchor-username"><h4
                                                                  class="media-heading">User_name</h4></a>
                                                      <a href="#" id="creation_date" class="anchor-time">time</a>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-md-2">
                                              <a id="reportingPost" href="#reportModal" data-toggle="modal"
                                                 data-whatever="5" style="font-size: 15px;"><i
                                                          class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;Segnala</a>
                                          </div>

                                      </div>
                                  </section>
                                  <section class="post-body">
                                      <p id="post_content">content</p>
                                  </section>

                                  <section class="post-footer">
                                      <div class="post-footer-option container">
                                          <ul id="option_" class="list-unstyled">
                                              <li><a><i onclick="reaction(this.id)" style="cursor:pointer; " id="like"
                                                        class="glyphicon glyphicon-thumbs-up"></i></a></li>
                                              <li><a><i onclick="reaction(this.id)" style="cursor:pointer;" id="dislike"
                                                        class="glyphicon glyphicon-thumbs-down"></i></a></li>
                                              <li><a><i onclick="commentfocus(this.id)" style="cursor:pointer;"
                                                        id="comment" class="glyphicon glyphicon-comment"></i> Comment</a>
                                              </li>
                                          </ul>
                                      </div>
                                      <div class="post-footer-comment-wrapper">
                                          <div id="comment_panel" class="comment">
                                              <div class="media">
                                                  <div class="media-left">
                                                      <a href="#">
                                                          <img id="comm_pic_path" class="media-object photo-profile"
                                                               src="" width="32" height="32" alt="..."
                                                               style="border-radius: 50%;">
                                                      </a>
                                                  </div>
                                                  <div class="">
                                                      <a href="#" id="comment_author" class="anchor-username"><h4
                                                                  class="media-heading">Media heading</h4></a>
                                                      <a href="#" id="comment_created_at" class="anchor-time">51 mins</a>
                                                      <br>
                                                      <span id="comment_content"></span>
                                                  </div>
                                                  <div class="row">
                                                      <div class="col-md-12">
                                                          <a><i onclick="reaction(this.id)" style="cursor:pointer;"
                                                                id="likecomm"
                                                                class="glyphicon glyphicon-thumbs-up"></i></a>
                                                          <a><i onclick="reaction(this.id)" style="cursor:pointer;"
                                                                id="dislikecomm"
                                                                class="glyphicon glyphicon-thumbs-down"></i></a>
                                                          <a style="cursor: pointer;" id="reportingComment"
                                                             href="#reportComment" data-toggle="modal"
                                                             data-whatever="5"><i
                                                                      class="glyphicon glyphicon-exclamation-sign"
                                                                      aria-hidden="true"></i></a>
                                                      </div>
                                                  </div>
                                              </div>
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
                  <button id="load" onclick="loadOlder()" type="button" class="button btn-primary"
                          style="border-radius: 5px;">Carica post più vecchi...
                  </button>
              </div>
          </div>
          <!-- End Right Column -->
      </article>
    @break
    @case(3)
      <!--sono nel profilo di un altro utente mio amico con profilo privato oppure pubblico-->
      <nav class="main-nav">
          <div class="side-sec">
              <!-- Left Column -->
              <div class="avatar-container">
                  <img src="{{$user->pic_path}}"  alt="Avatar">
                  <div class="w3-display-bottomleft w3-container w3-text-black">
                      <h2>{{$user -> name . " " . $user -> surname}}</h2>
                  </div>
              </div>
              <!--Add Friend and Message-->
              @if($ban == 1)
                <div class="w3-container">
                  <p>Sei stato BLOCCATO!</p>
                </div>
              @else
                <div class="w3-container">
                    <p><i class="fa fa-user-circle-o fa-fw w3-margin-right w3-large w3-text-teal"></i>
                        <button type="button" onclick='AddFriend(this.value)' value="0" class="submit-btn">Cancella Amicizia
                        </button>
                    </p>
                    <p><i class="fa fa-comment fa-fw w3-margin-right w3-large w3-text-teal"></i>
                        <button cursor='pointer' data-toggle="modal" data-target="#messageUserModal">Message</button>
                    </p>
              @endif
              <!--se è pubblico vedo le info e posso commentare, se è il proprio profilo vedo tutto-->
                  <p><i class="fa fa-home fa-fw w3-margin-right w3-large w3-text-teal"></i>{{$user -> citta}}</p>
                  <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-teal"></i>{{$user -> email}}</p>
                  <p>
                      <i class="fa fa-birthday-cake fa-fw w3-margin-right w3-large w3-text-teal"></i>{{$user -> birth_date}}
                  </p>
                  <hr>
                  <!--grid images friends-->
                  <p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i>Friends</b></p>
                  <div class="rowI">
                      <div class="columnI">
                          @foreach($friends_array as $array)
                              <a href="/profile/user/{{ $array->id_user }}">
                                  <img src="{{$array->pic_path}}" title="{{$array -> name . " " . $array -> surname}}">
                              </a>
                          @endforeach
                      </div>
                  </div>
                  <br>
              </div>
          </div>
          <br>
          <!-- End Left Column -->
      </nav>
      <article class="content">
          <!-- Right Column -->
          <div class="padding pre-scrollable" style="max-height: 800px;">
              <!-- content -->
              <!-- main col right -->

              <!--Pannello Post-->
              <div class="insert_after_me"></div>
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
                                                          <img id="post_pic_path" class="media-object photo-profile"
                                                               src="" width="40" height="40" alt="..."
                                                               style="border-radius: 50%;">
                                                      </a>
                                                  </div>
                                                  <div class="">
                                                      <a href="#" id="post_u_name" class="anchor-username"><h4
                                                                  class="media-heading">User_name</h4></a>
                                                      <a href="#" id="creation_date" class="anchor-time">time</a>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-md-2">
                                              <a id="reportingPost" href="#reportModal" data-toggle="modal"
                                                 data-whatever="5" style="font-size: 15px;"><i
                                                          class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;Segnala</a>
                                          </div>

                                      </div>
                                  </section>
                                  <section class="post-body">
                                      <p id="post_content">content</p>
                                  </section>

                                  <section class="post-footer">
                                      <div class="post-footer-option container">
                                          <ul id="option_" class="list-unstyled">
                                              <li><a><i onclick="reaction(this.id)" style="cursor:pointer; " id="like"
                                                        class="glyphicon glyphicon-thumbs-up"></i></a></li>
                                              <li><a><i onclick="reaction(this.id)" style="cursor:pointer;" id="dislike"
                                                        class="glyphicon glyphicon-thumbs-down"></i></a></li>
                                              <li><a><i onclick="commentfocus(this.id)" style="cursor:pointer;"
                                                        id="comment" class="glyphicon glyphicon-comment"></i> Comment</a>
                                              </li>
                                          </ul>
                                      </div>
                                      <div class="post-footer-comment-wrapper">
                                          <div id="comment_panel" class="comment">
                                              <div class="media">
                                                  <div class="media-left">
                                                      <a href="#">
                                                          <img id="comm_pic_path" class="media-object photo-profile"
                                                               src="" width="32" height="32" alt="..."
                                                               style="border-radius: 50%;">
                                                      </a>
                                                  </div>
                                                  <div class="">
                                                      <a href="#" id="comment_author" class="anchor-username"><h4
                                                                  class="media-heading">Media heading</h4></a>
                                                      <a href="#" id="comment_created_at" class="anchor-time">51 mins</a>
                                                      <br>
                                                      <span id="comment_content"></span>
                                                  </div>
                                                  <div class="row">
                                                      <div class="col-md-12">
                                                          <a><i onclick="reaction(this.id)" style="cursor:pointer;"
                                                                id="likecomm"
                                                                class="glyphicon glyphicon-thumbs-up"></i></a>
                                                          <a><i onclick="reaction(this.id)" style="cursor:pointer;"
                                                                id="dislikecomm"
                                                                class="glyphicon glyphicon-thumbs-down"></i></a>
                                                          <a style="cursor: pointer;" id="reportingComment"
                                                             href="#reportComment" data-toggle="modal"
                                                             data-whatever="5"><i
                                                                      class="glyphicon glyphicon-exclamation-sign"
                                                                      aria-hidden="true"></i></a>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>

                                          <div class="comment-form">
                                              <textarea onkeypress="newComment(event, this.id)" id="comment_insert"
                                                        class="form-control form-rounded" placeholder="Add a comment.."
                                                        type="text"></textarea>
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
                  <button id="load" onclick="loadOlder()" type="button" class="button btn-primary"
                          style="border-radius: 5px;">Carica post più vecchi...
                  </button>
              </div>
          </div>
          <!-- End Right Column -->
      </article>
    @break
@endswitch
      <!-- Message user modal -->
      <div class="modal fade bd-example-modal-lg" id="messageUserModal" tabindex="-1" role="dialog"
           aria-labelledby="detailModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="titleReportComment">Invia messaggio</h5>
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
                              <button type="button" class="btn btn-primary" data-dismiss="modal" id="bthSendMessageUser"
                                      disabled="true">Invia messaggio
                              </button>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>


    @include('reportModal')

    <script>

        //Caricamento dei post
        var pathArray = window.location.pathname.split('/');
        var profileId = pathArray[3];
        //console.log(profileId);
        $(document).ready(function () {
            console.log(profileId);
            $.ajax({
                url: "/profile/user/" + profileId + "/loadmore",
                //url : '/profile/user/loadmore',
                method: "GET",
                dataType: "json",
                data: {id: profileId, post_id: -1, user: 1},
                success: function (posts) {
                    console.log(posts);
                    onLoad(posts,1);
                }
            });
        });

        $('#messageUserModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            //var recipient = button.data('whatever') // Extract info from data-* attributes
            var post;
        });

        $('#bthSendMessageUser').click(function () {
            var message = $('#messageUser').val();
            var recipient = document.URL.split("/")[5];
            console.log(recipient);
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: '/admin/dashboard/sendMessageUser',
                data: {id_user: recipient, message: message}
            }).done(function (data) {
                $('#messageUser').val('');
                toastr.success(data.body, data.message, {timeOut: 5000});
            });
        });

        $('#messageUser').keyup(function (event) {
            var text = $('#messageUser').val();
            if (text == '') {
                $('#bthSendMessageUser').attr('disabled', true);
            } else {
                $('#bthSendMessageUser').attr('disabled', false);
            }
        });

        $('#messageUserModal').on('hide.bs.modal', function (event) {
            //rimuovo gli eventi una volta che chiudo il modal
            $('#bthSendMessageUser').unbind();
            $('#messageUser').unbind();
        });



        $('.pre-scrollable').attr('style', 'max-height:' + $(window).height() + 'px;');




        function AddFriend(data){
                            var id = document.URL.split("/")[5];
                            console.log(id);
                            console.log(data);
                            $.ajax({
                               method: "POST",
                               url: "/friend/AddFriend",
                               data: {id:id,data:data},
                               dataType: "json",
                               success: function(data) {
                                 console.log(data.value);
                                 if(data.value == 1){
                                   $(".submit-btn").html("Cancella Richiesta");
                                   $(".valore").val(0);
                                   console.log('Inviata richiesta');
                                 }
                                 else{
                                   $(".submit-btn").html("Invia Richiesta");
                                   $(".valore").val(1);
                                   console.log('Cancellata richiesta/amicizia');
                                 }
                               }
                             });
                            }
    </script>
@endsection
