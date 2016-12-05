{% extends 'includes/admin/default.php' %}

{% block title %} Add Supplier {% endblock %}

{% block content %}

    <div class="col-md-4">

        <h3>Add Supplier</h3>
        <br>

        {% include 'includes/validation_errors.php' %}

        <form action="{{urlFor('supplier_add')}}" method="post">

            {% include 'includes/forms/supplier.php' %}

            <input type="hidden" name="csrf_token" value="{{csrf_token}}">

            <button type="submit" class="btn btn-default">Add Supplier</button>

        </form>
    </div>

{% endblock %}