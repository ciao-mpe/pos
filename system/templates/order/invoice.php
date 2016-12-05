{% extends 'includes/default.php' %}

{% block title %} Invoice {% endblock %}

{% block content %}
    <div id="invoice">
   
        <div class="row">
            <div class="col-xs-12">

                <div class="invoice-title">
                    <h2>Invoice</h2><h3 class="pull-right">Order # {{order.number}}</h3>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-6">
                        <address>
                        <strong>Billed To:</strong><br>
                            {{customer.first_name | capitalize}} {{customer.last_name | capitalize}}<br>
                            {{address.address1}}<br>
                            {% if address.address2 %}{{address.address2}}<br>{% endif %}
                            {{address.city | capitalize }}, {{address.postal_code}} <br>
                            {{address.telephone}}
                        </address>
                    </div>
                    <div class="col-xs-6 text-right">
                        <address>
                        <strong>Shipped To:</strong><br>
                            {{customer.first_name | capitalize}} {{customer.last_name | capitalize}}<br>
                            {{address.address1}}<br>
                            {% if address.address2 %}{{address.address2}}<br>{% endif %}
                            {{address.city | capitalize }}, {{address.postal_code | capitalize }} <br>
                            {{address.telephone}}
                        </address>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <address>
                            <strong>Payment Method:</strong><br>
                            Visa ending **** 4242<br>
                            jsmith@email.com
                        </address>
                    </div>
                    <div class="col-xs-6 text-right">
                        <address>
                            <strong>Order Date:</strong><br>
                            {{order.created_at}}<br><br>
                        </address>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Order summary</strong></h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <td><strong>Item</strong></td>
                                        <td class="text-center"><strong>Price</strong></td>
                                        <td class="text-center"><strong>Quantity</strong></td>
                                        <td class="text-right"><strong>Totals</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                    {% for product in products %}
                                    <tr>
                                        <td>{{product.title}}</td>
                                        <td class="text-center">Rs {{product.unit_price | number_format(2)}}</td>
                                        <td class="text-center">{{product.quantity}}</td>
                                        <td class="text-right">Rs {{product.total | number_format(2)}}</td>
                                    </tr>
                                    {% endfor %}

                                    <tr>
                                        <td class="thick-line"></td>
                                        <td class="thick-line"></td>
                                        <td class="thick-line text-center"><strong>Subtotal</strong></td>
                                        <td class="thick-line text-right">Rs {{order.total | number_format(2)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line text-center"><strong>Shipping</strong></td>
                                        <td class="no-line text-right">Free</td>
                                    </tr>
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line text-center"><strong>Total</strong></td>
                                        <td class="no-line text-right">Rs {{order.total | number_format(2)}}</td>
                                    </tr>
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="#" class="btn btn-default btn-lg pull-right" onclick="printPDF()">Print</a>
{% endblock %}

{% block footer %}
 

{% endblock %}