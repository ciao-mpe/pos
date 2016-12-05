{% extends 'includes/default.php' %}

{% block title %} Reset password{% endblock %}

{% block content %}

    <div class="col-md-4">

        <h3>Reset Password</h3>
        <br>

        {% include 'includes/validation_errors.php' %}

        <form action="{{urlFor('reset', {'token' : token})}}" method="post">

            {% include 'includes/forms/password.php'%}

            <input type="hidden" name="csrf_token" value="{{csrf_token}}">

            <button type="submit" class="btn btn-default">Reset</button>

        </form>
    </div>

{% endblock %}