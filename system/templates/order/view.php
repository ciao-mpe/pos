{% extends 'includes/default.php' %}

{% block title %} Order | {{order.number}} {% endblock %}

{% block content %}
    
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>Order Date</th>
                        <th>Order Status</th>
                        <th>Order Total</th>
                        {% if order.status == 'shipped' %}
                            <th>Actions</th>
                        {% endif %}
                    </tr>
                </thead>
                <tbody>
                    <tr>
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
                        {% if order.status == 'shipped' %}
                            <td>
                                <a href="{{urlFor('order_invoice', {'number': order.number})}}" class="btn btn-success btn-warning">View Invoice</a>
                            </td>
                        {% endif %}
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
             <table id="products" class="table table-striped table-bordered table-hover">
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