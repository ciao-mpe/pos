<div class="form-group">
    <label for="title">Product Title :</label>
    <input type="text" name="title" class="form-control" placeholder="Product Title" value="{% if request.post('title') %}{{request.post('title')}}{% else %}{{product.title}}{% endif %}">
</div>

<div class="form-group">
    <label for="title">Product Code :</label>
    <input type="text" name="code" class="form-control" placeholder="SKU-000001" value="{% if request.post('code') %}{{request.post('code')}}{% else %}{{product.code}}{% endif %}">
</div>

<div class="form-group">
    <label for="title">Product Description :</label>
    <textarea name="description" class="form-control" placeholder="Product Description">{% if request.post('description') %}{{request.post('description')}}{% else %}{{product.description}}{% endif %}</textarea>
</div>

<div class="form-group">
    <label for="price">Product Price :</label>
    <input type="text" name="price" class="form-control" placeholder="Product Price" value="{% if request.post('price') %}{{request.post('price')}}{% else %}{{product.price}}{% endif %}">
</div>

<div class="form-group">
    <label for="quantity">Product Qantity :</label>
    <input type="text" name="quantity" class="form-control" placeholder="Product Quantity" value="{% if request.post('quantity') %}{{request.post('quantity')}}{% else %}{{product.quantity}}{% endif %}">
</div>

<div class="form-group">
    <label for="reorder">Product Reorder Level (Qantity) :</label>
    <input type="text" name="reorder" class="form-control" placeholder="Product Reorder Level" value="{% if request.post('reorder') %}{{request.post('reorder')}}{% else %}{{product.reorder}}{% endif %}">
</div>

<div class="form-group">
    <label for="title">Product Image :</label>
    <span class="btn btn-default btn-file">
        <input type="file" name="image" size="50" />
    </span>
    {% if imgerr %}
        <span class="alert-danger">{{imgerr}}</p>
    {% endif %}
</div>