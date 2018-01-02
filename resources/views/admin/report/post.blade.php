@extends('layouts.admin_layout')

@section('content')
 <div class="container-fluid">
    <div class="row">


      <main role="main" class="col-sm-12 ml-sm-auto col-md-12">
        <hr>
        <h2>Lista segnalazioni post</h2>
        <hr>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>Seleziona stato notifica:</p>                    
                </div>
                <div class="col-md-6">
                    <select class="selectpicker">
                      <option selected>Tutte</option>
                      <option>Aperte</option>
                      <option>Esaminate</option>
                    </select>
                </div>
            </div>
            <br>
	        <div class="row">
	            <div class="col-sm-12">
	                <div class="table-responsive">
		                <table class="table table-striped">
		                	<thead>
			                  <tr>
			                    <th>Id segnalazione</th>
			                    <th>Data</th>
			                    <th>Descrizione</th>
			                    <th>Tipo</th>
			                    <th>Opzioni</th>
			                  </tr>
			                </thead>
			                <tbody>

			                @if (count($reports) > 0)
			                    <section class="reports">
			                        @include('admin.report.load')
			                    </section>
			                @endif
			                </tbody>
	              		</table>
	        		</div>
	    		</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					
				</div>
			</div>
			<nav aria-label="Page navigation example">
				{{ $reports->links() }}
			</nav>
			
			
      </main>
    </div>
  </div>


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
          <div>
          <div class="form-group">
            <label for="testoPost" class="form-control-label">Testo post:</label>
            <textarea class="form-control" id="testoPost" rows="7" disabled></textarea>
          </div>
          <div class="form-group">
            <label for="motivoReport" class="form-control-label">Motivo segnalazione:</label>
            <textarea class="form-control" id="motivoReport" rows="3" disabled></textarea>
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
           <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
           <button type="button" class="btn btn-secondary" id="btnViewPost">Visualizza post</button>        
           <button type="button" class="btn btn-danger" data-dismiss="modal" id="btnEliminaPost">Elimina post</button>
           <button type="button" class="btn btn-danger" id="btnEliminaBanPost">Elimina post e blocca utente</button>
           <button type="button" class="btn btn-default" data-dismiss="modal" id="btnIgnoraReportPost">Ignora segnalazione</button>    
          </div>
        </div>

      </div>
    </div>
  </div>
</div>




  <!-- Bootstrap core JavaScript
    ================================================== -->

  <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
  <script src="../../../assets/js/admin/popper.min.js"></script>
  <script src="../../../assets/js/admin/bootstrap.min.js"></script>





  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    

  <script src="../../../assets/js/admin/dashboardAJAX.js"></script>


  <script type="text/javascript">

$(function() {
    $('body').on('click', '.pagination a', function(e) {
        e.preventDefault();

        $('#load a').css('color', '#dfecf6');
        $('#load').append('<img style="position: absolute; left: 0; top: 0; z-index: 100000;" src="../../../../public/assets/images/loading.gif" />');

        var url = $(this).attr('href');  
        getReports(url);
        window.history.pushState("", "", url);
    });

    function getReports(url) {
        $.ajax({
            url : url,
            dataType: 'json'
        }).done(function (data) {
            //$('.reports').html(data);
            manageRow(data);  
            $('ul.pagination').show();
            managePagination(data);
            //$('ul.pagination').find('li.active').html('<a href="#" class="page-link">' + data.current_page + '</a>');

        }).fail(function () {
            alert('Reports could not be loaded.');
        });
    }
});


function managePagination(data){
    if(data.current_page == 1){
        $('ul.pagination li:first-child').addClass('disabled').html('<span class="page-link">«</span>');
    }else{
        $('ul.pagination li:first-child').removeClass('disabled').html('<a href="http://127.0.0.1:8000/admin/report/post?page=' + (data.current_page - 1) + '" class="page-link">«</a>');
    }

    if(data.current_page == data.last_page){
        $('ul.pagination li:last-child').addClass('disabled').html('<span class="page-link">»</span>');
    }else{
        $('ul.pagination li:last-child').removeClass('disabled').html('<a href="http://127.0.0.1:8000/admin/report/post?page=' + (data.current_page + 1) + '" class="page-link">»</a>');
    }



    var prev_page = currentPage;
    currentPage = data.current_page;
    var tmp = 'ul.pagination li:nth-child(' + (parseInt(prev_page) + 1) + ')';
    $(tmp).removeClass('active').html('<a href="http://127.0.0.1:8000/admin/report/post?page=' + prev_page + '" class="page-link">' + prev_page + '</a>');
    $('ul.pagination li:nth-child(' + (parseInt(data.current_page) + 1) + ')').addClass('active').html('<span class="page-link">' + data.current_page + '</span>');
}

var currentPage = getUrlVars()['page'];

function getUrlVars(){
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}


$('ul.pagination').find('li').addClass('page-item').children().addClass('page-link');

//$('a').addClass('page-link');
//$('li.active').removeClass('page-item');


function manageRow(data) {
    var rows = '';
    $.each(data.data, function (key, value) {
        rows = rows + '<tr>';
        rows = rows + '<td>' + value.id_report + '</td>';
        rows = rows + '<td>' + value.created_at + '</td>';
        rows = rows + '<td>' + value.description + '</td>';
        if(value.status == 'aperta'){
        	rows = rows + '<td><span class="badge badge-success" id="labelStatus' + value.id_report + '">Aperta</span></td>';
        }else{
        	rows = rows + '<td><span class="badge badge-secondary">Esaminata</span></td>';
        }
        rows = rows + '<td>';
	    rows = rows + '	<div class="dropdown">';
	    rows = rows + '		<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
	    rows = rows + '     <i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;&nbsp;Opzioni';
	    rows = rows + '     </button>';
	    rows = rows + '     <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
	    rows = rows + '     <a class="dropdown-item edit-item" href="#" data-toggle="modal" data-target="#detailModal" data-whatever="' + value.id_report + '">';
	    rows = rows + '        <i class="fa fa-info" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Visualizza dettagli</a>';
	    if(value.status == 'aperta'){
		    rows = rows + '  	<a class="dropdown-item" href="#">';
		    rows = rows + '          <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Contatta utente</a>';
		    rows = rows + '        <a class="dropdown-item" href="#">';
		    rows = rows + '          <i class="fa fa-ban" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;Blocca utente</a>';
	    }
	          
	    rows = rows + '   </div>';
	    rows = rows + '  </div>';
	    rows = rows + '</td>';
        rows = rows + '</tr>';
    });
    $("tbody").html(rows);
}



  $('select').change(function(){
    $.ajax({
        url : '/admin/report/post',
        dataType: 'json',
        data: { scelta: $( "select option:selected" ).text(), page: 1 }
    }).done(function (data) {
        //$('.reports').html(data);
        manageRow(data);  
        if(($( "select option:selected" ).text() == 'Aperte') || ($( "select option:selected" ).text() == 'Esaminate'))
            $('ul.pagination').hide();
        else
            $('ul.pagination').show();
        //managePagination(data);
    }).fail(function () {
        alert('Reports could not be loaded.');
    });

    //alert(str);
  });


</script>



@endsection
