{% extends 'includes/admin/default.php' %}

{% block title %} Edit - {{product.title}} {% endblock %}

{% block content %}

    <div class="col-md-4">

        <h3>Product Edit</h3>
        <br>

        {% include 'includes/validation_errors.php' %}

        <form action="{{urlFor('product_edit', {'id' : product.id})}}" method="post" enctype="multipart/form-data">
            
            {% include 'includes/forms/product.php' %}
            
            <input type="hidden" name="csrf_token" value="{{csrf_token}}">

            <button type="submit" class="btn btn-default">Edit Product</button>
            <a onclick="deleteConfirm()" href="#" class="btn btn-danger">Delete Product</a>

        </form>
    </div>
    
    {% if product.image %}
    <div class="col-md-3">
         <div class="panel panel-default">
            <div class="panel-heading">Product Image</div>
            <div class="panel-body">
                <img src="{{images}}/products/{{product.image}}.jpeg" style="max-width: 150px">
            </div>
        </div>
    </div> 
    {% endif %} 

{% endblock %}

{% block footer %}
    <script type="text/javascript">
        function deleteConfirm(){
               var retVal = confirm("Aru you sure delete this product ?");
               if( retVal == true ){
                  window.location.href= "{{urlFor('product_delete', {'id' : product.id})}}";
               }
               return false;
            }
    </script>
{% endblock %}