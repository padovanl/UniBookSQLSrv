<!doctype html>
<html lang="it">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="stylesheet" href="../assets/css/admin/grafici.css" />
  <link rel="stylesheet" href="../assets/css/admin/morris.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
  <title>Unibook - Dashboard</title>

  <!-- Bootstrap core CSS -->
  <link href="../assets/css/admin/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../assets/css/admin/dashboard.css" rel="stylesheet">

  <!--Token per ajax-->
  <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
  <header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <a class="navbar-brand" href="#">Unibook Dashboard</a>
      <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>


    </nav>
  </header>

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
            <a class="nav-link" href="#segnalazioni" onclick="changeSelectedSection(2)" id="sezione2">Segnalazioni</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#utenti" onclick="changeSelectedSection(3)" id="sezione3">Utenti</a>
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
        <hr>
        <br>




        <h2 id="segnalazioni">Segnalazioni</h2>
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Data</th>
                    <th>Descrizione</th>
                    <th>Tipo</th>
                    <th>Stato</th>
                    <th>Opzioni</th>
                  </tr>
                </thead>
                <tbody>

                @foreach($reportList as $r)
                  <tr>
                    <td>{{$r->created_at->format('M j, Y H:i')}}</td>
                    <td class="{{$r->id_report}}">{{$r->description}}</td>
                    <td>
                      <span class="badge badge-danger">Post</span>
                    </td>
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
                              <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Contatta amminisratore pagina</a>
                            <a class="dropdown-item" href="#">
                              <i class="fa fa-ban" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;Blocca pagina</a>
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
        <br>
        <div class="row">
          <div class="col-sm-12">
            <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                  <a class="page-link" href="#" tabindex="-1">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                  </a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="#">3</a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="#">
                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                  </a>
                </li>
              </ul>
            </nav>
          </div>
        </div>

        <br>
        <hr>
        <br>

        <h2 id="utenti">Utenti</h2>
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Id utente</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Data iscrizione</th>
                    <th>Opzioni</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1001</td>
                    <td>Luca Padovan</td>
                    <td>emailinventata@gmail.com</td>
                    <td>20 Novembre 20017, 16:54</td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;&nbsp;Opzioni
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#">
                            <i class="fa fa-info" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Visualizza profilo</a>
                          <a class="dropdown-item" href="#">
                            <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Contatta utente</a>
                          <a class="dropdown-item" href="#">
                            <i class="fa fa-ban" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;Blocca utente</a>
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-sm-12">
            <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                  <a class="page-link" href="#" tabindex="-1">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                  </a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="#">3</a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="#">
                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                  </a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <hr>
      </main>
    </div>
  </div>


		<!-- Detail Modal -->

<div class="modal fade bd-example-modal-lg" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
            <label for="message-text" class="form-control-label">Testo post:</label>
            <textarea class="form-control" id="message-text" rows="10" disabled></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-secondary" id="btnEliminaPost">Visualizza post</button>        
        <button type="button" class="btn btn-danger" id="btnEliminaPost">Elimina post</button>
        <button type="button" class="btn btn-danger" id="btnEliminaBanPost">Elimina post e blocca utente</button>
        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnIgnoraReportPost">Ignora segnalazione</button>
      </div>
    </div>
  </div>
</div>


  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>-->

    <script
        src="https://code.jquery.com/jquery-3.2.1.js"
        integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
        crossorigin="anonymous"></script>
  <!--<script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery.min.js"><\/script>')</script>-->
  <script src="../assets/js/admin/popper.min.js"></script>
  <script src="../assets/js/admin/bootstrap.min.js"></script>


  <script src="../assets/js/admin/morris.min.js"></script>
  <script src="../assets/js/admin/raphael-min.js"></script>
  <script src="../assets/js/admin/grafici.js"></script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    


  <script>

	$('#detailModal').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var recipient = button.data('whatever') // Extract info from data-* attributes
    var post;
//ajax
    $.ajax({
        dataType: 'json',
        type: 'POST',
        url: '/admin/dashboard/getPostDetails',
        data: { id_post: recipient }
    }).done(function (data) {
      console.log(data);
      //post = data;
      var modal = $('#detailModal');
      modal.find('.modal-title').text('Dettagli segnalazione ' + recipient);
      modal.find('.modal-body input').val(recipient);
      var td = $("td." + recipient).text();
      modal.find('.modal-body textarea').val(data.content);

      $('#btnIgnoraReportPost').click(function(){
        $.ajax({
          dataType: 'json',
          type: 'POST',
          url: '/admin/dashboard/ignoreReportPost',
          data: { id_report: recipient }
        }).done(function (data) {
          console.log(data);
          $('#labelStatus' + recipient).text('Esaminata');
          $('#labelStatus' + recipient).removeClass('badge-success').addClass('badge-secondary');
          toastr.success('La segnalazione è stata esaminata con successo.', 'Operazione completata!', { timeOut: 5000 });
        });
      });
    });
   
	 
	});

  $('#btnIgnoraReportPost').on()


  function provaget(){
    $.get('/test', function(response){ 
        console.log(response); 
    });
  }


  function getPostDetails(id){
    $.ajax({
        dataType: 'json',
        type: 'POST',
        url: '/admin/dashboard/getPostDetails',
        data: { id_post: id }
    }).done(function (data) {
      console.log(data);
      return data;
    });
  }

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  function provapost(){
    $.ajax({
        dataType: 'json',
        type: 'POST',
        url: '/test',
        data: { title: 'titolo', description: 'descrizione' }
    }).done(function (data) {
        //console.log(data);


        //questo fa una cosa per ogni campo json
        //$.each(data, function(k, v){
        //  console.log(v);
        //});

        //posso accedere ai dati ritornati come ad un semplice oggetto
        console.log(data.titolo);
        console.log(data.descrizione);
    });

  }

  </script>
</body>

</html>
