{% extends 'includes/default.php' %}

{% block title %} Products {% endblock %}

{% block content %}
  <br>
  <div class="row">
      {% for index, product in products %}
          <div class="col-md-4 col-sm-6 main-products">
            {% include 'product/includes/single_product.php' %}
          </div>
      {% endfor %}
  </div>

  {% include 'includes/pagination.php'%}
{% endblock %}