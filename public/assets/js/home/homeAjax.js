
function newComment(e, id){
  //manca controllo campo vuoto!!
  if(e.keyCode === 13){
          e.preventDefault(); // Ensure it is only this code that rusn
          $.ajax({
            method: "POST",
            url: "/home/comment",
            dataType : "json",
            data: {content: $("#comment_insert_" + id.split("_")[2]).val(), id_post: id.split("_")[2], _token: '{{csrf_token()}}'},
             success : function (data)
             {
               $("#comment_insert_" + id.split("_")[2]).val('');
               $("<div id='commpanel" + data.id_comment +
                  "'><hr><div><img id='" + data.pic_path + "' style='width:20px; height:20px; border-radius:50%' >" +
                  "<a id='author' href='/profile/user/" + data.id_user + "'>" +
                  data.auth_name + " " + data.auth_surname +
                  "</a><span padding-left: 10px; id='comm_details'>" + data.content +"</span></div></div>").insertBefore("#input_panel_" + data.id_post);
             }
          })
      }
  }

function newPost(){
  //manca controllo che il campo non sia vuoto!
  $.ajax({
          method: "POST",
          url: "/home/post",
          data: {content: $("#new_post_content").val(), is_fixed: 0},
          dataType : "json",
          beforeSend: function (xhr) {
               var token = '{{csrf_token()}}';

               if (token) {
                   return xhr.setRequestHeader('X-CSRF-TOKEN', token);
               }
           },
          success : function (data)
          {
            $("#new_post_content").val('');
            $post_clone = $("#post").clone();
            $post_clone.attr("id", "post_" + data.id_post);
            $post_clone.find("#input_panel").attr("id", "input_panel_" + data.id_post);
            $post_clone.find("#creation_date").text(data.created_at);
            $post_clone.find("#comment_insert").attr("id", "comment_insert_" + data.id_post);
            $post_clone.find("#post_u_name").text(data.auth_name + " " + data.auth_surname);
            $post_clone.find("#post_pic_path").attr('src', data.pic_path);
            $post_clone.find("#post_content").text(data.content);
            $post_clone.find("#like_butt").text(data.likes);
            $post_clone.find("#insert_after").attr('id', "insert_after" + data.id_post);
            $post_clone.insertAfter(".well");
            $post_clone.show();
            if(data.comments.length > 0){
              for(j = 0; j < data.comments.length; j++){
                $("<div id='commpanel" + data.comments[j].id_comment +
                   "'><hr><!--TODO: immagine-->" +
                   "<a id='author' href='/profile/user/" + data.comments[j].id_user + "'>" +
                   data.comments[j].auth_name + " " + data.comments[j].auth_surname +
                   "</a><p id='comm_details'>" + data.comments[j].content +"</p></div>").insertBefore("#input_panel_" + data.id_post);
            }
          }
        }
      });
}


function onLoad(data){
  $("#post").hide();
  //ciclo su tutti i post, al contrario perchè prendo dal più recente al più vecchio
  for(var i = data.length - 1; i >= 0; i--)
  {
    $post_clone = $("#post").clone();
    $post_clone.find("#input_panel").attr("id", "input_panel_" + data[i].id_post);
    $post_clone.find("#comment_insert").attr("id", "comment_insert_" + data[i].id_post);
    $post_clone.find("#creation_date").text(data[i].created_at);
    $post_clone.attr("id", "post_" + data[i].id_post);
    $post_clone.find("#post_u_name").text(data[i].auth_name + " " + data[i].auth_surname);
    $post_clone.find("#post_pic_path").attr('src', data[i].pic_path);
    $post_clone.find("#post_content").text(data[i].content);
    $post_clone.find("#like_butt").text(data[i].likes);
    $post_clone.find("#insert_after").attr('id', "insert_after" + data[i].id_post);
    $post_clone.insertAfter(".well");
    $post_clone.show();
    }
    data.forEach(function(el) {
      //carico i commenti
      if(el.comments.length > 0 && el.id_post == el.comments[0].id_post){
        for(j = 0; j < el.comments.length; j++){
          $("<div id='commpanel" + el.comments[j].id_comment +
             "'><hr><!--TODO: immagine-->" +
             "<a id='author' href='/profile/user/" + el.comments[j].id_user + "'>" +
             el.comments[j].auth_name + " " + el.comments[j].auth_surname +
             "</a><p id='comm_details'>" + el.comments[j].content +"</p></div>").insertAfter("#insert_after" + el.id_post);
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
          data: { post_id: $post_id },
          dataType : "json",
          success : function (posts)
          {
            if(posts.length != 0)
            {
              for(var x = posts.length - 1; x >= 0 ; x--)
              {
                $post_clone = $("#post").clone();
                $post_clone.find("#input_panel").attr("id", "input_panel_" + posts[x].id_post);
                $post_clone.find("#comment_insert").attr("id", "comment_insert_" + posts[x].id_post);
                $post_clone.find("#creation_date").text(posts[x].created_at);
                $post_clone.attr("id", "post_" + posts[x].id_post);
                $post_clone.find("#post_u_name").text(posts[x].auth_name + " " + posts[x].auth_surname);
                $post_clone.find("#post_pic_path").attr('src', posts[x].pic_path);
                $post_clone.find("#post_content").text(posts[x].content);
                $post_clone.find("#like_butt").text(posts[x].likes);
                $post_clone.find("#insert_after").attr('id', "insert_after" + posts[x].id_post);
                $post_clone.insertAfter("#post_" + $post_id);
                $post_clone.show();
                }
                posts.forEach(function(el) {
                  //carico i commenti
                  if(el.comments.length > 0 && el.id_post == el.comments[0].id_post){
                    for(j = 0; j < el.comments.length; j++){
                      $("<div id='commpanel" + el.comments[j].id_comment +
                         "'><hr><!--TODO: immagine-->" +
                         "<a id='author' href='/profile/user/" + el.comments[j].id_user + "'>" +
                         el.comments[j].auth_name + " " + el.comments[j].auth_surname +
                         "</a><p id='comm_details'>" + el.comments[j].content +"</p></div>").insertAfter("#insert_after" + el.id_post);
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

//Caricamento dei post
$(document).ready(function(){
     $.ajax({
         url : '/home/loadmore',
         method : "GET",
         dataType : "json",
         data: { post_id: -1 },
         success : function (posts)
         {
           onLoad(posts);
         }
     });
});
