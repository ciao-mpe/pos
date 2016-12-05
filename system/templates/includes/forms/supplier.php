<div class="form-group">
    <label for="compant_name">Company Name :</label>
    <input type="text" name="company_name" class="form-control" placeholder="Company Name" value="{% if request.post('company_name') %}{{request.post('company_name')}}{% elseif supplier %}{{supplier.company_name}}{% endif %}">
</div>

<div class="form-group">
    <label for="email">Company Email :</label>
    <input type="text" name="email" class="form-control" placeholder="Company Email" value="{% if request.post('email') %}{{request.post('email')}}{% elseif supplier %}{{supplier.email}}{% endif %}">
</div>

<div class="form-group">
    <label for="address">Company Address :</label>
    <textarea name="address" class="form-control" placeholder="Company Address">{% if request.post('address') %}{{request.post('address')}}{% elseif supplier %}{{supplier.address}}{% endif %}</textarea>
</div>

<div class="form-group">
    <label for="telephone">Company Telephone :</label>
    <input type="text" name="telephone" class="form-control" placeholder="Company Telephone" value="{% if request.post('telephone') %}{{request.post('telephone')}}{% elseif supplier %}{{supplier.telephone}}{% endif %}">
</div>
