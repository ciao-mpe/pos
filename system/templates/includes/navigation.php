<nav class="navbar navbar-default">

  <div class="container-fluid">

    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Zeus (PVT) LTD</a>
    </div>

    <div id="navbar" class="navbar-collapse collapse">

      <ul class="nav navbar-nav">
        <li><a href="{{urlFor('home')}}">Home</a></li>
        {% if auth and customer %}
           <li><a href="{{urlFor('order_all')}}">My Orders</a></li>
        {% endif %}
      </ul>

      <ul class="nav navbar-nav navbar-right">
         <li><a href="{{urlFor('cart')}}"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Cart ({{basket.count}})</a></li>
        {% if not auth %}
        <li><a href="{{urlFor('login')}}">Login</a></li>
        <li><a href="{{urlFor('forget')}}">Forgot password ?</a></li>
        {% else %}
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Settings<span class="caret"></span></a>
            <ul class="dropdown-menu">
              {% if customer %}
                <li><a href="{{urlFor('settings.address_all')}}">My Addresses</a></li>
              {% endif %}
                <li><a href="{{urlFor('settings.change_password')}}">Change Password</a></li>
                <li><a href="{{urlFor('settings.change_info')}}">Update My Account</a></li>
                <li><a href="{{urlFor('logout')}}">Logout</a></li>
            </ul>
          </li>
        {% endif %}
      </ul>

    </div><!--/.nav-collapse -->

  </div>

</nav>
