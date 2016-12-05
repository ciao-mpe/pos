{% extends 'includes/default.php' %}

{% block title %} Forget you password ? {% endblock %}

{% block content %}

    <div class="col-md-4">

        <h3>Forget Password ?</h3>
        <br>

        <form action="{{urlFor('forget')}}" method="post">

            <div class="form-group">
                <label for="email">Email :</label>
                <input type="text" name="email" class="form-control" placeholder="Email">
            </div>

            <input type="hidden" name="csrf_token" value="{{csrf_token}}">

            <button type="submit" class="btn btn-default">Submit</button>

        </form>
    </div>

{% endblock %}