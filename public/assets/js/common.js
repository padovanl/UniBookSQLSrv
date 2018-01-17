function createTooltipData(data){
    if(data.length > 0 && data.length <= 4){
      var toreturn = '<ul>';
      data.forEach(function(el){
          toreturn += "<li><a href='/profile/user/" + el.id_user + "'>" + el.name + " " + el.surname + "</a></li>";
      });
      toreturn += '</ul>';
     return toreturn;
    }
    else if(data.length > 4){
      var toreturn = '<ul>';
      for(i = 0; i < 4; i++){
        toreturn += "<li><a href='/profile/user/" + data[i].id_user + "'>" + data[i].name + " " + data[i].surname + "</a></li>";
      }
      toreturn += "<li>e altri " + (data.length - 3) + "</li>";
      toreturn += '</ul>';
      return toreturn;
    }
    else{
      return "Ancora niente";
    }
  }

function commentfocus(id){
    $("#comment_insert_" + id.split("_")[1]).focus();
}

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

function reaction(id, page=null){
  if($.isNumeric(location.href.match(/([^\/]*)\/*$/)[1])){
    var id_page = location.href.match(/([^\/]*)\/*$/)[1];
  }
    $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
    $.ajax({
    method: "get",
    dataType: "json",
    url: "/home/reaction",
    data: {action: id.split("_")[0], id: id.split("_")[1], id_page: id_page},
     success : function (data)
     {
       console.log(data);
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

function createcomment(comment){
  $comment_clone = $("#comment_panel").clone();
  $comment_clone.attr("id", "comment_panel_" + comment.id_comment);
  $comment_clone.find("#comm_pic_path").attr('src', comment.pic_path);
  if(comment.auth_surname != null){
    $comment_clone.find("#comment_author").html('&nbsp;&nbsp;' + comment.auth_name + " " + comment.auth_surname);
    $comment_clone.find("#comment_author").attr('href', '/profile/user/' + comment.id_author);
  }
  else{
    $comment_clone.find("#comment_author").html('&nbsp;&nbsp;' + comment.auth_name);
    $comment_clone.find("#comment_author").attr('href', '/profile/page/' + comment.id_author);
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
  return($comment_clone);
}

function createPost(data){
  $post_clone = $("#post").clone();
  $post_clone.attr("id", "post_" + data.id_post);
  $post_clone.find("#input_panel").attr("id", "input_panel_" + data.id_post);
  $post_clone.find("#creation_date").text(getTimeDelta(data.created_at)).attr('href', '/post/details/' + data.id_post);
  $post_clone.find("#comment_insert").attr("id", "comment_insert_" + data.id_post);
  if(data.auth_surname != null){
    $post_clone.find("#post_u_name").html("&nbsp;&nbsp;" + data.auth_name + " " + data.auth_surname).attr('href', '/profile/user/' + data.id_auth);
  }
  else{
    $post_clone.find("#post_u_name").html("&nbsp;&nbsp;" + data.auth_name).attr('href', '/profile/page/' + data.id_auth);
  }
  $post_clone.find("#post_pic_path").attr('src', data.pic_path);
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
  if(data.userlike == '0'){
    $post_clone.find("#dislike").css({ 'color': 'red'}).attr('id', 'dislike_' + data.id_post);;
    $post_clone.find("#like").css({ 'color': 'black'}).attr('id', 'like_' + data.id_post);
  }
  else if(data.userlike == '1'){
    $post_clone.find("#like").css({ 'color': 'blue'}).attr('id', 'like_' + data.id_post);
    $post_clone.find("#dislike").css({ 'color': 'black'}).attr('id', 'dislike_' + data.id_post);
  }
  else{
    $post_clone.find("#like").css({ 'color': 'black'}).attr('id', 'like_' + data.id_post);
    $post_clone.find("#dislike").css({ 'color': 'black'}).attr('id', 'dislike_' + data.id_post);
  }
  $post_clone.find("#comment").attr('id', 'comment_' + data.id_post);

  return($post_clone);
}

function newComment(e, id, page=null){
  //manca controllo campo vuoto!!
  if($.isNumeric(location.href.match(/([^\/]*)\/*$/)[1])){
    var id_page = location.href.match(/([^\/]*)\/*$/)[1];
  }
  if(e.keyCode === 13){
          console.log(id.split("_")[2]);
          e.preventDefault();
          $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  });
          $.ajax({
            method: "POST",
            url: "/home/comment",
            dataType : "json",
            data: {content: $("#comment_insert_" + id.split("_")[2]).val(), id_post: id.split("_")[2], id_page: id_page},
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

function newPost(id_page = null){
  //manca controllo che il campo non sia vuoto!
  if($.isNumeric(location.href.match(/([^\/]*)\/*$/)[1])){
    var id_page = location.href.match(/([^\/]*)\/*$/)[1];
  }

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
          method: "POST",
          url: "/home/post",
          data: {content: $("#new_post_content").val(), id_page: id_page},
          dataType : "json",
          success : function (data)
          {
            if(data.ban != 1){
              $("#new_post_content").val('');
              $post_clone = createPost(data)
              $post_clone.insertAfter(".well");
              $post_clone.show();
              $("#comment_panel").hide();
              if(data.comments.length > 0){
                for(j = 0; j < data.comments.length; j++){
                  $comment_clone = createcomment(data.comments[j]);
                  $comment_clone.insertBefore("#comment_insert_" + data.id_comment);
                  $comment_clone.show();
              }
            }
            }
            else{
              alert("Non puoi scrivere post, sei bannato!");
            }

        }
      });
}

function onLoad(data, page=null){
  $("#post").hide();
  $("#comment_panel").hide();
  //ciclo su tutti i post, al contrario perchè prendo dal più recente al più vecchio
  for(var i = data.length - 1; i >= 0; i--)
  {
    $post_clone = createPost(data[i]);
    if(!page){
        $post_clone.insertAfter(".well");
    }
    else{
      $post_clone.insertAfter(".insert_after_me");
    }
    $post_clone.show();
    }
    data.forEach(function(el) {
      //carico i commenti
      if(el.comments.length > 0 && (el.id_post == el.comments[0].id_post)){
        for(j = 0; j < el.comments.length; j++){
          $comment_clone = createcomment(el.comments[j]);
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
          url: "/home/loadmore",
          data: { post_id: $post_id, home: 1},
          dataType : "json",
          success : function (posts)
          {
            if(posts.length != 0)
            {
              for(var x = posts.length - 1; x >= 0 ; x--)
              {
                $post_clone = createPost(posts[x]);
                $post_clone.insertAfter("#post_" + $post_id);
                $post_clone.show();
                $("#comment_panel").hide();

                }
                posts.forEach(function(el) {
                  //carico i commenti
                  if(el.comments.length > 0 && el.id_post == el.comments[0].id_post){
                    for(j = 0; j < el.comments.length; j++){
                      $comment_clone = createcomment(el.comments[j]);
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
