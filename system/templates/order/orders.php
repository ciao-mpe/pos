{% extends 'includes/default.php' %}

{% block title %} My Orders {% endblock %}

{% block content %}
    
    <table id="order" class="table table-striped table-bordered table-hover datatable">

        <thead>
            <th>Number</th>
            <th>Status</th>
            <th>Total</th>
            <th>Placed At</th>
            <th>Actions</th>
        </thead>
        
        <tbody>
             {% for order in orders %}
                <tr>
                    <td>{{order.number}}</td>
                    <td>
                        {% if order.status == 'pending' %}
                            <span class="label label-warning">{{order.status}}</span>
                        {% elseif order.status == 'shipped' %}
                            <span class="label label-success">{{order.status}}</span>
                        {% elseif order.status == 'canceled' %}
                            <span class="label label-danger">{{order.status}}</span>
                        {% endif %}
                    </td>
                    <td>Rs {{order.total | number_format(2)}}</td>
                    <td>{{order.created_at}}</td>
                    <td>
                        <a href="{{urlFor('order_view', {'number' : order.number})}}" class="btn btn-xs btn-warning">View</a>
                    </td>
                </tr>
             {% else %}
                <tr>
                    <td>Not Found any orders</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
             {% endfor %}
        </tbody>
    </table>
        
    {% include 'includes/pagination.php'%}

{% endblock %}