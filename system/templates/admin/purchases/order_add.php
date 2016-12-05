{% extends 'includes/admin/default.php' %}

{% block title %} Purchase Order Add Product{% endblock %}

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
          
        {% if product.quantity > 0 %} 

          <form action="{{urlFor('admin_purchases_order_add', {id: product.id})}}" method="post">
            <div class="form-group">
                <label for="quantity">Quantity : </label>
                <input type="number" min="1" name="quantity" class="form-control input-sm" value="{{product.reorder}}">
            </div>
            <input type="hidden" name="csrf_token" value="{{csrf_token}}">
            <button class="btn btn-success">
                {% if update %}
                    Update Cart
                {% else %}
                    Add to Purchase order
                {% endif %}
            </button>
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