@extends('layouts.app')

@section('content')



<article>
	<div class="container-full">
		@foreach($notifications as $n)
		<div class="row">
			<div class="col-md-12">
				<div class="list-group" id="sidebar">
		        <a href="{{$n->link}}" class="list-group-item listMessagesLink" id="messages">
		          <div class="row">
		              <div class="col-md-2">
		                  <img src="{{$n->picPath}}" alt="Avatar" width="50" height="50" style="border-radius: 50%;">
		              </div>
		              <div class="col-md-10">
		                  <div class="col-md-11">
		                  	<p>{{$n->content}}</p>
		                  </div>
		                  <div class="col-md-1">
		                  	@if($n->new)
		                      <img src="{{asset('assets/img/puntoEsclamativo.png')}}" width="20px" height="20px">
		                    @endif
		                  </div>
		              </div>
		          </div>
		        </a>
		      </div> 
			</div>
		</div>
		@endforeach
	</div>
</article>
<aside class="side">
   <div class="pre-scrollable">
      <div class="list-group" id="sidebar">
       
      </div> 
    </div>
</aside>



  

@endsection
