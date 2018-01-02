$('#detailModal').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var recipient = button.data('whatever') // Extract info from data-* attributes
    var post;
    $.ajax({
        dataType: 'json',
        type: 'POST',
        url: '/admin/dashboard/getPostDetails',
        data: { id_report: recipient }
    }).done(function (data) {
      console.log(data);
      //post = data;
      var modal = $('#detailModal');
      modal.find('.modal-title').text('Dettagli segnalazione ' + recipient);
      modal.find('.modal-body input').val(recipient);
      var td = $("td." + recipient).text();
      modal.find('#testoPost').val(data.content);

      $('#linkProfilo').attr("href", data.linkProfiloAutore);
      $('#linkProfilo').text(data.nomeAutore)
      if(data.tipoAutore == 1)
        $('#linkProfiloLabel').text('Autore:');
      else
        $('#linkProfiloLabel').text('Pagina:');

      $('#motivoReport').val(td);

      //aggiungo evento click al pulsante ignora
      $('#btnIgnoraReportPost').click(function(){
        $.ajax({
          dataType: 'json',
          type: 'POST',
          url: '/admin/dashboard/ignoreReportPost',
          data: { id_report: recipient }
        }).done(function (data) {
          console.log(data);
          $('#labelStatus' + recipient).text('Esaminata').removeClass('badge-success').addClass('badge-secondary');
          toastr.success('La segnalazione è stata esaminata con successo.', 'Operazione completata!', { timeOut: 5000 });
        });
      });

      //evento rimuovi post
      $('#btnEliminaPost').click(function(){
        $.ajax({
          dataType: 'json',
          type: 'POST',
          url: '/admin/dashboard/deletePost',
          data: { id_report: recipient }
        }).done(function (data) {
          console.log(data.message);
          $('#labelStatus' + recipient).text('Esaminata').removeClass('badge-success').addClass('badge-secondary');
          //elimino la riga
          $('#reportRow' + recipient).remove();
          toastr.success('Il post è stato eliminato con successo.', data.message , { timeOut: 5000 });
        });
      });
    });


    
	});

  $('#detailModal').on('hide.bs.modal', function(event){
    //rimuovo gli eventi una volta che chiudo il modal
    $('#btnIgnoraReportPost').unbind();
    $('#btnEliminaPost').unbind();
  });


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
        console.log(data);


        //questo fa una cosa per ogni campo json
        //$.each(data, function(k, v){
        //  console.log(v);
        //});

        //posso accedere ai dati ritornati come ad un semplice oggetto
        console.log(data.titolo);
        console.log(data.descrizione);
    });

  }