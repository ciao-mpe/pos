{% extends 'includes/admin/default.php' %}

{% block title %} Purchase Order (PO) {% endblock %}

{% block content %}

    {% include 'includes/validation_errors.php' %}

    <form action="{{urlFor('admin_purchases_order')}}" method="post">

        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="supplier">Select Supplier :</label>
                    <select name="supplier" class="form-control" id="supplier">
                        {% for supplier in suppliers %}
                            <option value="{{supplier.id}}" {% if request.post('supplier') == supplier.id %} selected {% endif %}>{{supplier.company_name}}</option>
                        {% endfor %}
                    </select>
                </div>
                <div class="form-group">
                    <label for="supplier">Purchase Date :</label>
                    <input type="date" name="date" class="form-control"  value="{% if request.post('date') %} {{request.post('date')}} {% endif %}">
                </div>

                <div class="checkbox">
                  <label><input type="checkbox" name="stock" {% if request.post('stock') == "on" %} checked {% endif %}>Stock Received</label>
                </div>

                <br>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th></th>
                    </thead>

                    <tbody>
                        {% for item in pocart.all %}
                            <tr>
                                <td><a href="{{urlFor('product', {'slug' : item.slug})}}">{{item.title | length > 50 ? item.title|slice(0, 50) ~ '...' : item.title }}</a></td>
                                <td>Rs {{item.price | number_format(2)}}</td>
                                <td>{{item.order_quantity}}</td>
                                <td>
                                    <a href="{{urlFor('admin_purchases_order_delete', {'id': item.id})}}" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-remove"></i></a>
                                    <a href="{{urlFor('admin_purchases_order_add', {'id': item.id})}}?update=true" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-pencil"></i></a>
                                </td>
                            </tr>
                        {% else %}
                            <td>No Products to show</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        {% endfor %}
                    </tbody>
                 </table>

                <div class="table-footer">
                  <a href="{{urlFor('product_all')}}?return=purchase_order" class="btn btn-default pull-right">Add New Product</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="well">
                   <h4>Purchase order summary</h4>
                    <br>
                    <table class="table">
                        <tr>
                            <td>Sub Total</td>
                            <td>Rs {{pocart.total | number_format(2)}}</td>
                        </tr>
                        <tr>
                            <td>Shipping</td>
                            <td>Free</td>
                        </tr>
                       
                        <tr>
                            <td class="success">Total</td>
                            <td class="success">Rs {{pocart.total | number_format(2)}}</td>
                        </tr>
                    </table>
                </div>
            {% if pocart.count > 0 %}
                <input type="hidden" name="csrf_token" value="{{csrf_token}}">
               <button type="submit" class="btn btn-success pull-right">Place Order</button>
               <a href="{{urlFor('admin_purchases_order_clear')}}" class="btn btn-default pull-right" style="margin-right: 10px">Clear Order</a>
            {% endif %}
            </div>

        </div>
    </form>

{% endblock %}