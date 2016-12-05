{% extends 'includes/admin/default.php' %}

{% block title %} Admin Home {% endblock %}

{% block content %}

    <div class="row">
        <div class="col-md-12">
            <canvas id="salesChart" width="1170" height="400"></canvas>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <h3>Latest Orders</h3>
            <br>
            <table class="table table-striped table-bordered table-hover datatable">

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
        </div>
    </div>
    <br>
     <div class="row">
        <div class="col-md-12">
            <h3>Latest Customers</h3>
            <br>

            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </thead>

                <tbody>
                    {% for customer in customers %}
                    <tr>
                        <td>{{customer.id}}</td>
                        <td>{{customer.name}}</td>
                        <td>{{customer.email}}</td>
                        <td><a href="{{urlFor('customer_edit', {'id' : customer.id})}}" class="btn btn-xs btn-warning">Edit</a></td>
                    </tr>
                    {% else %}
                    <tr>
                        <td>Not Found any customers</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    {% endfor %}
                </tbody>
            </table>
        </div>
    </div>
    <br><br>
{% endblock %}

{% block footer %}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

    <script type="text/javascript">

        $.ajax({
          type: "GET",
          url: "{{urlFor('admin_home_sales')}}",
          success: function(sales) {
           var chart = jQuery.parseJSON(sales);

           drawChart(chart);

          },
          error: function() {
            console.log('somthing went wrong');
          }
        });

       function drawChart(data) {

        var ctx = document.getElementById("salesChart");
        var data = {
            labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            datasets: [
                {
                    label: "Sales of the year",
                    fill: true,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: data,
                    spanGaps: false,
                }
            ]
        };
        
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
       }

    </script>
{% endblock %}