@extends('layouts.app')

@section('content')

  <div class="padding">
      <div class="full col-sm-12">
          <!-- content -->
          <div class="row">
              <!-- main col right -->
              <div class="col-sm-7">

                  <div class="well">
                      <form class="form" method="POST" action="/post">
                          <h4>New Post</h4>
                          <div class="input-group text-center">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                              <input class="form-control input-lg" name="content" placeholder="Hey, What's Up?" type="text">
                              <span class="input-group-btn"><button type="submit" class="btn btn-lg btn-primary">Post</button></span>
                          </div>
                      </form>
                  </div>
                  <!--Caricamento dei post-->
                  {{-- @foreach ($posts as $post)
                  <!--Nuovo pannello commenti-->
                  <div class="panel panel-default">
                    <div class="panel-heading"><ul class="nav navbar-nav navbar-right">
                          <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                              </a>
                              <ul class="dropdown-menu">
                                  <li><a href="">Dettagli Post</a></li>
                                  <li><a href="">Visualizza Profilo</a></li>
                                  <li><a href="">Rimuovi dagli amici</a></li>
                                  <li><a href="">Segnala Post</a></li>
                              </ul>
                          </li>
                      </ul>
                      <div>
                          <h4>{{$controller->PrintName($post['id_author'])}}</h4>
                          <img src="{{$u['pic_path']}}" class="img-circle pull-left">
                      </div>
                    </div>
                    <div class="panel-body">
                    <p>{{$post['content']}}</p>
                    <div class="clearfix"></div>
                    @foreach ($list_comments as $comment)
                        @if ($comment['id_post'] === $post -> id_post)
                        <!--linea-->
                        <hr>
                        <!--TODO: immagine-->
                        <p><a href="/profile/user/{{$comment['id_author']}}">{{$controller->PrintName($comment -> id_author)}}  </a>{{$comment -> content}}</p>
                      @endif
                  @endforeach --}}
                        {{-- <hr>
                    <form>
                    <div class="input-group">
                      <div class="input-group-btn">
                      <button class="btn btn-default">+1</button><button class="btn btn-default"><i class="glyphicon glyphicon-share"></i></button>
                      </div>
                      <input class="form-control" placeholder="Add a comment.." type="text">
                    </div>
                    </form>

                    </div>
                 </div>
                @endforeach --}}

@endsection
