@extends('layouts.app')

@section('content')



<article>
	<div class="container-full">
		<div class="row">
			<div class="col-md-12">
				<div class="list-group" id="sidebar">
		        <a href="/post/details/441" onclick="ChangeChat(4)" class="list-group-item listMessagesLink" id="messages">
		          <div class="row">
		              <div class="col-md-2">
		                  <img src="../../assets/images/facebook1.jpg" alt="Avatar" width="50" height="50" style="border-radius: 50%;">
		              </div>
		              <div class="col-md-10">
		                  <div class="col-md-11">
		                  	<p>Edyth Hermiston ha messo mi piace al tuo post.</p>
		                  </div>
		                  <div class="col-md-1">
		                      <img src="../../assets/img/puntoEsclamativo.png" width="20px" height="20px">
		                  </div>
		              </div>
		          </div>
		        </a>
		      </div> 
			</div>
		</div>
	</div>
</article>
<aside class="side">
   <div class="pre-scrollable">
      <div class="list-group" id="sidebar">
       
      </div> 
    </div>
</aside>



  

@endsection
