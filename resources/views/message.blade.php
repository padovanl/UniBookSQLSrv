@extends('layouts.app')

@section('content')

    <article>
        <div class="container-full">

            <div class="pre-scrollable" id="messaggi" style="width: 100%;">
                @if(count($messages) > 0)
                    @foreach($messages[0]->listMessage as $m)
                        @if($m->sender == $logged_user->id_user)
                            <div class="container darker">
                                <img src="{{$messages[0]->picPathReceiver}}" alt="Avatar" class="right">
                                <p>{{$m->content}}</p>
                                <span class="time-left">{{$m->created_at->format('H:i')}}</span>
                            </div>
                        @else
                            <div class="container">
                                <img src="{{$messages[0]->picPath}}" alt="Avatar">
                                <p>{{$m->content}}</p>
                                <span class="time-right">{{$m->created_at->format('H:i')}}</span>
                            </div>
                        @endif
                    @endforeach


                    <div class="container darker">
                        <form>
                            <div class="form-group">
                                <label for="messageUser" class="form-control-label">Nuovo messaggio:</label>
                                <textarea class="form-control form-rounded" id="messageUser" rows="4"></textarea>
                                <button type="button" class="btn btn-primary" id="bthSendMessageUser" disabled="true"
                                        onclick="addMessage('{{$idFirstUser}}')">Invia messaggio
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </article>

    <aside class="side" style="margin: 0 auto; height: 700px;">
        <div class="pre-scrollable">
            <div class="list-group" id="sidebar">
                @foreach($messages as $m)
                    <a href="#" onclick="ChangeChat('{{$m->fromId}}')" class="list-group-item listMessagesLink"
                       id="messages{{$m->fromId}}">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="{{$m->picPath}}" alt="Avatar" width="50" height="50">
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-10">
                                        <p>{{$m->from}}</p>
                                    </div>
                                    <div class="col-md-2">
                                        @if($m->numNuovi > 0)
                                            <span class="badge badge-danger"
                                                  id="newMessage{{$m->fromId}}">{{$m->numNuovi}}</span>
                                        @endif
                                    </div>
                                </div>

                                <p>{{$m->listMessage[count($m->listMessage) - 1]->content}}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </aside>



    <style>
        #messageUser{
            font-size: 15px;
        }
        .form-rounded {
            border-radius: 1rem;
        }
    </style>

    <style>
        img {
            border-radius: 50%;
        }

        .pre-scrollable {
            max-height: 800px;
            overflow-y: scroll;
            overflow-x: hidden;
        }
    </style>
    <style>
        /* Chat containers */
        .container {
            border: 2px solid #dedede;
            background-color: #a1d8e9;
            border-radius: 5px;
            padding: 10px;
            margin: 0 auto;
            width: 100%;
        }

        /* Darker chat container */
        .darker {
            border: 1px solid #EEEEEE;
            border-radius: 1rem;
            background-color: #F5F5F5;
        }
        /* Clear floats */
        .container::after {
            content: "";
            clear: both;
            display: table;
        }

        /* Style images */
        .container img {
            float: left;
            max-width: 60px;
            width: 100%;
            margin-right: 20px;
            border-radius: 50%;
        }

        /* Style the right image */
        .container img.right {
            float: right;
            margin-left: 20px;
            margin-right: 0;
        }

        /* Style time text */
        .time-right {
            float: right;
            color: rgb(7, 5, 5);
        }

        /* Style time text */
        .time-left {
            float: left;
            color: #999;
            font-size: 14px;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.2.1.js"
            integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
    <script src="../assets/js/admin/popper.min.js"></script>
    <script src="../assets/js/admin/bootstrap.min.js"></script>

    <script>

        $("#sidebar a:first-child").addClass("active");


        function ChangeChat(from) {
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: '/message/changeChat',
                data: {from: from}
            }).done(function (data) {
                //console.log(data);
                $('.listMessagesLink').removeClass('active');
                $('#messages' + from).addClass('active');
                $('#newMessage' + from).remove();
                manageChatBox(data, from);
                var elem = document.getElementById('messaggi');
                elem.scrollTop = elem.scrollHeight;
            });
        }

        function manageChatBox(data, from) {
            var message = '';
            $.each(data, function (key, value) {
                if (value.tipo == 1) {
                    message += '   <div class="container darker">';
                    message += '      <img src="' + value.picPath + '" alt="Avatar" class="right">';
                    message += '      <p>' + value.content + '</p>';
                    message += '      <span class="time-left">' + value.time + '</span>';
                    message += '   </div>';
                } else {
                    message += '   <div class="container">';
                    message += '      <img src="' + value.picPathReceiver + '" alt="Avatar">';
                    message += '      <p>' + value.content + '</p>';
                    message += '      <span class="time-right">' + value.time + '</span>';
                    message += '   </div>';
                }
            });

            message += '      <div class="container darker">';
            message += '    <form>';
            message += '      <div class="form-group">';
            message += '        <label for="messageUser" class="form-control-label">Nuovo messaggio:</label>';
            message += '        <textarea class="form-control" id="messageUser" rows="4"></textarea>';
            message += '        <button type="button" class="btn btn-primary" id="bthSendMessageUser" disabled="true" onclick="addMessage(\'' + from + '\')">Invia messaggio</button> ';
            message += '      </div>';
            message += '    </form>';
            message += '  </div>';

            $("#messaggi").html(message);


            $('#messageUser').keyup(function (event) {
                var text = $('#messageUser').val();
                if (text == '') {
                    $('#bthSendMessageUser').attr('disabled', true);
                } else {
                    $('#bthSendMessageUser').attr('disabled', false);
                }
            });

        }


        function addMessage(to) {
            var newMessage = $('#messageUser').val();
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: '/message/newMessage',
                data: {to: to, message: newMessage}
            }).done(function (data) {
                ChangeChat(to);
            });
        }


        $('#messageUser').keyup(function (event) {
            var text = $('#messageUser').val();
            if (text == '') {
                $('#bthSendMessageUser').attr('disabled', true);
            } else {
                $('#bthSendMessageUser').attr('disabled', false);
            }
        });


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#btnTimeline').addClass('btn-border');
        $('#btnPage').addClass('btn-border');
        $('#btnMessage').removeClass('btn-border');
    </script>

@endsection