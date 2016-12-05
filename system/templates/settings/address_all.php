{% extends 'includes/default.php' %}

{% block title %} My Addresses {% endblock %}

{% block content %}

        {% include 'includes/validation_errors.php' %}

        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">

                    <div class="panel-heading">
                     <h3 class="panel-title">My Addresses</h3>
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <th>Address</th>
                                <th>City</th>
                                <th>Postal Code</th>
                                <th>Telephone</th>
                                <td></td>
                            </thead>
                            <tbody>
                                {% for address in addresses %}
                                    <tr>
                                        <td>{{address.address1}} <br> {{address.address2}}</td>
                                        <td>{{address.city |  capitalize}}</td>
                                        <td>{{address.postal_code}}</td>
                                        <td>{{address.telephone}}</td>
                                        <td>
                                            <a href="{{urlFor('settings.address_edit', {'id' : address.id})}}" class="btn btn-warning">Edit</a>
                                        </td>
                                    </tr>
                                {% else %}
                                    <tr>
                                        <td>Not Found any addresses</td>
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

                <a href="{{urlFor('settings.address_new')}}" class="btn btn-default pull-right">Add New</a>

            </div>
        </div>
    
{% endblock %}