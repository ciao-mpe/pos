{% extends return == true and permission.admin or permission.staff ? 'includes/admin/default.php' : 'includes/default.php' %}

{% block title %} Edit Address {% endblock %}

{% block content %}

        {% include 'includes/validation_errors.php' %}

        <div class="row">
            <div class="col-md-5">

                <div class="panel panel-default">
                    <div class="panel-heading">
                     <h3 class="panel-title">Change Passoword</h3>
                    </div>
                    <div class="panel-body">
                        <form action="{{urlFor('settings.change_password')}}{% if return %}?return=admin{% endif %}" method="post">

                            {% include 'includes/forms/password.php' %}

                            <div class="form-group">
                                <label for="current_password">Current Password : </label>
                                <input type="password" name="current_password" class="form-control" placeholder="Current Password">
                            </div>

                            <input type="hidden" name="csrf_token" value="{{csrf_token}}">
                            <button type="submit" class="btn btn-deafult">Change</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    
{% endblock %}