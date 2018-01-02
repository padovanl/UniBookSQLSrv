
@foreach($reports as $r)
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

