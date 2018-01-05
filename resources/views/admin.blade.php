@extends('layouts.admin_layout')

@section('content')
  <div class="container-fluid">
    <div class="row">
      <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
        <ul class="nav nav-pills flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="#statistiche" onclick="changeSelectedSection(1)" id="sezione1">Statistiche
              <!--<span class="sr-only">(current)</span>-->
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#segnalazioni" onclick="changeSelectedSection(2)" id="sezione2">Segnalazioni Post</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#segnalazioniComment" onclick="changeSelectedSection(3)" id="sezione3">Segnalazioni Commenti</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#utenti" onclick="changeSelectedSection(4)" id="sezione4">Utenti</a>
          </li>
        </ul>
      </nav>

      <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
        <h1>Dashboard</h1>

        <h2 id="statistiche">Statistiche</h2>
         <!--<input class="btn btn-secondary btn-sm" type="button" onclick="provaget()" value="provaget">
         <input class="btn btn-secondary btn-sm" type="button" onclick="getPostDetails(4)" value="provapost">-->    
        <section class="row text-center placeholders">
          <div class="col-6 col-sm-3 placeholder">
            <img src="data:image/gif;base64,R0lGODlhAQABAIABAAJ12AAAACwAAAAAAQABAAACAkQBADs=" width="200" height="200" class="img-fluid rounded-circle"
              alt="Generic placeholder thumbnail">
            <h4>Utenti totali</h4>
            <div class="text-muted">{{$totUser}}</div>
          </div>
          <div class="col-6 col-sm-3 placeholder">
            <img src="data:image/gif;base64,R0lGODlhAQABAIABAADcgwAAACwAAAAAAQABAAACAkQBADs=" width="200" height="200" class="img-fluid rounded-circle"
              alt="Generic placeholder thumbnail">
            <h4>Post totali</h4>
            <span class="text-muted">{{$totPost}}</span>
          </div>
          <div class="col-6 col-sm-3 placeholder">
            <img src="data:image/gif;base64,R0lGODlhAQABAIABAAJ12AAAACwAAAAAAQABAAACAkQBADs=" width="200" height="200" class="img-fluid rounded-circle"
              alt="Generic placeholder thumbnail">
            <h4>Commenti totali</h4>
            <span class="text-muted">{{$totComment}}</span>
          </div>
          <div class="col-6 col-sm-3 placeholder">
            <img src="data:image/gif;base64,R0lGODlhAQABAIABAADcgwAAACwAAAAAAQABAAACAkQBADs=" width="200" height="200" class="img-fluid rounded-circle"
              alt="Generic placeholder thumbnail">
            <h4>Pagine totali</h4>
            <span class="text-muted">{{$totPage}}</span>
          </div>
        </section>

        <!--Prova-->
        <section class="container-fluid">
          <div class="row">
            <div class="col-md-6">
              <div id="bar-chart"></div>
            </div>

            <div class="col-md-6">
              <div id="line-chart"></div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8">
              <div id="area-chart"></div>
            </div>

            <div class="col-md-4">
              <div id="donut-chart"></div>
            </div>

            <div class="col-md-8">
              <div id="pie-chart"></div>
            </div>
          </div>
        </section>



        <br>
        <hr id="anchorSegnalazioni">
        <br>

        <h2 id="segnalazioni">Segnalazioni post</h2>
        <div class="alert alert-primary" role="alert">
          <div class="row">
            <div class="col-md-3">
                <label for="selectpickerPostlabel">Stato segnalazione:</label>           
                 <select class="selectpicker" id="selectpickerPost">
                  <option selected>Tutte</option>
                  <option>Aperte</option>
                  <option>Esaminate</option>
                </select> 
            </div>
            <div class="col-md-3">
               <label for="selectpickerMotivoPostlabel">Motivo segnalazione:</label>           
                 <select class="selectpicker" id="selectpickerMotivoPost">
                  <option selected>Tutte</option>
                  <option>Incita all'odio</option>
                  <option>È una notizia falsa</option>
                  <option>È una minaccia</option>
                </select> 
            </div>
            <div class="col-md-3">
               <label for="textIdReportPostlabel">Id segnalazione:</label>           
               <input type="text" id="textIdReportPost"> 
            </div>
            <div class="col-md-1">
              
            </div>
            <div class="col-md-2">
               <button type="button" class="btn btn-danger" id="btnClearFilterPost"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;&nbsp;Pulisci filtri</button>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Id segnalazione</th>
                    <th>Data</th>
                    <th>Motivo</th>
                    <th>Stato</th>
                    <th>Opzioni</th>
                  </tr>
                </thead>
                <tbody id="tbodyPost">

                @foreach($reportList as $r)
                  <tr id="reportRow{{$r->id_report}}">
                    <td>{{$r->id_report}}</td>
                    <td>{{$r->created_at->format('M j, Y H:i')}}</td>
                    <td class="{{$r->id_report}}">{{$r->description}}</td>
                    <td>
                      @if($r->status == "aperta")
                        <span class="badge badge-success" id="labelStatus{{$r->id_report}}">Aperta</span>
                      @else
                        <span class="badge badge-secondary">Esaminata</span>
                      @endif
                    </td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;&nbsp;Opzioni
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item edit-item" href="#" data-toggle="modal" data-target="#detailModal" data-whatever="{{$r->id_report}}">
                            <i class="fa fa-info" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Visualizza dettagli</a>
                          @if($r->status == "aperta")
                            <a class="dropdown-item" href="#">
                              <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Contatta utente</a>
                            <a class="dropdown-item" href="#">
                              <i class="fa fa-ban" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;Blocca utente</a>
                          @endif
                        </div>
                      </div>
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-center" id="paginationPostUl">
                
              </ul>
            </nav>
          </div>
        </div>

        


        
        <br id="segnalazioniComment">
        

        <h2 id="segnalazioniCommenti">Segnalazioni commenti</h2>
        <div class="alert alert-primary" role="alert">
          <div class="row">
            <div class="col-md-3">
                <label for="selectpickerCommentlabel">Stato segnalazione:</label>           
                 <select class="selectpicker" id="selectpickerComment">
                  <option selected>Tutte</option>
                  <option>Aperte</option>
                  <option>Esaminate</option>
                </select> 
            </div>
            <div class="col-md-3">
               <label for="selectpickerMotivoCommentlabel">Motivo segnalazione:</label>           
                 <select class="selectpicker" id="selectpickerMotivoComment">
                  <option selected>Tutte</option>
                  <option>Incita all'odio</option>
                  <option>È una notizia falsa</option>
                  <option>È una minaccia</option>
                </select> 
            </div>
            <div class="col-md-3">
               <label for="textIdReportCommentlabel">Id segnalazione:</label>           
               <input type="text" id="textIdReportComment"> 
            </div>
            <div class="col-md-1">
              
            </div>
            <div class="col-md-2">
               <button type="button" class="btn btn-danger" id="btnClearFilterComment"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;&nbsp;Pulisci filtri</button>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Id segnalazione</th>
                    <th>Data</th>
                    <th>Motivo</th>
                    <th>Stato</th>
                    <th>Opzioni</th>
                  </tr>
                </thead>
                <tbody id="tbodyComment">
                @foreach($reportListComment as $r)
                  <tr id="reportRow{{$r->id_report}}Comment">
                    <td>{{$r->id_report}}</td>
                    <td>{{$r->created_at->format('M j, Y H:i')}}</td>
                    <td class="{{$r->id_report}}Comment">{{$r->description}}</td>
                    <td>
                      @if($r->status == "aperta")
                        <span class="badge badge-success" id="labelStatus{{$r->id_report}}Comment">Aperta</span>
                      @else
                        <span class="badge badge-secondary">Esaminata</span>
                      @endif
                    </td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;&nbsp;Opzioni
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item edit-item" href="#commentModal" data-toggle="modal" data-whatever="{{$r->id_report}}" id="openComment">
                            <i class="fa fa-info" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Visualizza dettagli</a>
                          @if($r->status == "aperta")
                            <a class="dropdown-item" href="#">
                              <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Contatta utente</a>
                            <a class="dropdown-item" href="#">
                              <i class="fa fa-ban" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;Blocca utente</a>
                          @endif
                        </div>
                      </div>
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-center" id="paginationCommentUl">
                
              </ul>
            </nav>
          </div>
        </div>



        <h2 id="utenti">Utenti</h2>
        <div class="alert alert-primary" role="alert">
          <div class="row">
            <div class="col-md-3">
                <label for="selectpickerUserlabel">Stato utente:</label>           
                 <select class="selectpicker" id="selectpickerUser">
                  <option selected>Tutti</option>
                  <option>Bloccati</option>
                  <option>Admin</option>
                </select> 
            </div>
            <div class="col-md-6">
               <label for="textIdUserlabel">Id utente:</label>           
               <input type="text" id="textIdUser"> 
            </div>
            <div class="col-md-1">
              
            </div>
            <div class="col-md-2">
               <button type="button" class="btn btn-danger" id="btnClearFilterUser"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;&nbsp;Pulisci filtri</button>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Id utente</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Data iscrizione</th>
                    <th>Stato</th>
                    <th>Opzioni</th>
                  </tr>
                </thead>
                <tbody id="tbodyUser">
                  @foreach($userList as $u)
                    <tr id="userRow{{$r->id_report}}">
                      <td>{{$u->id_user}}</td>
                      <td>{{$u->name}}&nbsp;{{$u->surname}}</td>
                      <td>{{$u->email}}</td>
                      <td>{{$u->created_at->format('M j, Y H:i')}}</td>
                      <td>
                        @if($u->ban == 1)
                          <span class="badge badge-danger">Bloccato</span>
                        @else
                          <span></span>
                        @endif
                      </td>
                      <td>
                       <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;&nbsp;Opzioni
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#userModal" data-toggle="modal" data-whatever="{{$u->id_user}}" id="openUser">
                            <i class="fa fa-info" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Visualizza dettagli</a>
                          <a class="dropdown-item" href="#">
                            <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Contatta utente</a>
                          @if($u->ban == 1)
                            <a class="dropdown-item" href="#">
                              <i class="fa fa-ban" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;Blocca utente</a>
                          @else
                            <a class="dropdown-item" href="#">
                              <i class="fa fa-unlock" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;Sblocca utente</a>
                          @endif
                        </div>
                      </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-center" id="paginationUserUl">
                
              </ul>
            </nav>
          </div>
        </div>
      </main>
    </div>
  </div>

