{% extends 'includes/default.php' %}

{% block title %} {{product.title}} {% endblock %}

{% block content %}

<div class="row">
      <div class="col-md-4 col-sm-6">
        {% if product.image %}
          <img src="{{images}}/products/{{product.image}}.jpeg" class="thumbnail img-responsive">
        {% else %}
          <img src="{{images}}/not_found.jpg" class="img-thumbnail">
        {% endif %}
      </div>

      <div class="col-md-8 col-sm-6">
        
        {% if product.quantity > 10 %} 
          <span class="label label-success">In Stock</span>
        {% elseif product.quantity > 0 and product.quantity <= 10 %}
          <span class="label label-warning">Limited Stock</span>
        {% elseif  product.quantity == 0 %}
          <span class="label label-danger">Outof Stock</span>
        {% endif %}

        <h2>{{product.title}}</h2>
        <p>{{product.description | length > 200 ? product.description|slice(0, 200) ~ '...' : product.description}}</p>
          
        {% if product.quantity > 0 %} 

          <form action="{{urlFor('cart_add', {slug: product.slug})}}" method="post">
            <div class="form-group">
                <label for="quantity">Quantity : </label>
                <input type="number" min="1" name="quantity" class="form-control input-sm" value="1">
            </div>
            <input type="hidden" name="csrf_token" value="{{csrf_token}}">
            <button class="btn btn-success"> <i class="glyphicon glyphicon-shopping-cart"></i> Add to cart</button>
          </form>

        {% endif %}

      </div>
</div>

<br><br> 

<div class="row">
  <div class="col-xs-12">
    <div class="panel panel-default">
      <div class="panel-heading">Product Description</div>
        <div class="panel-body">
            <p>{{product.description}}</p>
        </div>
      </div>
  </div>
</div>


{% endblock %}