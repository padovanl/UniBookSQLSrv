@extends('layouts.profile_layout')
@section('content')
    <nav class="main-nav">
        <div class="side-sec">
            <!-- Left Column -->
            <div class="avatar-container">
                <img src="{{$page->pic_path}}" alt="Avatar">
                <div class="w3-display-bottomleft w3-container w3-text-black">
                    <h2>{{$page -> name}}</h2>
                </div>
            </div>

            <div class="w3-container">
                <br/>
                <div id="divFollowPage">
                    <div id="piace_ono">
                    @if($alreadyFollow)
                        <p id="stopFollowP">
                            <a onclick="stopFollow('{{$page->id_page}}', '{{$logged_user->id_user}}')">
                                <i id="follow" class="glyphicon glyphicon-thumbs-down"></i>&nbsp;Smetti di seguire
                            </a>
                        </p>
                    @else
                        <p id="followP">
                            <a style="" onclick="follow('{{$page->id_page}}', '{{$logged_user->id_user}}')"><i id="follow" class="glyphicon glyphicon-thumbs-up"></i>&nbsp;Segui</a>
                        </p>
                    @endif
                    </div>
                    <br/>
                    <div id="totFollowers">
                        <p>Seguita da&nbsp;<span id="num_followers">{{$tot_followers}}</span>&nbsp;persone</p>
                    </div>
                </div>
                <hr>
                @if($logged_user->id_user == $page->id_user)
                    <p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i>Opzioni</b></p>
                    <p class="msg_amici">Invita i tuoi amici a mettere mi piace!</p>
                    <div style="text-align: center;">
                        <button type="button" class="btn btn-primary" style="display: block; margin: 0 auto;" onclick="InvitaAmici({{$page->id_page}});">Invita</button>
                        <br/>
                        <span id="spanInviti"></span>
                    </div>
                    <br/>
                    <div style="text-align: center;">
                        <button type="button" class="btn btn-secondary" style="display: block; margin: 0 auto;"
                                data-toggle="modal" data-target="#changeImageModal">Modifica immagine
                        </button>
                        <br/>
                    </div>
                    <br>
                @endif
            </div>
        </div>
        <br>
        <!-- End Left Column -->
    </nav>

  <article class="content">
      @if ($logged_user->id_user == $page->id_user)
          <div class="new_post">
              <div><textarea class="post_text" id="new_post_content" placeholder="Hey, che succede?" type="text"></textarea></div>
              <div class="btn_post"><button onclick="newPost()" class="btn btn-lg btn-primary ">Post</button></div>
          </div>
      @endif
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
              <button id="load_page" onclick="loadOlder(this.id)" type="button" class="button btn-default btn-load">Carica altri post...</button>
          </div>

          </div>
  </article>


    <!-- change image modal -->
    <form action="{{ route('changeImage') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal fade bd-example-modal-lg" id="changeImageModal" tabindex="-1" role="dialog"
             aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="titleReportComment">Cambia immagine della pagina</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="profilePic" class="col-sm-5 col-form-label">Immagine della pagina:</label>
                            <div class="image-upload">
                                <label for="image">
                                    <img src="{{$page->pic_path}}" id="profilePic" width="250px" height="250px"/>
                                </label>

                                <input name="image" id="image" type="file" onchange="readURL(this);"/>
                                <input type="hidden" name="id_page" id="id_page" value="{{$page->id_page}}">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div>
                            <div class="modal_buttons">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                                <button type="submit" class="btn btn-primary" id="btnChange" disabled>Cambia</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @include('reportModal')
    <style type="text/css">
        .w3-teal,
        .w3-hover-teal:hover {
            color: #fff !important;
            background-color: #4285f4 !important;
        }

        .w3-text-teal,
        .w3-hover-text-teal:hover {
            color: #4285f4 !important;
        }
        .image-upload > input {
            display: none;
        }

        img:hover {
            cursor: pointer;
        }
    </style>
    <script>
        var options = {
            complete: function (response) {
                window.location.href = response.redirect;
            }
        };

        $("body").on("click", "#btnChange", function (e) {
            $(this).parents("form").ajaxForm(options);
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {
            $.ajax({
                url: '/home/loadmore',
                method: "GET",
                dataType: "json",
                data: {post_id: -1, id: location.href.match(/([^\/]*)\/*$/)[1], page: 1},
                success: function (posts) {
                    console.log(posts);
                    onLoad(posts, 1);
                },
                error: function(data){
                var errors = data.responseJSON;
                alert("Qualcosa è andato storto! Prova a ricaricare la pagina.\n" + errors.message);
              }
            });
        });
    </script>

@endsection
