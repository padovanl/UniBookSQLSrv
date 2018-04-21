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
                @if($user->admin)
                 <p><i class="fa fa-star fa-fw w3-margin-right w3-large w3-text-teal"></i>Admin</p>
                @endif
                  <p><i class="fa fa-home fa-fw w3-margin-right w3-large w3-text-teal"></i>{{$user -> citta}}</p>
                  <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-teal"></i>{{$user -> email}}</p>
                  <p>
                      <i class="fa fa-birthday-cake fa-fw w3-margin-right w3-large w3-text-teal"></i>{{$user -> birth_date}}
                  </p>
                  <hr>
                  <!--grid images friends-->
                  <p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i>Amici</b></p>
                  <div class="rowI">
                      <div class="columnI">
                          @foreach($friends_array as $array)
                              <a href="/profile/user/{{ $array->id_user }}">
                                  <img class="img_friends" src="{{$array->pic_path}}" title="{{$array -> name . " " . $array -> surname}}">
                              </a>
                          @endforeach
                      </div>
                  </div>
                  <br>
                  <!--Settings-->
                  <p class="w3-large w3-text-theme">
                      <b><i class="fa fa-globe fa-fw w3-margin-right w3-text-teal"></i>
                          <a href="/profile/user/<?php echo "$logged_user->id_user" ?>/settings">Impostazioni</a>
                      </b>
                  </p>
                  <br>
              </div>
          </div>

          <!-- End Left Column -->
      </nav>


      <article class="content">

          <div class="new_post">
              <div><textarea class="post_text" id="new_post_content" placeholder="Hey, che succede?" type="text"></textarea></div>
              <div class="btn_post"><button onclick="newPost()" class="btn btn-lg btn-primary ">Post</button></div>
          </div>
          <div class="main_posts_list">
              <div class="well" style="display: none;"></div>
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
                                      <li>
                                          <a>
                                              <i onclick="reaction(this.id)" style="cursor:pointer;" id="like"
                                                 class="dropbtn glyphicon glyphicon-thumbs-up"></i>
                                          </a>
                                      </li>
                                      <li><a><i onclick="reaction(this.id)" style="cursor:pointer;" id="dislike"
                                                class="glyphicon glyphicon-thumbs-down"></i></a></li>
                                      <li><a><i onclick="commentfocus(this.id)" style="cursor:pointer;"
                                                id="comment" class="glyphicon glyphicon-comment"></i> Comment</a>
                                      </li>
                                  </ul>
                              </div>
                              <div class="post-footer-comment-wrapper">
                                  <div id="comment_panel" class="comment">
                                      <div class="cooment_media">
                                          <div class="cooment_media_left">

                                              <div class="media-left">
                                                  <a href="#">
                                                      <img id="comm_pic_path" class="media-object photo-profile"
                                                           src="" width="32" height="32" alt="..."
                                                           style="border-radius: 50%;">
                                                  </a>
                                              </div>
                                              <div class="comment_div">
                                                  <a href="#" id="comment_author" class="anchor-username"><h4
                                                              class="media-heading">Media heading</h4></a>
                                                  <a href="#" id="comment_created_at" class="anchor-time">51 mins</a>
                                                  <br>
                                                  <span id="comment_content"></span>
                                              </div>
                                          </div>
                                          <div>
                                              <div class="comment_options">
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
                                                          class="form-control form-rounded comment_text" placeholder="Aggiungi un commento.."
                                                          type="text"></textarea>
                                  </div>
                              </div>
                          </section>
                              </div>
                          </div>



                      </div> <!--/Panello post-->

                      <div class="load_altri_post">
                          <button id="load_profile" onclick="loadOlder(this.id)" type="button" class="button btn-default btn-load">Carica altri post...</button>
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
                      <p>
                          <button type="button" onclick='AddFriend(this.value)' value="1" class="submit-btn valore btn btn-round color-1 material-design">Invia Richiesta</button>
                      </p>
                @else
                      <p>
                          <button type="button" onclick='AddFriend(this.value)' value="0" class="submit-btn valore btn btn-round color-1 material-design">Cancella Richiesta</button>
                      </p>
                @endif
              @endif
                  <p>
                      <button class="btn btn-border btn-round color-1 material-design" cursor='pointer' data-toggle="modal" data-target="#messageUserModal">Invia messaggio</button>
                  </p>
                  <br>
              </div>
          </div>
          <br>
      </nav>
      <article class="content">
        <div class="page_alert" role="alert" style="margin: 10px 10px; padding: 5px 5px;">
          <strong>Questo utente ha impostato la privacy su Privato. Invia una richiesta di amicizia per poter vedere i suoi post.</strong>
        </div>
      </article>
    @break
    @case(2)
      <!--sono nel profilo di un altro utente non mio amico con profilo pubblico-->
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
                  <p>
                      <button type="button" onclick='AddFriend(this.value)' value="1" class="submit-btn valore btn btn-round color-1 material-design">Invia Richiesta</button>
                  </p>
                  @else
                      <p>
                          <button type="button" onclick='AddFriend(this.value)' value="0" class="submit-btn valore btn btn-round color-1 material-design">Cancella Richiesta</button>
                      </p>
                      @endif
              @endif
                      <p>
                          <button class="btn btn-border btn-round color-1 material-design" cursor='pointer' data-toggle="modal" data-target="#messageUserModal">Invia messaggio</button>
                      </p>
              <!--se è pubblico vedo le info e posso commentare, se è il proprio profilo vedo tutto-->
                  @if($user->admin)
                   <p><i class="fa fa-star fa-fw w3-margin-right w3-large w3-text-teal"></i>Admin</p>
                  @endif
                  <p><i class="fa fa-home fa-fw w3-margin-right w3-large w3-text-teal"></i>{{$user -> citta}}</p>
                  <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-teal"></i>{{$user -> email}}</p>
                  <p>
                      <i class="fa fa-birthday-cake fa-fw w3-margin-right w3-large w3-text-teal"></i>{{$user -> birth_date}}
                  </p>
                  <hr>
                  <!--grid images friends-->
                  <p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i>Amici</b></p>
                  <div class="rowI">
                      <div class="columnI">
                          @foreach($friends_array as $array)
                              <a href="/profile/user/{{ $array->id_user }}">
                                  <img class="img_friends" src="{{$array->pic_path}}" title="{{$array -> name . " " . $array -> surname}}">
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
                                    <li>
                                        <a>
                                            <i onclick="reaction(this.id)" style="cursor:pointer;" id="like"
                                               class="dropbtn glyphicon glyphicon-thumbs-up"></i>
                                        </a>
                                    </li>
                                    <li><a><i onclick="reaction(this.id)" style="cursor:pointer;" id="dislike"
                                              class="glyphicon glyphicon-thumbs-down"></i></a></li>
                                    <li><a><i onclick="commentfocus(this.id)" style="cursor:pointer;"
                                              id="comment" class="glyphicon glyphicon-comment"></i> Comment</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="post-footer-comment-wrapper">
                                <div id="comment_panel" class="comment">
                                    <div class="cooment_media">
                                        <div class="cooment_media_left">

                                            <div class="media-left">
                                                <a href="#">
                                                    <img id="comm_pic_path" class="media-object photo-profile"
                                                         src="" width="32" height="32" alt="..."
                                                         style="border-radius: 50%;">
                                                </a>
                                            </div>
                                            <div class="comment_div">
                                                <a href="#" id="comment_author" class="anchor-username"><h4
                                                            class="media-heading">Media heading</h4></a>
                                                <a href="#" id="comment_created_at" class="anchor-time">51 mins</a>
                                                <br>
                                                <span id="comment_content"></span>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="comment_options">
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
                                                          class="form-control form-rounded comment_text" placeholder="Aggiungi commento.."
                                                          type="text"></textarea>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>



            </div> <!--/Panello post-->

            <div class="load_altri_post">
                <button id="load_profile" onclick="loadOlder(this.id)" type="button" class="button btn-default btn-load">Carica altri post...</button>
            </div>

        </div>
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
                  <p>
                      <button type="button" onclick='AddFriend(this.value)' value="0" class="submit-btn valore btn btn-round color-1 material-design">Cancella amicizia</button>
                  </p>
                  <p>
                      <button class="btn btn-border btn-round color-1 material-design" cursor='pointer' data-toggle="modal" data-target="#messageUserModal">Invia messaggio</button>
                  </p>
              @endif
              <!--se è pubblico vedo le info e posso commentare, se è il proprio profilo vedo tutto-->
                @if($user->admin)
                 <p><i class="fa fa-star fa-fw w3-margin-right w3-large w3-text-teal"></i>Admin</p>
                @endif
                  <p><i class="fa fa-home fa-fw w3-margin-right w3-large w3-text-teal"></i>{{$user -> citta}}</p>
                  <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-teal"></i>{{$user -> email}}</p>
                  <p>
                      <i class="fa fa-birthday-cake fa-fw w3-margin-right w3-large w3-text-teal"></i>{{$user -> birth_date}}
                  </p>
                  <hr>
                  <!--grid images friends-->
                  <p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i>Amici</b></p>
                  <div class="rowI">
                      <div class="columnI">
                          @foreach($friends_array as $array)
                              <a href="/profile/user/{{ $array->id_user }}">
                                  <img class="img_friends" src="{{$array->pic_path}}" title="{{$array -> name . " " . $array -> surname}}">
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

          <div class="main_posts_list" style="height: 88vh">
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
                                      <li>
                                          <a>
                                              <i onclick="reaction(this.id)" style="cursor:pointer;" id="like"
                                                 class="dropbtn glyphicon glyphicon-thumbs-up"></i>
                                          </a>
                                      </li>
                                      <li><a><i onclick="reaction(this.id)" style="cursor:pointer;" id="dislike"
                                                class="glyphicon glyphicon-thumbs-down"></i></a></li>
                                      <li><a><i onclick="commentfocus(this.id)" style="cursor:pointer;"
                                                id="comment" class="glyphicon glyphicon-comment"></i> Comment</a>
                                      </li>
                                  </ul>
                              </div>
                              <div class="post-footer-comment-wrapper">
                                  <div id="comment_panel" class="comment">
                                      <div class="cooment_media">
                                          <div class="cooment_media_left">

                                              <div class="media-left">
                                                  <a href="#">
                                                      <img id="comm_pic_path" class="media-object photo-profile"
                                                           src="" width="32" height="32" alt="..."
                                                           style="border-radius: 50%;">
                                                  </a>
                                              </div>
                                              <div class="comment_div">
                                                  <a href="#" id="comment_author" class="anchor-username"><h4
                                                              class="media-heading">Media heading</h4></a>
                                                  <a href="#" id="comment_created_at" class="anchor-time">51 mins</a>
                                                  <br>
                                                  <span id="comment_content"></span>
                                              </div>
                                          </div>
                                          <div>
                                              <div class="comment_options">
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
                                                            class="form-control form-rounded comment_text" placeholder="Aggiungi un commento.."
                                                            type="text"></textarea>
                                  </div>
                              </div>
                          </section>
                      </div>
                  </div>



              </div> <!--/Panello post-->

              <div class="load_altri_post">
                  <button id="load_profile" onclick="loadOlder(this.id)" type="button" class="button btn-default btn-load">Carica altri post...</button>
              </div>

          </div>
      </article>
    @break
@endswitch
      <!-- Message user modal -->
      <div class="modal fade bd-example-modal-lg" id="messageUserModal" tabindex="-1" role="dialog"
           aria-labelledby="detailModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h3 class="modal-title" id="titleReportComment">Invia messaggio</h3>
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
                            $.ajaxSetup({
                                      headers: {
                                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                      }
                                  });
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
