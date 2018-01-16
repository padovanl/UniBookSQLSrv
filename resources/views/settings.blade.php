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
  <div class="w3-display-container">
    <div class="image-upload">
    	    <label for="file-input">
    	        <img src="/{{$logged_user->pic_path}}" id="profilePic" width="300px" height="300px" alt="Avatar" />
    	    </label>
    	    <input id="file-input" type="file" onchange="readURL(this);" />
    	</div>
  </div>
  <div class="w3-container">
    <p><i class="fa fa-briefcase fa-fw w3-margin-right w3-large w3-text-teal"></i>Student</p>
    <p><i class="fa fa-home fa-fw w3-margin-right w3-large w3-text-teal"></i>{{$logged_user -> citta}}</p>
    <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-teal"></i>{{$logged_user -> email}}</p>
    <hr>
    <p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i>Privacy</b></p>
    <div class = "radio">
      <input type = "radio" name = "privacy" value = "1" /> Private</br>
      <input type = "radio" name = "privacy" value = "0" /> Public</br>
    </div>
    <!--p class="w3-large w3-text-theme"><b><i class="fa fa-globe fa-fw w3-margin-right w3-text-teal"></i>Languages</b></p>
    <p>English</p>
    <div class="w3-light-grey w3-round-xlarge">
      <div class="w3-round-xlarge w3-teal" style="height:24px;width:100%"></div>
    </div>
    <p>Spanish</p>
    <div class="w3-light-grey w3-round-xlarge">
      <div class="w3-round-xlarge w3-teal" style="height:24px;width:55%"></div>
    </div>
    <p>German</p>
    <div class="w3-light-grey w3-round-xlarge">
      <div class="w3-round-xlarge w3-teal" style="height:24px;width:25%"></div>
    </div-->
    <br>
  </div>
</div><br>
</article>


	<style type="text/css">
		.image-upload > input
		{
		    display: none;
		}
		img:hover {
		    cursor: pointer;
		}
	</style>

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>

<script>
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
        }
        console.log(input.files[0]);
    }

    $(document).ready(function(){
          $('input[type="radio"]').click(function(){
            var privacy = $(this).val();
            $.ajax({
              url:"/privacy",
              method: "POST",
              data: {provacy:privacy},
              success:function(data){
                $('#result').html(data);
              }
            });
          })
        })
</script>


@endsection
