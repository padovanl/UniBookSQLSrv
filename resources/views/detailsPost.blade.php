@extends('layouts.app')

@section('content')
	<div class="container-full">
		<div class="row">
			<div class="col-md-12">
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
																					<img id="post_pic_path" class="media-object photo-profile" src="/{{$post->pic_path}}" width="40" height="40" alt="..." style="border-radius: 50%;">
																				</a>
																			</div>
																			<div class="media-body">
																				<a href="#" id="post_u_name" class="anchor-username"><h4 class="media-heading">{{$post->auth_name . " " . $post->auth_surname}}</h4></a>
																				<a href="#" id="creation_date_{{$post->id_post}}" class="anchor-time">{{$post->created_at}}</a>
																			</div>
																		</div>
																</div>
																<div class="col-md-2">
																	<a id="reportingPost" href="#reportModal" data-toggle="modal" data-whatever="5" style="font-size: 15px;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;Segnala</a>
																</div>

														</div>
											 </section>
											 <section class="post-body">
													 <p id="post_content">{{$post->content}}</p>
											 </section>
											 <section class="post-footer">
													 <hr>
													 <div class="post-footer-option container">
																<ul id="option_" class="list-unstyled">
																		<li><a><i onclick="reaction(this.id)" style="cursor:pointer; @if(($post->userlike === 1)) color:blue; @endif " id="like_{{$post->id_post}}" class="glyphicon glyphicon-thumbs-up"></i></a></li>
																		<li><a><i onclick="reaction(this.id)" style="cursor:pointer; @if($post->userlike === 0) color:red; @endif " id="dislike_{{$post->id_post}}" class="glyphicon glyphicon-thumbs-down"></i></a></li>
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
														 @foreach($post->comments as $comment)
															 <div id="comment_panel_{{$comment->id_comment}}" class="comment">
																		<div class="media">
																			<div class="media-left">
																				<a href="/profile/user/{{$comment->id_author}}">
																					<img id="comm_pic_path" src="/{{$comment->pic_path}}" class="media-object photo-profile" src="" width="32" height="32" alt="..." style="border-radius: 50%;">
																				</a>
																			</div>
																			<div class="media-body">
																				<a href="#" id="comment_author" class="anchor-username"><h4 class="media-heading">{{ $comment->auth_name . " " . $comment->auth_surname}}</h4></a>
																				<a href="#" id="comment_created_at" class="anchor-time">{{ $comment->created_at }}</a>
																				<br>
																				<span id="comment_content">{{ $comment->content }}</span>
																			</div>
																			<div class="row">
																				<div class="col-md-12">
																					<a><i onclick="reaction(this.id)" style="cursor:pointer; @if($comment->userlike === 1) color:blue; @endif " id="likecomm_{{ $comment->id_comment }}"  class="glyphicon glyphicon-thumbs-up"></i></a>
																					<a><i onclick="reaction(this.id)" style="cursor:pointer; @if($comment->userlike === 0) color:red; @endif " id="dislikecomm_{{ $comment->id_comment }}" class="glyphicon glyphicon-thumbs-down"></i></a>
																					<a style="cursor: pointer;" id="reportingComment" href="#reportComment" data-toggle="modal" data-whatever="5"><i class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></i></a>
																			</div>
																			</div>
																		</div>
															 </div>
														 @endforeach
															 <hr>
															 <div class="comment-form">
																 <textarea onkeypress="newComment(event, this.id)" id="comment_insert_{{ $post->id_post }}" class="form-control form-rounded" placeholder="Add a comment.." type="text"></textarea>
															 </div>
													 </div>
											 </section>
										</div>
								</div>
					</div>
					</div>

				</div>

			</div>
		</div>
	</div>

	<script>

	function getTimeDelta(time){
	  var now = new Date().getTime();
	  if (navigator.userAgent.indexOf("Chrome") !== -1){
	    var time_past = new Date(time);
	  }
	  else {
	    var time_past = new Date(time.replace(/\s+/g, 'T').concat('.000+01:00')).getTime();
	  }
	  var minutes = Math.floor((now - time_past) / 60000);
	  var delta = 0;
	  if(minutes == 0){
	    delta = "Adesso";
	  }
	  else if(minutes < 60) {
	    delta = minutes + " minuti fa";
	  }
	  else if((minutes >= 60) && (minutes < 86400)) {
	    delta = Math.floor((minutes / 60)) + " ore fa";
	  }
	  else if((minutes >= 86400) && (minutes < 604800)){
	    delta = Math.floor((minutes / 86400)) + " giorni fa.";
	  }
	  else if((minutes >= 604800) && (minutes < 42033600)){
	    delta = Math.floor((minutes / 604800)) + " settimane fa";
	  }
	  else{
	    delta = "Molto tempo fa"
	  }
	  return(delta);
	}

	function commentfocus(id){
			$("#comment_insert_" + id.split("_")[1]).focus();
	}

		$('#reportModal').on('show.bs.modal', function (event) {
	    var button = $(event.relatedTarget) // Button that triggered the modal
	    var recipient = button.data('whatever') // Extract info from data-* attributes
	    $('#btnReportPost').click(function(){
	      var motivo = $('#reasonReportPost').find(":selected").text();
	      $.ajax({
	        dataType: 'json',
	        type: 'POST',
	        url: '/home/reportPost',
	        data: { id_post: recipient, motivo: motivo }
	      }).done(function (data) {
	        var html = '<h3>La segnalazione è stata inviata con successo agli amministratori di UniBook, grazie per la tua collaborazione!</h3>';
	        $('#modal-body-post').html(html);
	        $('#btnReportPost').hide();
	      });
	    });


	    var modal = $(this);
	    modal.find('.modal-title').text('Segnala post');
	  });

	  $('#reportModal').on('hidden.bs.modal', function(event){
	    //rimuovo gli eventi una volta che chiudo il modal
	    $('#btnReportPost').unbind();
	    $('#btnReportPost').show();
	    var html =  '<div class="form-group">';
	    html +=     ' <label for="reasonReportPost">Selezione il motivo della segnalazione:</label>';
	    html +=     ' <select class="form-control" id="reasonReportPost">';
	    html +=     '   <option selected>Incita all\'odio</option>';
	    html +=     '   <option>È una minaccia</option>';
	    html +=     '   <option>È una notizia falsa</option>';
	    html +=     ' </select>';
	    html +=     '</div>';
	    $('#modal-body-post').html(html);
	  });

	  $('#reportComment').on('show.bs.modal', function (event) {
	    var button = $(event.relatedTarget) // Button that triggered the modal
	    var recipient = button.data('whatever') // Extract info from data-* attributes
	    $('#btnReportComment').click(function(){
	      var motivo = $('#reasonReportComment').find(":selected").text();
	      $.ajax({
	        dataType: 'json',
	        type: 'POST',
	        url: '/home/reportComment',
	        data: { id_comment: recipient, motivo: motivo }
	      }).done(function (data) {
	        var html = '<h3>La segnalazione è stata inviata con successo agli amministratori di UniBook, grazie per la tua collaborazione!</h3>';
	        $('#modal-body-comment').html(html);
	        $('#btnReportComment').hide();
	      });
	    });


	    var modal = $(this);
	    modal.find('.modal-title').text('Segnala commento');
	  });

	  $('#reportComment').on('hidden.bs.modal', function(event){
	    //rimuovo gli eventi una volta che chiudo il modal
	    $('#btnReportComment').unbind();
	    $('#btnReportComment').show();
	    var html =  '<div class="form-group">';
	    html +=     ' <label for="reasonReportComment">Selezione il motivo della segnalazione:</label>';
	    html +=     ' <select class="form-control" id="reasonReportComment">';
	    html +=     '   <option selected>Incita all\'odio</option>';
	    html +=     '   <option>È una minaccia</option>';
	    html +=     '   <option>È una notizia falsa</option>';
	    html +=     ' </select>';
	    html +=     '</div>';
	    $('#modal-body-comment').html(html);
	  });

	  $('.pre-scrollable').attr('style', 'max-height:' + $(window).height() + 'px;');

		$('.anchor-time').each(function() {
				var time = $(this).html();
				$(this).html( getTimeDelta(time) );
				});

		function createcomment(comment){
		  $comment_clone = $("#comment_panel").clone();
		  $comment_clone.attr("id", "comment_panel_" + comment.id_comment);
		  $comment_clone.find("#comm_pic_path").attr('src', '/' + comment.pic_path);
		  if(comment.auth_surname != null){
		    $comment_clone.find("#comment_author").html('&nbsp;&nbsp;' + comment.auth_name + " " + comment.auth_surname);
		  }
		  else{
		    $comment_clone.find("#comment_author").html('&nbsp;&nbsp;' + comment.auth_name);
		  }
		  $comment_clone.find("#comment_created_at").text(getTimeDelta(comment.created_at));
		  $comment_clone.find("#comment_content").text(comment.content);
		    //segnalazione
		  $comment_clone.find('#reportingComment').attr('data-whatever', comment.id_comment);

		  if(comment.userlike == '0'){
		    $comment_clone.find("#dislikecomm").css({ 'color': 'red'}).attr('id', 'dislikecomm_' + comment.id_comment);;
		    $comment_clone.find("#likecomm").css({ 'color': 'black'}).attr('id', 'likecomm_' + comment.id_comment);
		  }
		  else if(comment.userlike == '1'){
		    $comment_clone.find("#likecomm").css({ 'color': 'blue'}).attr('id', 'likecomm_' + comment.id_comment);
		    $comment_clone.find("#dislikecomm").css({ 'color': 'black'}).attr('id', 'dislikecomm_' + comment.id_comment);
		  }
		  else{
		    $comment_clone.find("#likecomm").css({ 'color': 'black'}).attr('id', 'likecomm_' + comment.id_comment);
		    $comment_clone.find("#dislikecomm").css({ 'color': 'black'}).attr('id', 'dislikecomm_' + comment.id_comment);
		  }
		  return($comment_clone);
		}

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
		               if(data.ban != 1){
		                 $("#comment_insert_" + data.id_post).val('');
		                 $comment_clone = createcomment(data);
		                 $comment_clone.insertBefore("#comment_insert_" + data.id_post);
		                 $comment_clone.show();
		               }
		               else{
		                 alert("Non puoi commentare, sei bannato!");
		               }
		             }
		          })
		      }
		  }


			function reaction(id){
			    $.ajax({
			    method: "POST",
			    dataType: "json",
			    url: "/home/reaction",
			    data: {action: id.split("_")[0], id: id.split("_")[1], _token: '{{csrf_token()}}'},
			     success : function (data)
			     {
			       switch (data.type) {
			         case "post":
			           $("#like_" + data.id_post).css({ 'color': data.status_like })
			           $("#dislike_" + data.id_post).css({ 'color': data.status_dislike });
			           break;
			         case "comm":
			           $("#likecomm_" + data.id_comment).css({ 'color': data.status_like })
			           $("#dislikecomm_" + data.id_comment).css({ 'color': data.status_dislike });
			           break;
			       }
			     }
			  })
			}
		//Caricamento dei commenti
		$(document).ready(function(){
		     $("#comment_panel").hide();
		});

	</script>

@endsection
