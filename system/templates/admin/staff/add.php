{% extends 'includes/admin/default.php' %}

{% block title %} Add Staff {% endblock %}

{% block content %}

    <div class="col-md-4">

        <h3>Add Staff</h3>
        <br>

        {% include 'includes/validation_errors.php' %}

        <form action="{{urlFor('staff_add')}}" method="post">

            {% include 'includes/forms/staff.php' with {'add': true} %}

            <input type="hidden" name="csrf_token" value="{{csrf_token}}">

            <button type="submit" class="btn btn-default">Add Staff Member</button>

        </form>
    </div>

{% endblock %}