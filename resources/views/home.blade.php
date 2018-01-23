@extends('layouts.app')

@section('content')
    <article class="content">

        <div class="new_post">
            <div><textarea class="post_text" id="new_post_content" placeholder="Hey, che succede?" type="text"></textarea></div>
            <div class="btn_post"><button onclick="newPost()" class="btn btn-lg btn-primary ">Post</button></div>
        </div>

        <div class="main_posts_list">
            <div class="well" style="display: none;"></div>

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
                                                    <div >
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
                  <button id="load_home" onclick="loadOlder(this.id)" type="button" class="button btn-default btn-load">Carica altri post...</button>
              </div>

        </div>
    </article>


    <div class="side">
        <h5>Amici Suggeriti</h5>
        <hr/>
        <div class="list_possible_friends">
            @foreach($suggested_friends as $suggested)
            <div class="possible_friend">
                <div class="profile_img_possible_friend">
                    <a href="/profile/user/{{$suggested->id_user}}">
                        <img class="img-circle" src="{{$suggested->pic_path}}"  />
                    </a>
                </div>

                <div class="nome_ps_friend">
                     <a href="/profile/user/{{$suggested->id_user}}"><div class="">{{$suggested->name . " " . $suggested->surname}}</div></a>
                </div>


            </div>

            @endforeach
        </div>
    </div>





    @include('reportModal')




<script>
    $('.pre-scrollable').attr('style', 'max-height:' + $(window).height() + 'px;');

    //Caricamento dei post
    $(document).ready(function () {
        $.ajax({
            url: '/home/loadmore',
            method: "GET",
            dataType: "json",
            data: {post_id: -1, home: 1},
            success: function (posts) {
                onLoad(posts);
            },
            error: function(data){
            var errors = data.responseJSON;
            alert("Qualcosa è andato storto! Prova a ricaricare la pagina.\n\nERROR:\n" + errors.message);
          }
        });
    });
</script>
@endsection
