{% extends 'includes/admin/default.php' %}

{% block title %} Edit Supplier {% endblock %}

{% block content %}

    <div class="col-md-4">

        <h3>Edit Supplier</h3>
        <br>

        {% include 'includes/validation_errors.php' %}

        <form action="{{urlFor('supplier_edit', {'id' : supplier.id})}}" method="post">

            {% include 'includes/forms/supplier.php' %}

            <input type="hidden" name="csrf_token" value="{{csrf_token}}">

            <button type="submit" class="btn btn-default">Edit Supplier</button>
            <a onclick="deleteConfirm()" href="#" class="btn btn-danger">Delete Supplier</a>

        </form>
    </div>

{% endblock %}

{% block footer %}
    <script type="text/javascript">
        function deleteConfirm(){
               var retVal = confirm("Aru you sure delete this supplier ?");
               if( retVal == true ){
                  window.location.href= "{{urlFor('supplier_delete', {'id' : supplier.id})}}";
               }
               return false;
            }
    </script>
{% endblock %}