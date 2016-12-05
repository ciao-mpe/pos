{% extends 'includes/default.php' %}

{% block title %} Order {% endblock %}

{% block content %}

{% include 'includes/validation_errors.php' %}

<form action="{% if auth %} {{urlFor('order_with_auth')}} {%else%} {{urlFor('order')}} {%endif%}" method="post">
    <div class="row">

        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <h3>Your Details</h3>
                    <hr>
                    {% if customer %}
                        {% include 'includes/forms/customer.php' with {'loggedin': true} %}
                    {% else %}
                         {% include 'includes/forms/customer.php' with {'loggedin': false} %}
                    {% endif %}
                </div>

                <div class="col-md-6">
                    <h3>Shipping Address</h3>
                    <hr>
                    {% if auth %}

                        {% if customer.ownAddress %}
                            <div class="form-group">
                                <label for="first_name">Select Address :</label>
                                <select name="address" class="form-controll input-sm" id="addressess">
                                    {% for address in customer.ownAddress %}
                                        <option value="{{address.id}}" data-address1="{{address.address1}}" data-address2="{{address.address2}}" data-city="{{address.city}}" data-zip="{{address.postal_code}}" data-telephone="{{address.telephone}}"> {{address.address1}}, {{address.address2}}, {{address.city | capitalize }}, {{address.postal_code | capitalize }}, {{address.telephone}}</option>
                                    {% endfor %}
                                </select>
                            </div>
                            <hr>
                            {% include 'includes/forms/address.php' with {'loggedin': true} %}
                            <a href="{{urlFor('settings.address_new')}}?return=order" class="btn btn-default pull-right">New</a>
                        {% else %}
                            <p>Not found any addresses related to your account, please add a new address and continue your order</p>
                            <a href="{{urlFor('settings.address_new')}}?return=order" class="btn btn-default pull-right">New</a>
                        {% endif %}

                    {% else %}
                        {% include 'includes/forms/address.php' with {'loggedin': false} %}
                    {% endif %}

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="well">
                <h4>Your Order</h4>
                <br>
               {% include 'includes/cart/summary.php'%}
                <input type="hidden" name="csrf_token" value="{{csrf_token}}">
               <button type="submit" class="btn btn-default">Place Order</button>
            </div>
        </div>
    </div>
</form>
{% endblock %}

{% block footer %}
    
    <script type="text/javascript">
        $("#addressess").change(function(){

            var address1 =  $('option:selected', this).data('address1');
            var address2 =  $('option:selected', this).data('address2');
            var city =  $('option:selected', this).data('city');
            var zip =  $('option:selected', this).data('zip');
            var telephone =  $('option:selected', this).data('telephone');

            $('#address1').val(address1);
            $('#address2').val(address2);
            $('#city').val(city);
            $('#zip').val(zip);
            $('#telephone').val(telephone);
        });
    </script>

{% endblock %}