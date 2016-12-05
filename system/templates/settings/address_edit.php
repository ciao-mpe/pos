{% extends 'includes/default.php' %}

{% block title %} Edit Address {% endblock %}

{% block content %}

        {% include 'includes/validation_errors.php' %}

        <div class="row">
            <div class="col-md-5">

                <div class="panel panel-default">
                    <div class="panel-heading">
                     <h3 class="panel-title">Edit Address</h3>
                    </div>
                    <div class="panel-body">
                        <form action="{{urlFor('settings.address_edit', {'id' : address.id})}}" method="post">
                            {% include 'includes/forms/address.php' with {'loggedin': false} %}
                            <input type="hidden" name="csrf_token" value="{{csrf_token}}">
                            <button type="submit" class="btn btn-deafult">Edit</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    
{% endblock %}