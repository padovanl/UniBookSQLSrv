@extends('layouts.app')

@section('content')
    <article class="content">
        <div class="container-full">
            <br/>
            <div class="container_pages">
                <div id="pageContainer">
                    @if(count($userspages) > 0)
                        @foreach($userspages as $u)
                            <a href="/profile/page/{{$u->id_page}}">

                                <div class="page_index" id="{{$u->id_page}}" >
                                    <div >
                                        <img class="img_friends" src="{{$u->pic_path}}">
                                    </div>
                                    <div class="page_index_name">
                                        <p>{{$u->name}}</p>
                                    </div>
                                </div>
                                <br id='br{{$u->id_page}}'/>

                            </a>
                        @endforeach
                    @else
                        <div class="page_alert" role="alert" >
                            <strong>Al momento non hai nessuna pagina.</strong>
                        </div>
                    @endif
                    <div>
                        <button type="button" class="button btn-primary" data-toggle="modal" data-target="#newPageModal">
                            Crea pagina
                        </button>
                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
    </article>


    <!-- new page modal -->
    <form action="{{ route('createPage') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal fade bd-example-modal-lg" id="newPageModal" tabindex="-1" role="dialog"
             aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="titleReportComment">Crea nuova pagina</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group row">
                            <label for="nomePagina" class="col-sm-2 col-form-label">Nome:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nomePagina" name="nomePagina" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="profilePic" class="col-sm-5 col-form-label">Immagine della pagina:</label>
                            <div class="image-upload">
                                <label for="image">
                                    <img src="/assets/img/profilo.png" id="profilePic" width="250px"
                                         height="250px"/>
                                </label>

                                <input name="image" id="image" type="file" onchange="readURL(this);"/>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div>
                            <div class="modal_buttons">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                                <button type="submit" class="btn btn-primary" id="btnCreatePage">Crea</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>



    <script>

        $('#btnTimeline').addClass('btn-border');
        $('#btnMessage').addClass('btn-border');
        $('#btnAdmin').addClass('btn-border');
        $('#btnLogout').addClass('btn-border');
        $('#btnPage').removeClass('btn-border');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $("body").on("click", "#btnCreatePage", function (e) {
            $(this).parents("form").ajaxForm(options);
        });


        var options = {
            complete: function (response) {
                if ($.isEmptyObject(response.responseJSON.error)) {
                    $("input[name='title']").val('');
                    alert('Image Upload Successfully.');
                } else {
                    printErrorMsg(response.responseJSON.error);
                }
            }
        };


    </script>

    <style type="text/css">
        .image-upload > input {
            display: none;
        }

        img:hover {
            cursor: pointer;
        }
    </style>



    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#profilePic')
                        .attr('src', e.target.result)
                        .width(300)
                        .height(300);
                };

                reader.readAsDataURL(input.files[0]);

                showFileSize();
            }
        }

        function showFileSize() {
            var input, file;
            input = document.getElementById('image');
                file = input.files[0]; console.log(file);
                var filesizeMb = file.size/1024/1024;
                if(filesizeMb >= 2.0){
                    alert('La dimensione dell\'immagine del profilo non deve superare i 2MB');
                    $('#btnCreatePage').prop('disabled', true);
                }
                else{
                    $('#btnCreatePage').prop('disabled', false);
                }
        }

    </script>


@endsection
