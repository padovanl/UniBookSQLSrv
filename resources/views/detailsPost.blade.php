@extends('layouts.app')

@section('content')
  <!--Pannello Post-->
  <div class="padding pre-scrollable" style="max-height: 800px;">
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
                                      <div class="media-body">
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
                          <hr>
                          <div class="post-footer-option container">
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
                                  <div class="media">
                                      <div class="media-left">
                                          <a href="#">
                                              <img id="comm_pic_path" class="media-object photo-profile"
                                                   src="" width="32" height="32" alt="..."
                                                   style="border-radius: 50%;">
                                          </a>
                                      </div>
                                      <div class="media-body">
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
                              <hr>
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
        @include('reportModal')
    </div>
  </div>
<script>
//Caricamento dei post
$(document).ready(function () {
    $.ajax({
        url: '/home/loadmore',
        method: "GET",
        dataType: "json",
        data: {post_id: -1, id_post: location.href.match(/([^\/]*)\/*$/)[1], details: 1},
        success: function (posts) {
            console.log(posts);
            onLoad(posts, 1);
        }
    });
});
</script>
@endsection
