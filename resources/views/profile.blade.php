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

        }
    </style>

    <nav class="main-nav">
        <div class="side-sec">
            <!-- Left Column -->
            <div class="w3-display-container">
                <img src="{{$user->pic_path}}" style="width:100%" alt="Avatar">
                <div class="w3-display-bottomleft w3-container w3-text-black">
                    <h2>{{$user -> name . " " . $user -> surname}}</h2>
                </div>
            </div>
            <!--Add Friend and Message-->
            <div class="w3-container">
                <?php if ($logged_user->id_user != $user->id_user): ?>
                <p><i class="fa fa-user-circle-o fa-fw w3-margin-right w3-large w3-text-teal"></i>
                    <button type="button" onclick='Addfriend(this.value)' value="1" class="submit-btn">Add Friend
                    </button>
                </p>
                <p><i class="fa fa-comment fa-fw w3-margin-right w3-large w3-text-teal"></i>
                    <button cursor='pointer' data-toggle="modal" data-target="#messageUserModal">Message</button>
                </p>
            <?php endif; ?>
            <?php if (($logged_user->id_user != $user->id_user && $user->profiloPubblico == 1) || ($logged_user->id_user == $user->id_user)): ?>
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
                <!--Settings-->
                <p class="w3-large w3-text-theme">

                    <?php if ($logged_user->id_user == $user->id_user): ?>
                    <b><i class="fa fa-globe fa-fw w3-margin-right w3-text-teal"></i>
                        <a href="/profile/user/<?php echo "$logged_user->id_user" ?>/settings">Settings</a>
                    </b>
                    <?php endif; ?>
                </p>
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
            <div class="well">
                <?php if ($logged_user->id_user == $user->id_user): ?>
                <div>
                    <h4>New Post</h4>
                    <div class="form-group text-center"> <!--se non vi piace mettete quello di prima: input-group-->
                        <textarea class="form-control input-lg" id="new_post_content" placeholder="Hey, What's Up?"
                                  type="text"></textarea>
                        <button onclick="newPost()" class="btn btn-lg btn-primary">Post</button>
                    </div>
                </div>
                <?php endif; ?>
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

        </div><!-- /padding -->

        <div class="row">
            <div class="col-md-12" style="text-align:center;">
                <button id="load_profile" onclick="loadOlder(this.id)" type="button" class="button btn-primary"
                        style="border-radius: 5px;">Carica post più vecchi...
                </button>
            </div>
        </div>
        <!-- End Right Column -->
    </article>
    <!-- Message user modal -->
    <div class="modal fade bd-example-modal-lg" id="messageUserModal" tabindex="-1" role="dialog"
         aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleReportComment">Nuovo messaggio</h5>
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
    <?php endif; ?>



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
                    onLoad(posts);
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

        $('#reportModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            $('#btnReportPost').click(function () {
                var motivo = $('#reasonReportPost').find(":selected").text();
                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: '/home/reportPost',
                    data: {id_post: recipient, motivo: motivo}
                }).done(function (data) {
                    var html = '<h3>La segnalazione è stata inviata con successo agli amministratori di UniBook, grazie per la tua collaborazione!</h3>';
                    $('#modal-body-post').html(html);
                    $('#btnReportPost').hide();
                });
            });


            var modal = $(this);
            modal.find('.modal-title').text('Segnala post');
        });

        $('#reportModal').on('hidden.bs.modal', function (event) {
            //rimuovo gli eventi una volta che chiudo il modal
            $('#btnReportPost').unbind();
            $('#btnReportPost').show();
            var html = '<div class="form-group">';
            html += ' <label for="reasonReportPost">Selezione il motivo della segnalazione:</label>';
            html += ' <select class="form-control" id="reasonReportPost">';
            html += '   <option selected>Incita all\'odio</option>';
            html += '   <option>È una minaccia</option>';
            html += '   <option>È una notizia falsa</option>';
            html += ' </select>';
            html += '</div>';
            $('#modal-body-post').html(html);
        });

        $('#reportComment').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            $('#btnReportComment').click(function () {
                var motivo = $('#reasonReportComment').find(":selected").text();
                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: '/home/reportComment',
                    data: {id_comment: recipient, motivo: motivo}
                }).done(function (data) {
                    var html = '<h3>La segnalazione è stata inviata con successo agli amministratori di UniBook, grazie per la tua collaborazione!</h3>';
                    $('#modal-body-comment').html(html);
                    $('#btnReportComment').hide();
                });
            });


            var modal = $(this);
            modal.find('.modal-title').text('Segnala commento');
        });

        $('#reportComment').on('hidden.bs.modal', function (event) {
            //rimuovo gli eventi una volta che chiudo il modal
            $('#btnReportComment').unbind();
            $('#btnReportComment').show();
            var html = '<div class="form-group">';
            html += ' <label for="reasonReportComment">Selezione il motivo della segnalazione:</label>';
            html += ' <select class="form-control" id="reasonReportComment">';
            html += '   <option selected>Incita all\'odio</option>';
            html += '   <option>È una minaccia</option>';
            html += '   <option>È una notizia falsa</option>';
            html += ' </select>';
            html += '</div>';
            $('#modal-body-comment').html(html);
        });

        $('.pre-scrollable').attr('style', 'max-height:' + $(window).height() + 'px;');


    </script>
@endsection
