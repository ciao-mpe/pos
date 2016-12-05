{% extends 'includes/admin/default.php' %}

{% block title %} Purchase Order | {{order.number}} {% endblock %}

{% block content %}
    <div class="row">
        <div class="col-md-12">
            <h4>Purchase Order Information</h4>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Supplier</th>
                        <th>Order Number</th>
                        <th>Order Date</th>
                        <th>Stock Recived</th>
                        <th>Order Total</th>
                        {% if order.stock == 0 %}
                        <th>#</th>
                        {% endif %}
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{supplier.company_name}}</td>
                        <td>{{order.number}}</td>
                        <td>{{order.date}}</td>
                        <td>
                            {% if order.stock %}
                            <span class="label label-success">Received</span>
                            {% else %}
                             <span class="label label-warning">Pending</span>
                            {% endif %}
                        </td>
                        <td>Rs {{order.total}}</td>
                        {% if order.stock == 0 %}
                        <td><a href="{{urlFor('admin_purchases_order_stock', {'number' : order.number})}}" class="btn btn-success">Mark as Stock Received</a></td>
                        {% endif %}
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h4>Purchase Order Products</h4>
             <table class="table table-striped table-bordered table-hover">
                <thead>
                    <th>Title</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </thead>
                <tbody>
                    {% for product in products %}
                        <tr>
                            <td><a href="{{urlFor('product', {'slug': product.slug})}}" target="_blank">{{product.title}}</a></td>
                            <td class="text-center">Rs {{product.unit_price | number_format(2)}}</td>
                            <td class="text-center">{{product.quantity}}</td>
                            <td class="text-right">Rs {{product.total | number_format(2)}}</td>
                        </tr>
                    {% endfor %}
                </tbody>
            </table>
        </div>
    </div>

{% endblock %}