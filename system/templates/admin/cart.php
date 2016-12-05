{% extends 'includes/default.php' %}

{% block title %} Cart {% endblock %}

{% block content %}
    <div class="row">
        <div class="col-md-8">
            {% if basket.count %}
                <div class="well">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            {% for item in basket.all %}
                                <tr {% if item.quantity == 0 %} class="danger" {% endif %}>
                                    <td>
                                         {% if item.image %}
                                          <img src="{{images}}/products/{{item.image}}.jpeg" style="max-width: 64px">
                                        {% else %}
                                          <img src="{{images}}/not_found.jpg" style="max-width: 64px">
                                        {% endif %}
                                    </td>
                                    <td>
                                        <a href="{{urlFor('product', {'slug' : item.slug})}}">{{item.title | length > 30 ? item.title|slice(0, 30) ~ '...' : item.title }}</a>
                                    </td>
                                    <td>
                                        Rs {{item.price | number_format(2)}}
                                    </td>
                                    <td>
                                        {% if item.quantity > 0 %}
                                           <form action="{{urlFor('cart_update', {slug: item.slug})}}" method="post" class="form-inline">
                                                <div class="input-group">
                                                    <select name="quantity" class="form-controll input-sm">
                                                        {% for num in 1..item.quantity %}
                                                            <option value="{{num}}" {% if item.order_quantity == num %} selected {% endif %}>{{num}}</option>
                                                        {% endfor %}
                                                    </select>
                                                    <input type="hidden" name="csrf_token" value="{{csrf_token}}">
                                                    <input type="submit" class="btn btn-default btn-sm" value="Update">
                                                </div>
                                           </form>
                                        {% else %}
                                           <span>Out of stock</span>
                                        {% endif %}
                                    </td>
                                    <td>
                                        <a href="{{urlFor('cart_delete', {'id' : item.id})}}" class="btn btn-default btn-sm">X</a>
                                    </td>
                                </tr>
                            {% endfor %}
                        </tbody>
                    </table>
                </div>
            {% else %}
            <p>You have no items in your cart.</p>
            {% endif %}
        </div>

        <div class="col-md-4">
            {% if basket.count and basket.total %}
                <div class="well">
                    <h4>Cart summary</h4>
                    <br>
                    {% include 'includes/cart/summary.php' %}
                    <a href="{{urlFor('cart_clear')}}" class="btn btn-default"> Clear</a>
                    <a href="{{urlFor('order')}}" class="btn btn-default"> Checkout</a>
                </div>
            {% endif %}
        </div>
    </div>
{% endblock %}