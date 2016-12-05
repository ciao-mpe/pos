<div class="form-group">
    <label for="first_name">First Name :</label>
    <input type="text" name="first_name" class="form-control" placeholder="First Name" value="{% if request.post('first_name') %}{{request.post('first_name')}}{% elseif staff %}{{staff.first_name}}{% endif %}">
</div>

<div class="form-group">
    <label for="first_name">Last Name :</label>
    <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="{% if request.post('last_name') %}{{request.post('last_name')}}{% elseif staff %}{{staff.last_name}}{% endif %}">
</div>

<div class="form-group">
    <label for="email">Email :</label>
    <input type="text" name="email" class="form-control" placeholder="email" value="{% if request.post('email') %}{{request.post('email')}}{% elseif staff %}{{user.email}}{% endif %}">
</div>

{% if add %}
<div class="form-group">
    <label for="password">Password : </label>
    <input type="text" name="password" class="form-control" placeholder="Password" value="{{randomPassowrd}}">
</div>
{% endif %}