@extends('layouts.profile_layout')

@section('content')

<style>
  .w3-teal, .w3-hover-teal:hover{
  color: #fff!important;
  background-color: #4285f4!important;
  }

  .w3-text-teal, .w3-hover-text-teal:hover {
      color: #4285f4!important;
  }

</style>

<article class="content">

  <form id="uploadimage" action="" method="post" enctype="multipart/form-data">
    <div id="image_preview"><img id="previewing" src="/{{$logged_user -> pic_path}}" /></div>
      <hr id="line">
      <div id="selectImage">
      <label>Select Your Image</label><br/>
      <input type="file" name="file" id="file" required />
      <input type="submit" value="Upload" class="submit" />
    </div>
  </form>
  <br>
  <h4 id='loading' >loading..</h4>
  <div id="message"></div>
  <br>
  <p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i>Dettagli Utente</b></p>
  <form name="modulo">
    <p>Nome</p>
    <p><input type="text" name="name" id="name" value = "{{$logged_user -> name}}"></p>
    <p>Cognome</p>
    <p><input type="text" name="surname" id="surname" value="{{$logged_user -> surname}}"></p>
    <p>Citta'</p>
    <p><input type="text" name="citta" id="citta" value="{{$logged_user -> citta}}"></p>
    <input type="button" id="bottone" value="Invia i dati">
  </form>
  <br>
  <p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i>Privacy</b></p>
    <div class = "radio">
      <input type = "radio" name = "privacy" value = "1" <?php if($logged_user->profiloPubblico == 1){ echo "checked";}?>/> Private </br>
      <input type = "radio" name = "privacy" value = "0" <?php if($logged_user->profiloPubblico == 0){ echo "checked";}?>/> Public </br>
    </div>

    <br>
  </div>
</div><br>
<a href="/profile/user/<?php echo "$logged_user->id_user" ?>">Back</a>
</article>


<script>
//form
$(document).ready(function() {
      $("#bottone").click(function(){
        var name = $("#name").val();
        var surname = $("#surname").val();
        var citta = $("#citta").val();
        console.log(name,surname,citta);
        $.ajax({
          type: "POST",
          url: "/formDetails",
          data: {name:name,surname:surname,citta:citta},
          dataType: "json",
          success: function(data)
          {
            console.log(data.message);
          }
        });
      });
    });



//radio privacy
$(document).ready(function(){
          $('input[type="radio"]').click(function(){
            var privacy = $(this).val();
            console.log(privacy);
            $.ajax({
              url:"/privacy",
              method: "POST",
              data: {privacy:privacy},
              dataType: 'json',
              success:function(data){
                console.log(data.message);
              }
            });
          })
        })

$(document).ready(function (e) {
        $("#uploadimage").on('submit',(function(e) {
        e.preventDefault();
        $("#message").empty();
        $('#loading').show();
        var fd = new FormData(this);
        console.log(fd);
        $.ajax({
          url: "/formImage", // Url to which the request is send
          type: "POST",             // Type of request to be send, called as method
          data: {fd:fd}, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
          contentType: false,       // The content type used when sending data to the server.
          cache: false,             // To unable request pages to be cached
          processData:false,        // To send DOMDocument or non processed data file it is set to false
          success: function(data)   // A function to be called if request succeeds
          {
            $('#loading').hide();
            $("#message").html(data);
          }
        });
    }));

        // Function to preview image after validation
    $(function() {
          $("#file").change(function() {
          $("#message").empty(); // To remove the previous error message
          var file = this.files[0];
          var imagefile = file.type;
          var match= ["image/jpeg","image/png","image/jpg"];
          if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
            {
              $('#previewing').attr('src','noimage.png');
              $("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
              return false;
            }
          else{
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
            }
        });
      });

function imageIsLoaded(e) {
            $("#file").css("color","green");
            $('#image_preview').css("display", "block");
            $('#previewing').attr('src', e.target.result);
            $('#previewing').attr('width', '250px');
            $('#previewing').attr('height', '230px');
          };
        });

</script>


@endsection
