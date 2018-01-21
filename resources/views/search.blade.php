@extends('layouts.app')

@section('content')

<div class="row">

  <div class="col-xs-12">
    <br>

    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="pills-users-tab" data-toggle="pill" href="#pills-users" role="tab" aria-controls="pills-users" aria-selected="true">Utenti</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="pills-page-tab" data-toggle="pill" href="#pills-page" role="tab" aria-controls="pills-page" aria-selected="false">Pagine</a>
      </li>
    </ul>
    <br>
    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="pills-users" role="tabpanel" aria-labelledby="pills-users-tab">
        <div class="pre-scrollable">
          <!-- Utenti -->
          <div class="panel panel-default" id="user">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-10">
                        <div class="media">
                          <div class="media-left">
                            <a id="link_img" href="#">
                              <img id="user_pic" class="photo-profile" src="/assets/images/facebook3.jpeg" alt="..." style="border-radius: 50%;" width="40" height="40">
                            </a>
                            <a href="#" id="fullname" class="anchor-username"> &nbsp; Name Surname</a>
                            <p></p>
                            <p><small id="user-desc" ></small> <small><i class="fa fa-birthday-cake"></i></small></p>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>

        <center>
          <button id="more_user" class="button btn-primary" style="border-radius: 2em;" OnClick="loadOlderUser();">Carica altri utenti</button>
          <p id="no_results">Non sono stati trovati utenti con <b class="text-primary">"<?= $search_term; ?>"</b>.</p>
        </center>

      </div>
      <div class="tab-pane fade" id="pills-page" role="tabpanel" aria-labelledby="pills-page-tab">
        <div class="pre-scrollable-page">
          <!-- Pagine -->
          <div class="panel panel-default" id="page">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-10">
                        <div class="media">
                          <div class="media-left">
                            <a id="link_img" href="#">
                              <img id="page_pic" class="photo-profile" src="/assets/images/facebook3.jpeg" alt="..." style="border-radius: 50%;" width="40" height="40">
                            </a>
                            <a href="#" id="name" class="anchor-username"> &nbsp; Name</a>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>

        <center>
          <button id="more_page" class="button btn-primary" style="border-radius: 2em;" OnClick="loadOlderPage();">Carica altre pagine</button>
          <p id="no_results_page">Non sono state trovate pagine con <b class="text-primary">"<?= $search_term; ?>"</b>.</p>
        </center>
      </div>
    </div>

    <br>
    <br>

  </div>

</div>

 <style>
    .pre-scrollable {
        max-height: 670px;
        overflow-y: scroll;
        overflow-x: hidden;
    }
    .pre-scrollable-page {
        max-height: 670px;
        overflow-y: scroll;
        overflow-x: hidden;
    }
</style>

<script>

search_term = '<?= $search_term ?>';
user_counter = 0;
page_counter = 0;

function createUser(data) {

  if (data == null)
    return;

  user_clone = $("#user").clone();

  user_clone.attr("id", "user_" + data.id_user);
  user_clone.find("#user_pic").attr("src", (data.pic_path[0] == "/" ? "" : "/") + data.pic_path);
  user_clone.find("#link_img").attr("href", "/profile/user/" + data.id_user);
  user_clone.find("#fullname").html(" &nbsp; " + data.name + " " + data.surname);
  user_clone.find("#fullname").attr("href", "/profile/user/" + data.id_user);

  var dateString = "";

  if (data.birth_date != null) {
    dateString = (data.birth_date).split('-');
    dateString = dateString[2] + "/" + dateString[1] + "/" + dateString[0];
  }
  user_clone.find("#user-desc").html("Abita a <b>" + data.citta + "</b>, nato/a il " + dateString + " &nbsp;");

  return(user_clone);
}

function createPage(data) {

  if (data == null)
    return;

  page_clone = $("#page").clone();

  page_clone.attr("id", "page_" + data.id_page);
  page_clone.find("#page_pic").attr("src", (data.pic_path[0] == "/" ? "" : "/") + data.pic_path);
  page_clone.find("#link_img").attr("href", "/profile/page/" + data.id_page);
  page_clone.find("#name").html(" &nbsp; " + data.name);
  page_clone.find("#name").attr("href", "/profile/page/" + data.id_page);

  return(page_clone);
}

function onLoad(data, type) {
  $("#user").hide();
  $("#page").hide();

  if (data != "No results" && data != null) {

    if (type == "user") {
      for(var i = 0; i < data.length; i++)
      {
        user_clone = createUser(data[i]);
        user_clone.insertBefore("#user");
        user_clone.show();
      }
      user_counter += data.length;
    }
    else {
      for(var i = 0; i < data.length; i++)
      {
        page_clone = createPage(data[i]);
        page_clone.insertBefore("#page");
        page_clone.show();
      }
      page_counter += data.length;
    }

  }
  else {
    if (type == "user") {
      $("#more_user").hide();
      $("#no_results").show();
    }
    else {
      $("#more_page").hide();
      $("#no_results_page").show();
    }
  }

}

function loadOlderUser() {

  let prev_user = $("#user").prev();
  user_id = prev_user.attr("id").split("_")[1];

  $.ajax({
    method: "GET",
    url: "/searchUsers?search_term=" + encodeURI(search_term),
    data: {
      take: 5,
      skip: user_counter
    },
    dataType : "json",
    success : function (users)
    {
      if (users.length != 0 && users != "No results")
      {
        for (var x = 0; x < users.length; x++)
        {
          user_clone = createUser(users[x]);
          user_clone.insertAfter("#user_" + user_id);
          user_clone.show();
        }
        user_counter += users.length;

      }
      else
        $("#more_user").text("Non ci sono più utenti!");

    }
  })
}

function loadOlderPage() {

  let prev_page = $("#page").prev();
  page_id = prev_page.attr("id").split("_")[1];

  $.ajax({
    method: "GET",
    url: "/searchPages?search_term=" + encodeURI(search_term),
    data: {
      take: 5,
      skip: page_counter
    },
    dataType : "json",
    success : function (pages)
    {
      if (pages.length != 0 && pages != "No results")
      {
        for (var x = 0; x < pages.length; x++)
        {
          page_clone = createPage(pages[x]);
          page_clone.insertAfter("#page_" + page_id);
          page_clone.show();
        }
        page_counter += pages.length;

      }
      else
        $("#more_page").text("Non ci sono più pagine!");

    }
  })
}


//Caricamento degli utenti
$(document).ready(function(){

  $("#no_results").hide();
  $("#no_results_page").hide();

  $.ajax({
      url : "/searchUsers?search_term=" + encodeURI(search_term),
      method : "GET",
      dataType : "json",
      success: function(users) {
        onLoad(users, "user");
      }
  });

  $.ajax({
      url : "/searchPages?search_term=" + encodeURI(search_term),
      method : "GET",
      dataType : "json",
      success: function(pages) {
        onLoad(pages, "page");
      }
  });

});

</script>

@endsection
