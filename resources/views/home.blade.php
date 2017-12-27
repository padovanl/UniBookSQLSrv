@extends('layouts.app')

@section('content')
<div class="wrapper">
    <div class="box">
        <div class="row row-offcanvas row-offcanvas-left">

            <!-- sidebar -->
            <div class="column col-sm-2 col-xs-1 sidebar-offcanvas" id="sidebar">

                <ul class="nav">
                    <li><a href="#" data-toggle="offcanvas" class="visible-xs text-center"><i class="glyphicon glyphicon-chevron-right"></i></a></li>
                </ul>

                <ul class="nav hidden-xs" id="lg-menu">
                    <li class="active"><a href="#featured"><i class="glyphicon glyphicon-list-alt"></i> Featured</a></li>
                    <li><a href="#stories"><i class="glyphicon glyphicon-list"></i> Stories</a></li>
                    <li><a href="#"><i class="glyphicon glyphicon-paperclip"></i> Saved</a></li>
                    <li><a href="#"><i class="glyphicon glyphicon-refresh"></i> Refresh</a></li>
                </ul>
                <ul class="list-unstyled hidden-xs" id="sidebar-footer">
                    <li>
                        <a href="https://www.facebook.com/unife.it/"><h3>UniBook</h3> <i class="glyphicon glyphicon-heart-empty"></i> by UniFe</a>
                    </li>
                </ul>

                <!-- tiny only nav-->
                <ul class="nav visible-xs" id="xs-menu">
                    <li><a href="#featured" class="text-center"><i class="glyphicon glyphicon-list-alt"></i></a></li>
                    <li><a href="#stories" class="text-center"><i class="glyphicon glyphicon-list"></i></a></li>
                    <li><a href="#" class="text-center"><i class="glyphicon glyphicon-paperclip"></i></a></li>
                    <li><a href="#" class="text-center"><i class="glyphicon glyphicon-refresh"></i></a></li>
                </ul>

            </div>
            <!-- /sidebar -->

            <!-- main right col -->
            <div class="column col-sm-10 col-xs-11 col-offeset-4" id="main">

                <!-- top nav -->
                <div class="navbar navbar-blue navbar-static-top">
                    <div class="navbar-header">
                        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="/" class="navbar-brand logo">b</a>
                    </div>
                    <nav class="collapse navbar-collapse" role="navigation">
                        <form class="navbar-form navbar-left">
                            <div class="input-group input-group-sm" style="max-width:360px;">
                                <input class="form-control" placeholder="Search" name="srch-term" id="srch-term" type="text">
                                <div class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                </div>
                            </div>
                        </form>
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="#"><i class="glyphicon glyphicon-home"></i> Home</a>
                            </li>
                            <li>
                                <a href="#postModal" role="button" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i> Post</a>
                            </li>
                            <li>
                                <a href="#"><span class="badge">{{$user -> name}} {{$user -> surname}}</span></a>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i></a>
                                <ul class="dropdown-menu">
                                    <li><a href="">Report..</a></li>
                                    <li><a href="">Activity Log</a></li>
                                    <li><a href="">Settings</a></li>
                                    <li><a href="">About UniBook</a></li>
                                    <li><a href="/logout">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!-- /top nav -->

                <div class="padding">
                    <div class="full col-sm-9">

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
                                @foreach ($posts as $post)
                                  <div class="panel panel-default">
                                      <div class="panel-heading"><ul class="nav navbar-nav navbar-right">
                                              <li class="dropdown">
                                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i></a>
                                                  <ul class="dropdown-menu">
                                                      <li><a href="">More</a></li>
                                                      <li><a href="">More</a></li>
                                                      <li><a href="">More</a></li>
                                                      <li><a href="">More</a></li>
                                                      <li><a href="">More</a></li>
                                                  </ul>
                                              </li>
                                          </ul> <h4>
                                            <?php $u = $controller->ShowUser($post->id_author); ?>
                                            {{$u->name.' '.$u->surname}}
                                          </h4>
                                        </div>
                                      <div class="panel-body">
                                          <div class="clearfix"></div>
                                          <hr>
                                          {{$post -> content}}
                                      </div>
                                  </div>
                                @endforeach
                            </div>
                            <div class="col-sm-5">
                                <div class="container">
                                    <div class="row">
                                        <div class="panel panel-default user_panel">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Suggested Friends</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-container">
                                                    <table class="table-users table" border="0">
                                                        <tbody>
                                                        <tr>
                                                            <td  align="center">
                                                                <i class="fa fa-2x fa-user fw"></i>
                                                            </td>
                                                            <td>
                                                                John Smith<br><i class="fa fa-envelope"></i>
                                                            </td>
                                                            <td>
                                                                Builder Admin
                                                            </td>
                                                            <td align="center">
                                                                Last Login:  6/14/2017<br><small class="text-muted">2 days ago</small>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <img class="pull-left img-circle nav-user-photo" width="50" src="{{asset($user -> pic_path)}}" />  
                                                            </td>
                                                            <td>
                                                                Herbert Hoover<br><i class="fa fa-envelope"></i>
                                                            </td>
                                                            <td>
                                                                Builder Sales Agent
                                                            </td>
                                                            <td align="center">
                                                                Last Login:  6/10/2017<br><small class="text-muted">5 days ago</small>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--/row-->


                        <div class="row">
                            <div class="col-sm-6">
                                <a href="#">Twitter</a> <small class="text-muted">|</small> <a href="#">Facebook</a> <small class="text-muted">|</small> <a href="#">Google+</a>
                            </div>
                        </div>

                        <div class="row" id="footer">
                            <div class="col-sm-6">

                            </div>
                            <div class="col-sm-6">
                                <p>
                                    <a href="#" class="pull-right">\A9Copyright 2013</a>
                                </p>
                            </div>
                        </div>

                        <hr>

                        <h4 class="text-center">
                            <a href="/" target="ext">Download this Template @Bootply</a>
                        </h4>

                        <hr>

                    </div><!-- /col-9 -->
                </div><!-- /padding -->
            </div>
            <!-- /main -->

        </div>
    </div>
</div>


<!--post modal-->
<div id="postModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">\D7</button>
                Update Status
            </div>
            <div class="modal-body">
                <form class="form center-block">
                    <div class="form-group">
                        <textarea class="form-control input-lg" autofocus="" placeholder="What do you want to share?"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div>
                    <button class="btn btn-primary btn-sm" data-dismiss="modal" aria-hidden="true">Post</button>
                    <ul class="pull-left list-inline"><li><a href=""><i class="glyphicon glyphicon-upload"></i></a></li><li><a href=""><i class="glyphicon glyphicon-camera"></i></a></li><li><a href=""><i class="glyphicon glyphicon-map-marker"></i></a></li></ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="../assets/js/jquery.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle=offcanvas]').click(function() {
            $(this).toggleClass('visible-xs text-center');
            $(this).find('i').toggleClass('glyphicon-chevron-right glyphicon-chevron-left');
            $('.row-offcanvas').toggleClass('active');
            $('#lg-menu').toggleClass('hidden-xs').toggleClass('visible-xs');
            $('#xs-menu').toggleClass('visible-xs').toggleClass('hidden-xs');
            $('#btnShow').toggle();
        });
    });
</script>
@endsection
