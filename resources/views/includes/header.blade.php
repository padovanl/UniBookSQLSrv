
<div class="name" onclick="window.location='/';" style="cursor: pointer;">
    <div class="marcato">UNI</div>
    <div class="fino">BOOK</div>
</div>


<div class="middle-nav">
          <div class="growing-search">
            <div class="input">
              <input type="text" name="search" id="searchtext"/>
            </div><!-- Space hack -->
            <div class="submit">
              <button type="submit" id="search" name="go_search" onclick="window.location='/search?search_term=' + encodeURI(document.getElementById('searchtext').value)">
                <span class="fa fa-search"></span>
              </button>
            </div>
           </div>

    <div id="notifiche">
        <a href="{{url('friend/request')}}" id="navBarFriend">
            <span class="fa-stack fa-1x has-badge" id="spanNewFriend">
                <i class="fa fa-user fa-stack-1x fa-lg" aria-hidden="true"></i>
            </span>
        </a>
        <a href="/notification" id="navBarNotification">
            <span class="fa-stack fa-1x has-badge" id="spanNewNotifications">
                <i class="fa fa-bell fa-stack-1x fa-lg" aria-hidden="true"></i>
            </span>
        </a>
        <a href="/message" id="navBarMessages">
            <span class="fa-stack fa-1x has-badge" id="spanNewMessages">
                <i class="fa fa-commenting fa-stack-1x fa-lg" aria-hidden="true"></i>
            </span>
        </a>
    </div>
</div>


<a href="/profile/user/<?php echo "$logged_user->id_user" ?>">
    <div id="avatar">
    <div id="name-nav">{{$logged_user -> name . " " . $logged_user -> surname}}</div>
    <img src="{{$logged_user ->pic_path}}" alt="Avatar"></div>
</a>