<!-- Detail Modal -->
<div class="modal fade bd-modal-lg" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Dettagli segnalzione</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="form-control-label">Id segnalazione:</label>
            <input type="text" class="form-control" id="recipient-name" disabled>
          </div>
          <div class="form-group">
            <label for="testoPost" class="form-control-label">Testo post:</label>
            <textarea class="form-control" id="testoPost" rows="7" disabled></textarea>
          </div>
          <div class="form-group">
            <label for="motivoReport" class="form-control-label">Motivo segnalazione:</label>
            <textarea class="form-control" id="motivoReport" rows="1" disabled></textarea>
          </div>
          <div class="form-group">
            <label for="linkProfilo" id="linkProfiloLabel" class="form-control-label">Autore:</label>
            <a href="#" id="linkProfilo"></a>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-12">
           <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
           <button type="button" class="btn btn-secondary" id="btnViewPost">Visualizza post</button>        
           <button type="button" class="btn btn-danger" data-dismiss="modal" id="btnEliminaPost">Elimina post</button>
           <button type="button" class="btn btn-danger" id="btnEliminaBanPost" data-dismiss="modal">Elimina e blocca autore</button>
           <button type="button" class="btn btn-default" data-dismiss="modal" id="btnIgnoraReportPost">Ignora segnalazione</button>    
          </div>
        </div>
      </div>
    </div>
  </div>
