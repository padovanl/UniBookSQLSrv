function stopFollow(id_page, id_user) {
  console.log(id_page,' ', id_user)
  $.ajax({
    dataType: 'json',
    type: 'POST',
    url: '/profile/page/stopFollow',
    data: { id_page: parseInt(id_page), id_user: id_user }
  }).done(function (data) {
    $('#stopFollowP').remove();
    var html = '<p id="followP"><a onclick="follow( \'' + id_page + '\' ,\''+ id_user + '\')"><i id="follow" class="glyphicon glyphicon-thumbs-up"></i> Segui</a></p>';
    $('#piace_ono').html(html);

    $('#num_followers').text(data.tot_followers);
  });



}

function follow(id_page, id_user) {
  console.log(id_page,' ', id_user)
  $.ajax({
    dataType: 'json',
    type: 'POST',
    url: '/profile/page/follow',
    data: { id_page: parseInt(id_page), id_user: id_user }
  }).done(function (data) {
    $('#followP').remove();
    var html = ' <p id="stopFollowP"><a onclick="stopFollow( \'' + id_page + '\' ,\''+ id_user + '\')"><i id="follow" class="glyphicon glyphicon-thumbs-down"></i>Smetti di seguire la pagina</a></p>';
    $('#piace_ono').html(html);

    $('#num_followers').text(data.tot_followers);
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

      showFileSize();
  }
}


function showFileSize() {
    var input, file;
    input = document.getElementById('image');
    file = input.files[0]; console.log(file);
    var filesizeMb = file.size/1024/1024;
    if(filesizeMb >= 2.0){
        alert('La dimensione dell\'immagine del profilo non deve superare i 2MB');
        $('#btnChange').prop('disabled', true);
    }
    else{
        $('#btnChange').prop('disabled', false);
    }
}
