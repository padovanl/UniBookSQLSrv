@extends('layouts.app')

@section('content')

    <article>
        <div class="container-full">
            <div class="pre-scrollable">
            @foreach($notificationList as $n)
                <div class="row">
                    <div class="col-md-12">
                        <div class="list-group" id="sidebar">
                            <a href="{{$n->link}}" onclick="leggi({{$n->id_notification}})"
                               class="list-group-item listMessagesLink" id="messages">
                                <div class="row">
                                    <div class="col-md-2">
                                        <img src="{{$n->picPath}}" alt="Avatar" width="50" height="50"
                                             style="border-radius: 50%;">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <p>{{$n->content}}</p>
                                            </div>
                                            <div class="col-md-1">
                                                @if($n->new)
                                                    <img src="../../assets/img/puntoEsclamativo.png" width="20px" height="20px">
                                                @endif
                                            </div>
                                            <div class="col-md-2">
                                                <p class="notificationTime" id="{{$n->id_notification}}" style="font-size: 12px; color: #cacdd1;"><i>{{$n->created_at}}</i></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </article>

    <style>
        .pre-scrollable {
            max-height: 800px;
            overflow-y: scroll;
            overflow-x: hidden;
        }
    </style>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function leggi(id) {
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: '/notification/read',
                data: {id: id}
            }).done(function (data) {
            });
        }



    </script>



@endsection