</div>




<!-- Comment modal -->
<div class="modal fade bd-example-modal-lg" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titleReportComment">Dettagli segnalzione</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form>
          <div class="form-group">
            <label for="idReportComment" class="form-control-label">Id segnalazione:</label>
            <input type="text" class="form-control" id="idReportComment" disabled>
          </div>
          <div class="form-group">
            <label for="testoCommento" class="form-control-label">Testo commento:</label>
            <textarea class="form-control" id="testoCommento" rows="7" disabled></textarea>
          </div>
          <div class="form-group">
            <label for="motivoReportComment" class="form-control-label">Motivo segnalazione:</label>
            <textarea class="form-control" id="motivoReportComment" rows="1" disabled></textarea>
          </div>
          <div class="form-group">
            <label for="linkProfiloComment" id="linkProfiloCommentLabel" class="form-control-label">Autore:</label>
            <a href="#" id="linkProfiloComment"></a>
          </div>
        </form>
      </div>
      <div class="modal-footer">
         <div class="row">
          <div class="col-md-12">
           <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
           <button type="button" class="btn btn-secondary" id="btnViewComment">Visualizza commento</button>        
           <button type="button" class="btn btn-danger" data-dismiss="modal" id="btnEliminaComment">Elimina commento</button>
           <button type="button" class="btn btn-danger" id="btnEliminaBanComment" data-dismiss="modal">Elimina e blocca autore</button>
           <button type="button" class="btn btn-default" data-dismiss="modal" id="btnIgnoraReportComment">Ignora segnalazione</button>    
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- user modal -->
<div class="modal fade bd-example1-modal-lg" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title">Dettagli utente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-1">
          </div>
          <div class="col-md-4">
            <img src="../assets/images/facebook4.jpeg" class="rounded-circle pull-left" id="imgUser">
          </div>
          <div class="col-md-1">
          </div>
          <div class="col-md-6">
            <h4 id="nomeUser"></h4>
            <h5 id="emailUser"></h5>
            <h5 id="dataIscrizioneUser"></h5>
          </div>
        </div>

      </div>
      <div class="modal-footer">
         <div class="row">
          <div class="col-md-12">
           <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
          <a type="button" class="btn btn-secondary" href="#" id="btnViewProfile">Visualizza profilo</a>      
            <button type="button" class="btn btn-primary" id="btnAdmin">Promuovi a amministratore</button>    
           <button type="button" class="btn btn-danger" data-dismiss="modal" id="btnBan">Blocca utente</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


  <!-- Bootstrap core JavaScript
    ================================================== -->

  <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
  <script src="../assets/js/admin/popper.min.js"></script>
  <script src="../assets/js/admin/bootstrap.min.js"></script>


  <script src="../assets/js/admin/morris.min.js"></script>
  <script src="../assets/js/admin/raphael-min.js"></script>
  <script src="../assets/js/admin/grafici.js"></script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    

  <script src="../assets/js/admin/dashboardAJAX.js"></script>


  <script>

    //GESTIONE TABELLA SEGNALAZIONI POST
    var currentPage = 1;
    var scelta = 'Tutte';
    var motivoReportPost = 'Tutte';
    var idReportPost = -1;

    generatePagination({{$num_page_reportPost}}, currentPage);

    function generatePagination(nPage, currentPage){
        var html;
        if(currentPage == 1){
          html = '<li class="page-item disabled" id="previousPostPage">';
          html = html + ' <button class="page-link" tabindex="-1"><i class="fa fa-angle-double-left" aria-hidden="true"></i></button>';
          html = html + '</li>';
        }else{
          html = '<li class="page-item" id="previousPostPage">';
          html = html + ' <button class="page-link" tabindex="-1" onclick="getPage(' + (currentPage - 1) + ')"><i class="fa fa-angle-double-left" aria-hidden="true"></i></button>';
          html = html + '</li>';          
        }

        var i;
        for(i = 0; i < nPage; i++){
          if((i + 1) == currentPage){
            html = html + '<li class="page-item active"><button class="page-link" onclick="getPage(' + (i + 1) + ')">' + (i + 1) + '</button></li>';
            currentPage = i + 1;
          }else{
            html = html + '<li class="page-item"><button class="page-link" onclick="getPage(' + (i + 1) + ')">' + (i + 1) + '</button></li>';
          }
        }
        if(currentPage == nPage){
          html = html + '<li class="page-item disabled" id="previousPostPage">';
          html = html + ' <button class="page-link" tabindex="-1"><i class="fa fa-angle-double-right" aria-hidden="true"></i></button>';
          html = html + '</li>';
        }else{
          html = html + '<li class="page-item" id="previousPostPage">';
          html = html + ' <button class="page-link" tabindex="-1" onclick="getPage(' + (currentPage + 1) + ')"><i class="fa fa-angle-double-right" aria-hidden="true"></i></button>';
          html = html + '</li>';
        }
       
        $('#paginationPostUl').html(html);
    }

    function getPage(page){
      $.ajax({
          url : '/admin/report/post',
          dataType: 'json',
          type: 'POST',
          data: { page: page, filter: scelta, motivo: motivoReportPost, idReportPost: idReportPost }
      }).done(function (data) {
          currentPage = page;
          manageRow(data);  
          generatePagination(data[0].totPage, page);
      }).fail(function () {
          alert('Reports could not be loaded.');
      });
    }

    function manageRow(data) {
      var rows = '';
      $.each(data, function (key, value) {
        rows = rows + '<tr>';
        rows = rows + '<td>' + value.id_report + '</td>';
        rows = rows + '<td>' + value.created_at + '</td>';
        rows = rows + '<td class="' + value.id_report + '">' + value.description + '</td>';
        if(value.status == 'aperta'){
          rows = rows + '<td><span class="badge badge-success" id="labelStatus' + value.id_report + '">Aperta</span></td>';
        }else{
          rows = rows + '<td><span class="badge badge-secondary">Esaminata</span></td>';
        }
        rows = rows + '<td>';
        rows = rows + ' <div class="dropdown">';
        rows = rows + '   <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
        rows = rows + '     <i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;&nbsp;Opzioni';
        rows = rows + '     </button>';
        rows = rows + '     <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
        rows = rows + '     <a class="dropdown-item edit-item" href="#detailModal" data-toggle="modal" data-whatever="' + value.id_report + '">';
        rows = rows + '        <i class="fa fa-info" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Visualizza dettagli</a>';
        if(value.status == 'aperta'){
          rows = rows + '   <a class="dropdown-item" href="#">';
          rows = rows + '          <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Contatta utente</a>';
          rows = rows + '        <a class="dropdown-item" href="#">';
          rows = rows + '          <i class="fa fa-ban" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;Blocca utente</a>';
        }
              
        rows = rows + '   </div>';
        rows = rows + '  </div>';
        rows = rows + '</td>';
        rows = rows + '</tr>';
      });
      $("#tbodyPost").html(rows);
    }

    $('#selectpickerPost').change(function(){
      var str = $('#selectpickerPost option:selected').text();
      scelta = str;
      currentPage = 1;
      getPage(currentPage);
    }).change();

    $('#selectpickerMotivoPost').change(function(){
      var str = $('#selectpickerMotivoPost option:selected').text();
      motivoReportPost = str;
      currentPage = 1;
      getPage(currentPage);
    }).change();

    $('#textIdReportPost').keyup(function(){
      var str = $('#textIdReportPost').val();
      if(str == "")
        idReportPost = -1;
      else
        idReportPost = str;
      currentPage = 1;
      getPage(currentPage);
    });

    $('#btnClearFilterPost').click(function(){
      var change = false;
      if(scelta != 'Tutte'){
        scelta = 'Tutte';
        change = true;
      }
      if(motivoReportPost != 'Tutte'){
        motivoReportPost = 'Tutte';
        change = true;
      }
      if(idReportPost != -1){
        idReportPost = -1;
        change = true;
      }
      if(change){
        currentPage = 1;
        $('#textIdReportPost').val("");
         $('#selectpickerMotivoPost').val('Tutte');
          $('#selectpickerPost').val('Tutte');
        getPage(currentPage);
      }
    });
    //FINE GESTIONE TABELLA SEGNALAZIONI POST

    //GESTIONE SEGNALAZIONI COMMENTI

    var currentPageComment = 1;
    var sceltaComment = 'Tutte';
    var motivoReportComment = 'Tutte';
    var idReportComment = -1;

    $('#commentModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient = button.data('whatever') // Extract info from data-* attributes
      var post;
      $.ajax({
          dataType: 'json',
          type: 'POST',
          url: '/admin/dashboard/getCommentDetails',
          data: { id_report: recipient }
      }).done(function (data) {
        console.log(data);
        //post = data;
        var modal = $('#commentModal');
        modal.find('.modal-title').text('Dettagli segnalazione ' + recipient);
        modal.find('.modal-body input').val(recipient);
        var td = $("td." + recipient + "Comment").text();
        modal.find('#testoCommento').val(data.content);
        $('#linkProfiloComment').attr("href", data.linkProfiloAutore);
        $('#linkProfiloComment').text(data.nomeAutore)
        if(data.tipoAutore == 1)
          $('#linkProfiloCommentLabel').text('Autore:');
        else
          $('#linkProfiloCommentLabel').text('Pagina:');

        $('#motivoReportComment').val(td);

        //aggiungo evento click al pulsante ignora
        $('#btnIgnoraReportComment').click(function(){
          $.ajax({
            dataType: 'json',
            type: 'POST',
            url: '/admin/dashboard/ignoreReportComment',
            data: { id_report: recipient }
          }).done(function (data) {
            console.log(data);
            $('#labelStatus' + recipient + 'Comment').text('Esaminata').removeClass('badge-success').addClass('badge-secondary');
            getPageComment(currentPageComment);
            toastr.success('La segnalazione è stata esaminata con successo.', 'Operazione completata!', { timeOut: 5000 });
          });
        });

        //evento rimuovi post
        $('#btnEliminaComment').click(function(){
          $.ajax({
            dataType: 'json',
            type: 'POST',
            url: '/admin/dashboard/deleteComment',
            data: { id_report: recipient, ban: 0 }
          }).done(function (data) {
            console.log(data.message);
            $('#labelStatus' + recipient + 'Comment').text('Esaminata').removeClass('badge-success').addClass('badge-secondary');
            //elimino la riga
            $('#reportRow' + recipient + 'Comment').remove();
            getPageComment(currentPageComment);
            toastr.success('Il commento è stato eliminato con successo. Sono state eliminate anche le altre segnalazioni relative a questo commento.', data.message , { timeOut: 5000 });
          });
        });

          $('#btnEliminaBanComment').click(function(){
            $.ajax({
              dataType: 'json',
              type: 'POST',
              url: '/admin/dashboard/deleteComment',
              data: { id_report: recipient, ban : 1 }
            }).done(function (data) {
              console.log(data.message);
              $('#labelStatus' + recipient + 'Comment').text('Esaminata').removeClass('badge-success').addClass('badge-secondary');
              //elimino la riga
              $('#reportRow' + recipient + 'Comment').remove();
              getPageComment(currentPageComment);
              toastr.success('Il commento è stato eliminato con successo e l\'autore è stato bannato e non potrà scrivere su UniBook. Sono state eliminate anche le altre segnalazioni relative a questo commento.', data.message , { timeOut: 5000 });
            });
          });


      });
    });


    $('#commentModal').on('hide.bs.modal', function(event){
      //rimuovo gli eventi una volta che chiudo il modal
      $('#btnIgnoraReportComment').unbind();
      $('#btnEliminaComment').unbind();
      $('#btnEliminaBanComment').unbind();
    });


    generatePaginationComment({{$num_page_reportComment}}, currentPageComment);

    function generatePaginationComment(nPage, currentPage){
        var html;
        if(currentPage == 1){
          html = '<li class="page-item disabled" id="previousPostPage">';
          html = html + ' <button class="page-link" tabindex="-1"><i class="fa fa-angle-double-left" aria-hidden="true"></i></button>';
          html = html + '</li>';
        }else{
          html = '<li class="page-item" id="previousPostPage">';
          html = html + ' <button class="page-link" tabindex="-1" onclick="getPageComment(' + (currentPage - 1) + ')"><i class="fa fa-angle-double-left" aria-hidden="true"></i></button>';
          html = html + '</li>';          
        }

        var i;
        for(i = 0; i < nPage; i++){
          if((i + 1) == currentPage){
            html = html + '<li class="page-item active"><button class="page-link" onclick="getPageComment(' + (i + 1) + ')">' + (i + 1) + '</button></li>';
            currentPage = i + 1;
          }else{
            html = html + '<li class="page-item"><button class="page-link" onclick="getPageComment(' + (i + 1) + ')">' + (i + 1) + '</button></li>';
          }
        }
        if(currentPage == nPage){
          html = html + '<li class="page-item disabled" id="previousPostPage">';
          html = html + ' <button class="page-link" tabindex="-1"><i class="fa fa-angle-double-right" aria-hidden="true"></i></button>';
          html = html + '</li>';
        }else{
          html = html + '<li class="page-item" id="previousPostPage">';
          html = html + ' <button class="page-link" tabindex="-1" onclick="getPageComment(' + (currentPage + 1) + ')"><i class="fa fa-angle-double-right" aria-hidden="true"></i></button>';
          html = html + '</li>';
        }
       
        $('#paginationCommentUl').html(html);
    }

    function getPageComment(page){
      $.ajax({
          url : '/admin/report/comment',
          dataType: 'json',
          type: 'POST',
          data: { page: page, filter: sceltaComment, motivo: motivoReportComment, idReportPost: idReportComment }
      }).done(function (data) {
          currentPageComment = page;
          manageRowComment(data);  
          generatePaginationComment(data[0].totPage, page);
      }).fail(function () {
          alert('Reports could not be loaded.');
      });
    }

    function manageRowComment(data) {
      var rows = '';
      $.each(data, function (key, value) {
        rows = rows + '<tr>';
        rows = rows + '<td>' + value.id_report + '</td>';
        rows = rows + '<td>' + value.created_at + '</td>';
        rows = rows + '<td class="' + value.id_report + 'Comment">' + value.description + '</td>';
        if(value.status == 'aperta'){
          rows = rows + '<td><span class="badge badge-success" id="labelStatus' + value.id_report + 'Comment">Aperta</span></td>';
        }else{
          rows = rows + '<td><span class="badge badge-secondary">Esaminata</span></td>';
        }
        rows = rows + '<td>';
        rows = rows + ' <div class="dropdown">';
        rows = rows + '   <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
        rows = rows + '     <i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;&nbsp;Opzioni';
        rows = rows + '     </button>';
        rows = rows + '     <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
        rows = rows + '     <a class="dropdown-item edit-item" href="#commentModal" data-toggle="modal" data-whatever="' + value.id_report + '">';
        rows = rows + '        <i class="fa fa-info" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Visualizza dettagli</a>';
        if(value.status == 'aperta'){
          rows = rows + '   <a class="dropdown-item" href="#">';
          rows = rows + '          <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Contatta utente</a>';
          rows = rows + '        <a class="dropdown-item" href="#">';
          rows = rows + '          <i class="fa fa-ban" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;Blocca utente</a>';
        }
        rows = rows + '   </div>';
        rows = rows + '  </div>';
        rows = rows + '</td>';
        rows = rows + '</tr>';
      });
      $("#tbodyComment").html(rows);
    }


    $('#selectpickerComment').change(function(){
      var str = $('#selectpickerComment option:selected').text();
      sceltaComment = str;
      currentPageComment = 1;
      getPageComment(currentPageComment);
    }).change();

    $('#selectpickerMotivoComment').change(function(){
      var str = $('#selectpickerMotivoComment option:selected').text();
      motivoReportComment = str;
      currentPageComment = 1;
      getPageComment(currentPageComment);
    }).change();

    $('#textIdReportComment').keyup(function(){
      var str = $('#textIdReportComment').val();
      if(str == "")
        idReportComment = -1;
      else
        idReportComment = str;
      currentPageComment = 1;
      getPageComment(currentPageComment);
    });

    $('#btnClearFilterComment').click(function(){
      var change = false;
      if(sceltaComment != 'Tutte'){
        sceltaComment = 'Tutte';
        change = true;
      }
      if(motivoReportComment != 'Tutte'){
        motivoReportComment = 'Tutte';
        change = true;
      }
      if(idReportComment != -1){
        idReportComment = -1;
        change = true;
      }
      if(change){
        currentPageComment = 1;
        $('#textIdReportComment').val("");
         $('#selectpickerMotivoComment').val('Tutte');
          $('#selectpickerComment').val('Tutte');
        getPageComment(currentPageComment);
      }
    });

    //FINE GESTIONE SEGNALAZIONI COMMENTI

    //GESTIONE UTENTI
    var currentPageUser = 1;
    var sceltaUser = 'Tutti'; //bloccati, admin, tutti
    var idUser = -1;

    generatePaginationUser({{$num_page_user}}, currentPageUser);

    function generatePaginationUser(nPage, currentPage){
        var html;
        if(currentPage == 1){
          html = '<li class="page-item disabled" id="previousPostPage">';
          html = html + ' <button class="page-link" tabindex="-1"><i class="fa fa-angle-double-left" aria-hidden="true"></i></button>';
          html = html + '</li>';
        }else{
          html = '<li class="page-item" id="previousPostPage">';
          html = html + ' <button class="page-link" tabindex="-1" onclick="getPageUser(' + (currentPage - 1) + ')"><i class="fa fa-angle-double-left" aria-hidden="true"></i></button>';
          html = html + '</li>';          
        }

        var i;
        for(i = 0; i < nPage; i++){
          if((i + 1) == currentPage){
            html = html + '<li class="page-item active"><button class="page-link" onclick="getPageUser(' + (i + 1) + ')">' + (i + 1) + '</button></li>';
            currentPage = i + 1;
          }else{
            html = html + '<li class="page-item"><button class="page-link" onclick="getPageUser(' + (i + 1) + ')">' + (i + 1) + '</button></li>';
          }
        }
        if(currentPage == nPage){
          html = html + '<li class="page-item disabled" id="previousPostPage">';
          html = html + ' <button class="page-link" tabindex="-1"><i class="fa fa-angle-double-right" aria-hidden="true"></i></button>';
          html = html + '</li>';
        }else{
          html = html + '<li class="page-item" id="previousPostPage">';
          html = html + ' <button class="page-link" tabindex="-1" onclick="getPageUser(' + (currentPage + 1) + ')"><i class="fa fa-angle-double-right" aria-hidden="true"></i></button>';
          html = html + '</li>';
        }
       
        $('#paginationUserUl').html(html);
    }

    function getPageUser(page){
      $.ajax({
          url : '/admin/dashboard/user',
          dataType: 'json',
          type: 'POST',
          data: { page: page, filter: sceltaUser, idUser: idUser }
      }).done(function (data) {
          currentPageUser = page;
          manageRowUser(data);  
          generatePaginationUser(data[0].totPage, page);
      }).fail(function () {
          alert('Users could not be loaded.');
      });
    }

    function manageRowUser(data) {
      var rows = '';
      $.each(data, function (key, value) {
        rows = rows + '<tr>';
        rows = rows + '<td>' + value.id_user + '</td>';
        rows = rows + '<td>' + value.nome + '</td>';
        rows = rows + '<td>' + value.email + '</td>';
        rows = rows + '<td>' + value.created_at + '</td>';
        if(value.ban == 1){
          rows = rows + '<td><span class="badge badge-danger" id="labelStatusUser' + value.id_user + '">Bloccato</span></td>';
        }else{
          if(value.admin == 1){
            rows = rows + '<td><span class="badge badge-primary" id="labelStatusUser' + value.id_user + '">Admin</span></td>';
          }else{
            rows = rows + '<td><span id="labelStatusUser"></span></td>';
          }
        }
        rows = rows + '<td>';
        rows = rows + ' <div class="dropdown">';
        rows = rows + '   <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
        rows = rows + '     <i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;&nbsp;Opzioni';
        rows = rows + '     </button>';
        rows = rows + '     <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
        rows = rows + '     <a class="dropdown-item edit-item" href="#userModal" data-toggle="modal" data-whatever="' + value.id_user + '">';
        rows = rows + '        <i class="fa fa-info" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Visualizza dettagli</a>';
        rows = rows + '   <a class="dropdown-item" href="#">';
        rows = rows + '          <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Contatta utente</a>';
        if(value.ban == 0){
          rows = rows + '        <a class="dropdown-item" href="#">';
          rows = rows + '          <i class="fa fa-ban" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;Blocca utente</a>';
        }else{
          rows = rows + '   <a class="dropdown-item" href="#">';
          rows = rows + '          <i class="fa fa-unlock" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Sblocca utente</a>';
        }
        rows = rows + '   </div>';
        rows = rows + '  </div>';
        rows = rows + '</td>';
        rows = rows + '</tr>';
      });
      $("#tbodyUser").html(rows);
    }

    $('#selectpickerUser').change(function(){
      var str = $('#selectpickerUser option:selected').text();
      sceltaUser = str;
      currentPageUser = 1;
      getPageUser(currentPageUser);
    }).change();

    $('#textIdUser').keyup(function(){
      var str = $('#textIdUser').val();
      if(str == "")
        idUser = -1;
      else
        idUser = str;
      currentPageUser = 1;
      getPageUser(currentPageUser);
    });

    $('#btnClearFilterUser').click(function(){
      var change = false;
      if(sceltaUser != 'Tutti'){
        sceltaUser = 'Tutti';
        change = true;
      }
      if(idUser != -1){
        idUser = -1;
        change = true;
      }
      if(change){
        currentPageUser = 1;
        $('#textIdUser').val("");
          $('#selectpickerUser').val('Tutti');
        getPageUser(currentPageUser);
      }
    });


    $('#userModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient = button.data('whatever') // Extract info from data-* attributes
      var post;
      $.ajax({
          dataType: 'json',
          type: 'POST',
          url: '/admin/dashboard/getUserDetails',
          data: { id_user: recipient }
      }).done(function (data) {
        console.log(data);
        //post = data;
        var modal = $('#userModal');
        modal.find('.modal-title').text('Dettagli utente ' + recipient);
        $('#nomeUser').text(data.nome);
        $('#emailUser').text('Email: ' + data.email);
        $('#dataIscrizioneUser').text('Data iscrizione: ' + data.created_at);
        $('#imgUser').attr("src", data.picPath);
        $('#btnViewProfile').attr('href', '/profile/user/' + recipient);
      });
    });




    //FINE GESTIONE UTENTI
  </script>
@endsection
