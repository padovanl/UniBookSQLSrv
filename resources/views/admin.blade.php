<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="stylesheet" href="../assets/css/admin/grafici.css" />
  <link rel="stylesheet" href="../assets/css/admin/morris.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Unibook - Dashboard</title>

  <!-- Bootstrap core CSS -->
  <link href="../assets/css/admin/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../assets/css/admin/dashboard.css" rel="stylesheet">
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
        <section class="row text-center placeholders">
          <div class="col-6 col-sm-3 placeholder">
            <img src="data:image/gif;base64,R0lGODlhAQABAIABAAJ12AAAACwAAAAAAQABAAACAkQBADs=" width="200" height="200" class="img-fluid rounded-circle"
              alt="Generic placeholder thumbnail">
            <h4>Utenti totali</h4>
            <div class="text-muted">1914</div>
          </div>
          <div class="col-6 col-sm-3 placeholder">
            <img src="data:image/gif;base64,R0lGODlhAQABAIABAADcgwAAACwAAAAAAQABAAACAkQBADs=" width="200" height="200" class="img-fluid rounded-circle"
              alt="Generic placeholder thumbnail">
            <h4>Post totali</h4>
            <span class="text-muted">20189</span>
          </div>
          <div class="col-6 col-sm-3 placeholder">
            <img src="data:image/gif;base64,R0lGODlhAQABAIABAAJ12AAAACwAAAAAAQABAAACAkQBADs=" width="200" height="200" class="img-fluid rounded-circle"
              alt="Generic placeholder thumbnail">
            <h4>Commenti totali</h4>
            <span class="text-muted">500050</span>
          </div>
          <div class="col-6 col-sm-3 placeholder">
            <img src="data:image/gif;base64,R0lGODlhAQABAIABAADcgwAAACwAAAAAAQABAAACAkQBADs=" width="200" height="200" class="img-fluid rounded-circle"
              alt="Generic placeholder thumbnail">
            <h4>Pagine totali</h4>
            <span class="text-muted">2400</span>
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
                    <th>Id segnalazione</th>
                    <th>Data</th>
                    <th>Tipo</th>
                    <th>Stato</th>
                    <th>Opzioni</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1001</td>
                    <td>20 Novembre 20017, 16:54</td>
                    <td>
                      <span class="badge badge-danger">Pagina</span>
                    </td>
                    <td>
                      <span class="badge badge-success">Aperta</span>
                    </td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;&nbsp;Opzioni
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#">
                            <i class="fa fa-info" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Visualizza pagina</a>
                          <a class="dropdown-item" href="#">
                            <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Contatta amminisratore pagina</a>
                          <a class="dropdown-item" href="#">
                            <i class="fa fa-ban" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;Blocca pagina</a>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>1001</td>
                    <td>20 Novembre 20017, 16:54</td>
                    <td>
                      <span class="badge badge-danger">Pagina</span>
                    </td>
                    <td>
                      <span class="badge badge-success">Aperta</span>
                    </td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;&nbsp;Opzioni
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#">
                            <i class="fa fa-info" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Visualizza pagina</a>
                          <a class="dropdown-item" href="#">
                            <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Contatta amminisratore pagina</a>
                          <a class="dropdown-item" href="#">
                            <i class="fa fa-ban" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;Blocca pagina</a>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>1001</td>
                    <td>20 Novembre 20017, 16:54</td>
                    <td>
                      <span class="badge badge-danger">Pagina</span>
                    </td>
                    <td>
                      <span class="badge badge-secondary">Chiusa</span>
                    </td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                          disabled>
                          <i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;&nbsp;Opzioni
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#">
                            <i class="fa fa-info" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Visualizza pagina</a>
                          <a class="dropdown-item" href="#">
                            <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Contatta amminisratore pagina</a>
                          <a class="dropdown-item" href="#">
                            <i class="fa fa-ban" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;Blocca pagina</a>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>1001</td>
                    <td>20 Novembre 20017, 16:54</td>
                    <td>
                      <span class="badge badge-danger">Pagina</span>
                    </td>
                    <td>
                      <span class="badge badge-success">Aperta</span>
                    </td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;&nbsp;Opzioni
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#">
                            <i class="fa fa-info" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Visualizza pagina</a>
                          <a class="dropdown-item" href="#">
                            <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Contatta amminisratore pagina</a>
                          <a class="dropdown-item" href="#">
                            <i class="fa fa-ban" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;Blocca pagina</a>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>1001</td>
                    <td>20 Novembre 20017, 16:54</td>
                    <td>
                      <span class="badge badge-warning">Commento</span>
                    </td>
                    <td>
                      <span class="badge badge-success">Aperta</span>
                    </td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;&nbsp;Opzioni
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#">
                            <i class="fa fa-info" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Visualizza commento</a>
                          <a class="dropdown-item" href="#">
                            <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Contatta utente</a>
                          <a class="dropdown-item" href="#">
                            <i class="fa fa-ban" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;Blocca utente</a>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>1001</td>
                    <td>20 Novembre 20017, 16:54</td>
                    <td>
                      <span class="badge badge-danger">Pagina</span>
                    </td>
                    <td>
                      <span class="badge badge-success">Aperta</span>
                    </td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;&nbsp;Opzioni
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#">
                            <i class="fa fa-info" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Visualizza pagina</a>
                          <a class="dropdown-item" href="#">
                            <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Contatta amminisratore pagina</a>
                          <a class="dropdown-item" href="#">
                            <i class="fa fa-ban" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;Blocca pagina</a>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>1001</td>
                    <td>20 Novembre 20017, 16:54</td>
                    <td>
                      <span class="badge badge-danger">Pagina</span>
                    </td>
                    <td>
                      <span class="badge badge-success">Aperta</span>
                    </td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;&nbsp;Opzioni
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#">
                            <i class="fa fa-info" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Visualizza pagina</a>
                          <a class="dropdown-item" href="#">
                            <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Contatta amminisratore pagina</a>
                          <a class="dropdown-item" href="#">
                            <i class="fa fa-ban" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;Blocca pagina</a>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>1001</td>
                    <td>20 Novembre 20017, 16:54</td>
                    <td>
                      <span class="badge badge-info">Post</span>
                    </td>
                    <td>
                      <span class="badge badge-success">Aperta</span>
                    </td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;&nbsp;Opzioni
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#">
                            <i class="fa fa-info" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Visualizza post</a>
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
                    <td>padovan.93@gmail.com</td>
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
                  <tr>
                    <td>1001</td>
                    <td>Luca Padovan</td>
                    <td>padovan.93@gmail.com</td>
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
                  <tr>
                    <td>1001</td>
                    <td>Luca Padovan</td>
                    <td>padovan.93@gmail.com</td>
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
                  <tr>
                    <td>1001</td>
                    <td>Luca Padovan</td>
                    <td>padovan.93@gmail.com</td>
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
                  <tr>
                    <td>1001</td>
                    <td>Luca Padovan</td>
                    <td>padovan.93@gmail.com</td>
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
                  <tr>
                    <td>1001</td>
                    <td>Luca Padovan</td>
                    <td>padovan.93@gmail.com</td>
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
                  <tr>
                    <td>1001</td>
                    <td>Luca Padovan</td>
                    <td>padovan.93@gmail.com</td>
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
                  <tr>
                    <td>1001</td>
                    <td>Luca Padovan</td>
                    <td>padovan.93@gmail.com</td>
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

  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <!--<script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery.min.js"><\/script>')</script>-->
  <script src="../assets/js/admin/popper.min.js"></script>
  <script src="../assets/js/admin/bootstrap.min.js"></script>


  <script src="../assets/js/admin/morris.min.js"></script>
  <script src="../assets/js/admin/raphael-min.js"></script>
  <script src="../assets/js/admin/grafici.js"></script>

  <script>

  </script>
</body>

</html>
