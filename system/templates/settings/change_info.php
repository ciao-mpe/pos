{% extends return == true and permission.admin or permission.staff ? 'includes/admin/default.php' : 'includes/default.php' %}

{% block title %} Update My Details{% endblock %}

{% block content %}

        {% include 'includes/validation_errors.php' %}

        <div class="row">
            <div class="col-md-5">

                <div class="panel panel-default">
                    <div class="panel-heading">
                     <h3 class="panel-title">Update My Details</h3>
                    </div>
                    <div class="panel-body">
                        <form action="{{urlFor('settings.change_info')}}{% if return %}?return=admin{% endif %}" method="post">

                            <div class="form-group">
                                <label for="first_name">First Name :</label>
                                <input type="text" name="first_name" class="form-control" placeholder="First Name" value="{% if request.post('first_name') %}{{request.post('first_name')}}{% elseif info %}{{info.first_name}}{% endif %}">
                            </div>

                            <div class="form-group">
                                <label for="first_name">Last Name :</label>
                                <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="{% if request.post('last_name') %}{{request.post('last_name')}}{% elseif info %}{{info.last_name}}{% endif %}">
                            </div>

                            <div class="form-group">
                                <label for="email">Email :</label>
                                <input type="text" name="email" class="form-control" placeholder="email" value="{% if request.post('email') %}{{request.post('email')}}{% elseif info %}{{user.email}}{% endif %}" >
                            </div>

                            <hr>

                            <div class="form-group">
                                <label for="current_password">Current Password : </label>
                                <input type="password" name="current_password" class="form-control" placeholder="Current Password">
                            </div>

                            <input type="hidden" name="csrf_token" value="{{csrf_token}}">
                            <button type="submit" class="btn btn-deafult">Update</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    
{% endblock %}