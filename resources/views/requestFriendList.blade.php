@extends('layouts.app')

@section('content')

    <article class="content">
        <div class="container-full">
            <br/>
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10" id="requestContainer">
                    @if(count($requestList) > 0)
                        @foreach($requestList as $r)
                            <div id="{{$r->id_request}}" class="friend_index">
                                <div class="req_index">
                                <div>
                                    <img class="img_friends" src="{{$r->user->pic_path}}">
                                </div>
                                <div class="page_index_name">
                                    <p>{{$r->content}}</p>
                                </div>
                                </div>
                                <div class="acc_buttons">
                                    <button class="buttonPersonal button_acc btn-primary"
                                            onclick="accetta({{$r->id_request}}, '{{$r->id_request_user}}')"><i
                                                class="fa fa-check" aria-hidden="true"></i></button>
                                    <button class="buttonPersonalRed button_acc btn-default"
                                            onclick="rifiuta({{$r->id_request}}, '{{$r->id_request_user}}')"><i
                                                class="fa fa-times" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <br id='br{{$r->id_request}}'/>
                        @endforeach

                    @else
                        <div class="page_alert" role="alert" >
                            <strong>Nessuna richiesta di amicizia in sospeso</strong>
                        </div>
                    @endif
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
    </article>


    <script>
        function accetta(id_request, id_request_user) {
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: '/friend/accept',
                data: {id_request: id_request, id_user: id_request_user}
            }).done(function (data) {
                totRichieste--;
                $('#' + id_request).remove();
                $('#br' + id_request).remove();
                if (totRichieste == 0) {
                    var html = '';
                    html += '<div class="page_alert" role="alert" >';
                    html += '<strong>Nessuna richiesta di amicizia in sospeso</strong>';
                    html += '</div>';
                    $('#requestContainer').html(html);
                }
                //console.log(data);
            });
        }

        var totRichieste = {{count($requestList)}};


        function rifiuta(id_request, id_request_user) {
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: '/friend/decline',
                data: {id_request: id_request, id_user: id_request_user}
            }).done(function (data) {
                totRichieste--;
                $('#' + id_request).remove();
                $('#br' + id_request).remove();
                if (totRichieste == 0) {
                    var html = '';
                    html += '<div class="page_alert" role="alert" >';
                    html += '<strong>Nessuna richiesta di amicizia in sospeso</strong>';
                    html += '</div>';
                    $('#requestContainer').html(html);
                }
                //console.log(data);
            });

        }
    </script>

@endsection
