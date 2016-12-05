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

        <li><a href="{{urlFor('admin_home')}}">Home</a></li>

        <li><a href="{{urlFor('customer_all')}}">Customers</a></li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Products<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="{{urlFor('product_add')}}">Add Product</a></li>
              <li><a href="{{urlFor('product_all')}}">All Products</a></li>
            </ul>
        </li>

        <li><a href="{{urlFor('admin_orders')}}">Orders</a></li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Staff<span class="caret"></span></a>
             <ul class="dropdown-menu">
              <li><a href="{{urlFor('staff_add')}}">Add Staff Member</a></li>
              <li><a href="{{urlFor('staff_all')}}">Manage Staff</a></li>
            </ul>
        </li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Suppliers<span class="caret"></span></a>
             <ul class="dropdown-menu">
              <li><a href="{{urlFor('supplier_add')}}">Add Supplier</a></li>
              <li><a href="{{urlFor('supplier_all')}}">Manage Suppliers</a></li>
            </ul>
        </li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Purchases<span class="caret"></span></a>
             <ul class="dropdown-menu">
              <li><a href="{{urlFor('admin_purchases_order')}}">New Purchase Order</a></li>
              <li><a href="{{urlFor('admin_purchases')}}">All Purchase Orders</a></li>
            </ul>
        </li>

      </ul>

      <ul class="nav navbar-nav navbar-right">
        {% if not auth %}
        <li><a href="{{urlFor('login')}}">Login</a></li>
        <li><a href="{{urlFor('forget')}}">Forgot password ?</a></li>
        {% else %}
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Settings<span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="{{urlFor('settings.change_password')}}?return=admin">Change Password</a></li>
                <li><a href="{{urlFor('settings.change_info')}}?return=admin">Update My Account</a></li>
                <li><a href="{{urlFor('logout')}}">Logout</a></li>
            </ul>
          </li>
        {% endif %}
      </ul>

    </div><!--/.nav-collapse -->

  </div>

</nav>
