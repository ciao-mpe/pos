{% extends 'includes/admin/default.php' %}

{% block title %} Order | {{order.number}} {% endblock %}

{% block content %}
    <div class="row">
        <div class="col-md-12">
            <h4>Order Information</h4>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Order Number</th>
                        <th>Order Date</th>
                        <th>Order Status</th>
                        <th>Order Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{customer.first_name}} {{customer.last_name}}</td>
                        <td>{{order.number}}</td>
                        <td>{{order.date.diffForHumans()}}</td>
                        <td>
                            {% if order.status == 'pending' %}
                                <span class="label label-warning">{{order.status}}</span>
                            {% elseif order.status == 'shipped' %}
                                <span class="label label-success">{{order.status}}</span>
                            {% elseif order.status == 'canceled' %}
                                <span class="label label-danger">{{order.status}}</span>
                            {% endif %}
                        </td>
                        <td>Rs {{order.total}}</td>
                        <td>
                            {% if order.status == 'pending' %}
                                <a href="{{urlFor('admin_order_status', {'number': order.number})}}" class="btn btn-success btn-sm">Mark as Shipped</a>
                            {% endif %}

                            {% if order.status == 'shipped' %}
                                <a href="{{urlFor('admin_order_invoice', {'number': order.number})}}" class="btn btn-success btn-warning">View Invoice</a>
                            {% endif %}
                            
                            {% if order.status == 'pending' %}
                                <a href="{{urlFor('admin_order_cancel', {'number': order.number})}}" class="btn btn-danger btn-sm">Cancel</a>
                            {% endif %}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h4>Order Address</h4>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <th>Address</th>
                    <th>City</th>
                    <th>Postal Code</th>
                    <th>Telephone</th>
                </thead>
                <tbody>
                    <tr>
                        <td>{{address.address1}} <br> {{address.address2}}</td>
                        <td>{{address.city |  capitalize}}</td>
                        <td>{{address.postal_code}}</td>
                        <td>{{address.telephone}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h4>Order Products</h4>
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