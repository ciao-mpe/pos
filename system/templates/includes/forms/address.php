<div class="form-group">
    <label for="address1">Address line 1 :</label>
    <input type="text" name="address1" class="form-control" placeholder="Address line 1" value="{% if request.post('address1') %}{{request.post('address1')}}{% elseif address %}{{address.address1}}{% endif %}" {% if loggedin %} readonly {% endif %} id="address1">
</div>

<div class="form-group">
    <label for="address2">Address line 2 :</label>
    <input type="text" name="address2" class="form-control" placeholder="Address line 2" value="{% if request.post('address2') %}{{request.post('address2')}}{% elseif address %}{{address.address2}}{% endif %}" {% if loggedin %} readonly {% endif %} id="address2">
</div>

<div class="form-group">
    <label for="city">City :</label>
    <input type="text" name="city" class="form-control" placeholder="City" value="{% if request.post('city') %}{{request.post('city')}}{% elseif address %}{{address.city}}{% endif %}" {% if loggedin %} readonly {% endif %} id="city">
</div>

<div class="form-group">
    <label for="postal_code">Postal Code :</label>
    <input type="text" name="postal_code" class="form-control" placeholder="Postal Code" value="{% if request.post('postal_code') %}{{request.post('postal_code')}}{% elseif address %}{{address.postal_code}}{% endif %}" {% if loggedin %} readonly {% endif %} id="zip">
</div>

 <div class="form-group">
    <label for="telephone">Telephone :</label>
    <input type="text" name="telephone" class="form-control" placeholder="Telephone" value="{% if request.post('telephone') %}{{request.post('telephone')}}{% elseif address %}{{address.telephone}}{% endif %}" {% if loggedin %} readonly {% endif %} id="telephone">
</div>