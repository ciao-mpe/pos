{% extends 'includes/default.php' %}

{% block title %} Login {% endblock %}

{% block content %}

    <div class="col-md-4">
        <h3>Login</h3>
        <form action="{{urlFor('login')}}" method="post">

            {% include 'includes/forms/user.php'%}
            
            <input type="hidden" name="csrf_token" value="{{csrf_token}}">

            <button type="submit" class="btn btn-default">Login</button>
        </form>
    </div>

{% endblock %}