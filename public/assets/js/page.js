function stopFollow(id_page, id_user) {
  $.ajax({
    dataType: 'json',
    type: 'POST',
    url: '/profile/page/stopFollow',
    data: { id_page: id_page, id_user: id_user }
  }).done(function (data) {
    $('#stopFollowP').remove();
    var html = '<p id="followP" style="text-align: center; color: blue;"><a style="cursor: pointer; font-size: 20px;" onclick="follow({{$page->id_page}}, \'{{$logged_user->id_user}}\')"><i style="cursor:pointer; color: blue;" id="follow" class="glyphicon glyphicon-thumbs-up"></i>&nbsp;Segui</a></p>';
    $('#divFollowPage').html(html);

    var t = $('#totFollowers');
    $('#totFollowers').html('<p style="text-align: center; color: blue; font-size: 20px;"><i style="color: blue;" id="like" class="glyphicon glyphicon-user"></i>&nbsp;' + data.tot_followers + ' persone seguono questa pagina</p>');
  });



}

function follow(id_page, id_user) {
  $.ajax({
    dataType: 'json',
    type: 'POST',
    url: '/profile/page/follow',
    data: { id_page: id_page, id_user: id_user }
  }).done(function (data) {
    $('#followP').remove();
    var html = ' <p id="stopFollowP" style="text-align: center; color: red;"><a style="cursor: pointer; font-size: 20px;" onclick="stopFollow({{$page->id_page}}, \'{{$logged_user->id_user}}\')"><i style="cursor:pointer; color: red;" id="follow" class="glyphicon glyphicon-thumbs-down"></i>&nbsp;Smetti di seguire la pagina</a></p>';
    $('#divFollowPage').html(html);

    var t = $('#totFollowers');
    $('#totFollowers').html('<p style="text-align: center; color: blue; font-size: 20px;"><i style="color: blue;" id="like" class="glyphicon glyphicon-user"></i>&nbsp;' + data.tot_followers + ' persone seguono questa pagina</p>');
  });
}

function InvitaAmici(id_page) {
  $.ajax({
    dataType: 'json',
    type: 'POST',
    url: '/page/invite',
    data: { id_page: id_page }
  }).done(function (data) {
    var html = '<i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;' + data.totInviti + ' inviti inviati!';
    $('#spanInviti').html(html);
  });
}

function readURL(input) {
  if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
          $('#profilePic')
              .attr('src', e.target.result)
              .width(300)
              .height(300);
      };

      reader.readAsDataURL(input.files[0]);
      $('#btnChange').removeAttr('disabled');
  }
}
