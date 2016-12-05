{% extends 'includes/admin/default.php' %}

{% block title %} Add Product {% endblock %}

{% block content %}

    <div class="col-md-4">

        <h3>Product Add</h3>
        <br>

        {% include 'includes/validation_errors.php' %}

        <form action="{{urlFor('product_add')}}" method="post" enctype="multipart/form-data">

            {% include 'includes/forms/product.php' %}
            
            <input type="hidden" name="csrf_token" value="{{csrf_token}}">

            <button type="submit" class="btn btn-default">Add Product</button>

        </form>
    </div>

{% endblock %}