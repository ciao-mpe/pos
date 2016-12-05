<div class="form-group">
    <label for="first_name">First Name :</label>
    <input type="text" name="first_name" class="form-control" placeholder="First Name" value="{% if request.post('first_name') %}{{request.post('first_name')}}{% elseif customer %}{{customer.first_name}}{% endif %}" {% if loggedin %} readonly {% endif %}>
</div>

<div class="form-group">
    <label for="first_name">Last Name :</label>
    <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="{% if request.post('last_name') %}{{request.post('last_name')}}{% elseif customer %}{{customer.last_name}}{% endif %}" {% if loggedin %} readonly {% endif %}>
</div>

<div class="form-group">
    <label for="email">Email :</label>
    <input type="text" name="email" class="form-control" placeholder="email" value="{% if request.post('email') %}{{request.post('email')}}{% elseif customer %}{{user.email}}{% endif %}" {% if loggedin %} readonly {% endif %}>
</div>