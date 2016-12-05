{% extends 'includes/admin/default.php' %}

{% block title %} Add Customer {% endblock %}

{% block content %}

    <div class="col-md-4">

        <h3>Edit Customer</h3>
        <br>

        {% include 'includes/validation_errors.php' %}

        <form action="{{urlFor('customer_edit', {'id' : customer.id})}}" method="post">

            {% include 'includes/forms/customer.php' with {'loggedin': false} %}

            <input type="hidden" name="csrf_token" value="{{csrf_token}}">

            <button type="submit" class="btn btn-default">Edit Customer</button>
            
            <a href="{{urlFor('customer_ban', {'id' : user.id})}}" class="btn {% if permission.banned %} btn-danger{%else%}btn-warning{%endif%}">{% if permission.banned %}UnBan{%else%}Ban{%endif%}</a>

            <a onclick="deleteConfirm()" href="#" class="btn btn-danger">Delete Customer</a>

        </form>
    </div>

{% endblock %}

{% block footer %}
    <script type="text/javascript">
        function deleteConfirm(){
               var retVal = confirm("Aru you sure delete this customer ?");
               if( retVal == true ){
                  window.location.href= "{{urlFor('customer_delete', {'id' : user.id})}}";
               }
               return false;
            }
    </script>
{% endblock %}