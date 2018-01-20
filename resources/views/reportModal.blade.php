<!--Report post modal-->
<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Segnala post</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-body-post">
                <div class="form-group">
                    <label for="reasonReportPost">Selezione il motivo della segnalazione:</label>
                    <select class="form-control" id="reasonReportPost">
                        <option selected>Incita all'odio</option>
                        <option>È una minaccia</option>
                        <option>È una notizia falsa</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-5">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                </div>
                <div class="col-md-5">
                    <button type="button" class="btn btn-primary" id="btnReportPost">Segnala</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!--Report comment modal-->
<div class="modal fade" id="reportComment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Segnala commento</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-body-comment">
                <div class="form-group">
                    <label for="reasonReportComment">Selezione il motivo della segnalazione:</label>
                    <select class="form-control" id="reasonReportComment">
                        <option selected>Incita all'odio</option>
                        <option>È una minaccia</option>
                        <option>È una notizia falsa</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-5">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                </div>
                <div class="col-md-5">
                    <button type="button" class="btn btn-primary" id="btnReportComment">Segnala</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#reportModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        $('#btnReportPost').click(function () {
            var motivo = $('#reasonReportPost').find(":selected").text();
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: '/home/reportPost',
                data: {id_post: recipient, motivo: motivo}
            }).done(function (data) {
                var html = '<h3>La segnalazione è stata inviata con successo agli amministratori di UniBook, grazie per la tua collaborazione!</h3>';
                $('#modal-body-post').html(html);
                $('#btnReportPost').hide();
            });
        });


        var modal = $(this);
        modal.find('.modal-title').text('Segnala post');
    });

    $('#reportModal').on('hidden.bs.modal', function (event) {
        //rimuovo gli eventi una volta che chiudo il modal
        $('#btnReportPost').unbind();
        $('#btnReportPost').show();
        var html = '<div class="form-group">';
        html += ' <label for="reasonReportPost">Selezione il motivo della segnalazione:</label>';
        html += ' <select class="form-control" id="reasonReportPost">';
        html += '   <option selected>Incita all\'odio</option>';
        html += '   <option>È una minaccia</option>';
        html += '   <option>È una notizia falsa</option>';
        html += ' </select>';
        html += '</div>';
        $('#modal-body-post').html(html);
    });

    $('#reportComment').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        $('#btnReportComment').click(function () {
            var motivo = $('#reasonReportComment').find(":selected").text();
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: '/home/reportComment',
                data: {id_comment: recipient, motivo: motivo}
            }).done(function (data) {
                var html = '<h3>La segnalazione è stata inviata con successo agli amministratori di UniBook, grazie per la tua collaborazione!</h3>';
                $('#modal-body-comment').html(html);
                $('#btnReportComment').hide();
            });
        });


        var modal = $(this);
        modal.find('.modal-title').text('Segnala commento');
    });

    $('#reportComment').on('hidden.bs.modal', function (event) {
        //rimuovo gli eventi una volta che chiudo il modal
        $('#btnReportComment').unbind();
        $('#btnReportComment').show();
        var html = '<div class="form-group">';
        html += ' <label for="reasonReportComment">Selezione il motivo della segnalazione:</label>';
        html += ' <select class="form-control" id="reasonReportComment">';
        html += '   <option selected>Incita all\'odio</option>';
        html += '   <option>È una minaccia</option>';
        html += '   <option>È una notizia falsa</option>';
        html += ' </select>';
        html += '</div>';
        $('#modal-body-comment').html(html);
    });
</script>
