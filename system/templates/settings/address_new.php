{% extends 'includes/default.php' %}

{% block title %} New Address {% endblock %}

{% block content %}

        {% include 'includes/validation_errors.php' %}

        <div class="row">
            <div class="col-md-5">

                <div class="panel panel-default">
                    <div class="panel-heading">
                     <h3 class="panel-title">New Address</h3>
                    </div>
                    <div class="panel-body">
                        <form action="{{urlFor('settings.address_new')}}{% if return_url %}?return={{return_url}} {% endif %}" method="post">
                            {% include 'includes/forms/address.php' with {'loggedin': false} %}
                            <input type="hidden" name="csrf_token" value="{{csrf_token}}">
                            <button type="submit" class="btn btn-deafult">Submit</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    
{% endblock %}