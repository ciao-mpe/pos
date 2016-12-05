{% extends 'includes/admin/default.php' %}

{% block title %} All Orders{% endblock %}

{% block header %}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
{% endblock %}

{% block content %}
    
    <table id="order" class="table table-striped table-bordered table-hover datatable">
        <thead>
            <th>Number</th>
            <th>Status</th>
            <th>Total</th>
            <th>Placed At</th>
            <th>Actions</th>
        </thead>

        <tfoot>
            <tr>
                <th id="number"></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </tfoot>
       
    </table>

{% endblock %}

{% block footer %}
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">

        $(function() {

            // Setup - add a text input to each footer cell
            $('#order tfoot #number').html( '<input type="text" placeholder="Search number" />');

            var table = $('#order').DataTable({
                "processing": true,
                "serverSide": true,
                "pageLength": 10,
                "ajax": {
                    url: "{{urlFor('admin_orders')}}",
                    type: "GET",
                    data: "",
                    error: function(){ 
                        $(".order-error").html("");
                        $("#order").append('<tbody class="errors"><tr><th colspan="6">No data found in the server</th></tr></tbody>');
                        $("#order_processing").css("display","none");
                    }
                },
                "columns": [
                    { "data": "number" },
                    { "data": "status" },
                    { "data": "total" },
                    { "data": "created_at"},
                    { "data": "id"}
                ],
                fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $('td:eq(0)', nRow).html(aData['number']);

                    if(aData['status'] == 'pending') {
                        $('td:eq(1)', nRow).html('<span class="label label-warning">'+ aData['status'] +'</span>');
                    } else if(aData['status'] == 'shipped'){
                        $('td:eq(1)', nRow).html('<span class="label label-success">'+ aData['status'] +'</span>');
                    } else if(aData['status'] == 'canceled') {
                        $('td:eq(1)', nRow).html('<span class="label label-danger">'+ aData['status'] +'</span>');
                    }

                    $('td:eq(2)', nRow).html('Rs '+aData['total']);
                    $('td:eq(3)', nRow).html(aData['created_at']);
                    $('td:eq(4)', nRow).html('<a onclick="addURL(this)" href="{{urlFor("admin_order_view", {"number" : ""})}}" class="btn btn-xs btn-warning" data-number="'+aData['number']+'">View</a>');
                }
            });

            // Apply the search
            table.columns().every( function () {
                var that = this;
                $( 'input', this.footer() ).on( 'keyup change', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                });
            });
        });

        function addURL(element) {
            $(element).attr('href', function(e) {
               return this.href + $(this).data('number');
            });
        }

    </script>
{% endblock %}