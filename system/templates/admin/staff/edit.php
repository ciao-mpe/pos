{% extends 'includes/admin/default.php' %}

{% block title %} Edit Staff {% endblock %}

{% block content %}

    <div class="col-md-4">

        <h3>Edit Staff</h3>
        <br>

        {% include 'includes/validation_errors.php' %}

        <form action="{{urlFor('staff_edit', {'id' : user.id})}}" method="post">

            {% include 'includes/forms/staff.php' with {'add': false} %}

            <input type="hidden" name="csrf_token" value="{{csrf_token}}">

            <button type="submit" class="btn btn-default">Edit Staff Member</button>

            <a href="{{urlFor('staff_ban', {'id' : user.id})}}" class="btn {% if permission.banned %} btn-danger{%else%}btn-warning{%endif%}">{% if permission.banned %}UnBan{%else%}Ban{%endif%}</a>

        </form>
    </div>

{% endblock %}