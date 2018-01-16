@extends('layouts.app')

@section('content')
<article>
	<div class="container-full">
	  <br />
	  <div class="row">
	    <div class="col-md-1"></div>
	    <div class="col-md-10" id="pageContainer">
	      @if(count($userspages) > 0)
	        @foreach($userspages as $u)
	          <div id="{{$u->id_page}}" class="row" style="border-style: solid; border-width: 1px; border-color: #008CBA; border-radius: 25px; padding: 10px;">
	            <div class="col-md-1">
	              <img src="/{{$u->pic_path}}" height="55px" width="55px" style="border-radius: 50%;">
	            </div>
	            <div class="col-md-9" style="display: flex; align-items: center;">
	              <p>{{$u->name}}</p>
	            </div>
	            <div class="col-md-2">
	            </div>
	          </div>
	          <br id='br{{$u->id_page}}'/>
	        @endforeach
	      @else
	        <div class="alert alert-success" role="alert" style="text-align: center;">
	          <strong>Al momento non hai nessuna pagina.</strong>
	        </div>
	      @endif
	       <div style="text-align: center;">
	          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newPageModal">Crea una nuova pagina</button>
	        </div>
	    </div>
	    <div class="col-md-1"></div>
	  </div>
	</div>
</article>
<!--<aside class="side">
   <div class="pre-scrollable">
      <div class="list-group" id="sidebar">

      </div>
    </div>
</aside>-->


<!-- new page modal -->
<form action="{{ route('createPage') }}" method="POST" enctype="multipart/form-data">
 	{{ csrf_field() }}
	<div class="modal fade bd-example-modal-lg" id="newPageModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
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
					        <img src="../../assets/img/profilo.png" id="profilePic" width="250px" height="250px" />
					    </label>

					    <input name="image" id="image" type="file" onchange="readURL(this);" />
					</div>
				  </div>

	      </div>
	      <div class="modal-footer">
	         <div class="row">
	          <div class="col-md-12">
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


  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });




    $("body").on("click","#btnCreatePage",function(e){
	    $(this).parents("form").ajaxForm(options);
	});


  var options = {
    complete: function(response){
		    	if($.isEmptyObject(response.responseJSON.error)){
		    		$("input[name='title']").val('');
		    		alert('Image Upload Successfully.');
		    	}else{
		    		printErrorMsg(response.responseJSON.error);
		    	}
		    }
  };


</script>

<style type="text/css">
	.image-upload > input
	{
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
    }
}

</script>


@endsection
