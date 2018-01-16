
//SEGNALAZIONI POST
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
    $('#btnViewPost').attr('onclick', 'window.location="/post/details/' + data.id_post + '";')
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
        getPage(currentPage);
        toastr.success('La segnalazione è stata esaminata con successo.', 'Operazione completata!', { timeOut: 5000 });
      });
    });

    //evento rimuovi post
    $('#btnEliminaPost').click(function(){
      $.ajax({
        dataType: 'json',
        type: 'POST',
        url: '/admin/dashboard/deletePost',
        data: { id_report: recipient, ban: 0 }
      }).done(function (data) {
        console.log(data.message);
        $('#labelStatus' + recipient).text('Esaminata').removeClass('badge-success').addClass('badge-secondary');
        //elimino la riga
        $('#reportRow' + recipient).remove();
        getPage(currentPage);
        toastr.success('Il post è stato eliminato con successo. Sono state eliminate anche le altre segnalazioni relative a questo post.', data.message , { timeOut: 5000 });
      });
    });

  //evento rimuovi e ban 
  $('#btnEliminaBanPost').click(function(){
      $.ajax({
        dataType: 'json',
        type: 'POST',
        url: '/admin/dashboard/deletePost',
        data: { id_report: recipient, ban : 1 }
      }).done(function (data) {
        console.log(data.message);
        $('#labelStatus' + recipient).text('Esaminata').removeClass('badge-success').addClass('badge-secondary');
        //elimino la riga
        $('#reportRow' + recipient).remove();
        getPage(currentPage);
        toastr.success('Il post è stato eliminato con successo e l\'autore è stato bannato e non potrà scrivere su UniBook. Sono state eliminate anche le altre segnalazioni relative a questo post.', data.message , { timeOut: 5000 });
      });
    });
  });
});

$('#detailModal').on('hide.bs.modal', function(event){
  //rimuovo gli eventi una volta che chiudo il modal
  $('#btnIgnoraReportPost').unbind();
  $('#btnEliminaPost').unbind();
  $('#btnEliminaBanPost').unbind();
});

//FINE SEGNALAZIONI POST


$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

