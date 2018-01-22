@extends('layouts.settings_layout')

@section('content')

    <style>


        .w3-text-teal, .w3-hover-text-teal:hover {
            color: #4285f4 !important;
        }

    </style>
    <style type="text/css">
        .uploaded_image > input {
            display: none;
        }

        img:hover {
            cursor: pointer;
        }
    </style>

    <article class="content">
        <div>
            <div class="back_to_profile">
                <a href="/profile/user/<?php echo "$logged_user->id_user" ?>">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>TORNA AL PROFILO</a>
            </div>
        </div>
        <div class="info_user">
            <div>
            <!--caricamento immagine-->
            <div class="image-upload">
                <p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i>Cambia immagine</b>
                </p>
                <div class="mod_image">
                <label for="file">
                    <img src="{{$logged_user -> pic_path}}" id="uploaded_image" width="300px" height="300px"/>
                </label>
                </div>
            </div>
            <div class="container" style="width:400px; margin: 0 auto; padding: 0 70px;">

                <input type="file" name="file" id="file" style="display: none;"/>
                <br/>
                <span id="uploaded_image"></span>
            </div>
            <div id="image_view" style="text-align: center;">
                <img id="uploaded_image">
            </div>

            <p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i>Dettagli Utente</b>
            </p>

            <form name="modulo">
                <p>Nome: <input class="form-control" type="text" name="name" id="name" value="{{$logged_user -> name}}">
                </p>
                <p>Cognome: <input class="form-control" type="text" name="surname" id="surname"
                                   value="{{$logged_user -> surname}}"></p>
                <p>Citt&agrave: <input class="form-control" type="text" name="citta" id="citta"
                                       value="{{$logged_user -> citta}}"></p>
                <div>
                    <input type="button" class="button" id="bottone" value="Modifica">
                </div>
            </form>
            <br>
            <p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i>Privacy</b></p>
            <div class="radio">
                <p style="font-size: 12px; color: #a9abad;">Impostando la privacy del tuo profilo, puoi decidere se gli
                    utenti che non sono tuoi amici possono vedere i tuoi post.</p>
                <input type="radio" name="privacy" value="1" <?php if ($logged_user->profiloPubblico == 1) {
                    echo "checked";
                }?>/> Privato &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="privacy" value="0" <?php if ($logged_user->profiloPubblico == 0) {
                    echo "checked";
                }?>/> Pubblico </br>
            </div>

            <br>
            </div>
        </div>

        <br>
    </article>


    <script>
        //form
        $(document).ready(function () {
            $("#bottone").click(function () {
                var name = $("#name").val();
                var surname = $("#surname").val();
                var citta = $("#citta").val();
                console.log(name, surname, citta);
                $.ajax({
                    type: "POST",
                    url: "/formDetails",
                    data: {name: name, surname: surname, citta: citta},
                    dataType: "json",
                    success: function (data) {
                        //console.log(data.message);
                        alert("I tuoi dati sono stati modificati!");
                    }
                });
            });
        });

        //radio privacy
        $(document).ready(function () {
            $('input[type="radio"]').click(function () {
                var privacy = $(this).val();
                console.log(privacy);
                $.ajax({
                    url: "/privacy",
                    method: "POST",
                    data: {privacy: privacy},
                    dataType: 'json',
                    success: function (data) {
                        console.log(data.message);
                    }
                });
            })
        })


        $(document).ready(function () {
            $(document).on('change', '#file', function () {
                var name = document.getElementById("file").files[0].name;
                var form_data = new FormData();
                var ext = name.split('.').pop().toLowerCase();
                if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                    alert("Invalid Image File");
                }
                var oFReader = new FileReader();
                oFReader.readAsDataURL(document.getElementById("file").files[0]);
                var f = document.getElementById("file").files[0];
                var fsize = f.size || f.fileSize;
                if (fsize > 2000000) {
                    alert("Image File Size is very big");
                }
                else {

                    form_data.append("file", document.getElementById('file').files[0]);
                    $.ajax({
                        url: "/formImage",
                        method: "POST",
                        data: form_data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function () {
                    	    $('#uploaded_image').hide(1);
                            $('#uploaded_image').html("<label class='text-success'>Image Uploading...</label>");
                        },
                        success: function (data) {
                            $('#uploaded_image').html(data);
                            $('#uploaded_image').show();
                            location.reload();

                        }
                    });
                }
            });
        });


    </script>


@endsection
