@extends('layouts.app')

@section('content')



<article>
	<div class="container-full">
		<div class="row">
			<div class="col-md-12">
				<div class="list-group" id="sidebar">
		        <a href="#" onclick="ChangeChat(4)" class="list-group-item listMessagesLink" id="messages">
		          <div class="row">
		              <div class="col-md-2">
		                  <img src="" alt="Avatar" width="50" height="50">
		              </div>
		              <div class="col-md-10">
		                <div  class="row">
		                  <div class="col-md-10">
		                    <p>aaaa</p>
		                  </div>
		                  <div class="col-md-2">
		                      <span class="badge badge-danger" id="newMessage">aaaaaaaaaaaaa</span>
		                  </div>
		                </div>

		                  <p>aaaaaaaaaa</p>
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
