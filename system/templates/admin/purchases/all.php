{% extends 'includes/admin/default.php' %}

{% block title %} All Orders{% endblock %}

{% block header %}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
{% endblock %}

{% block content %}
    
    <table id="order" class="table table-striped table-bordered table-hover datatable">

        <thead>
            <th>Number</th>
            <th>Total</th>
            <th>Placed At</th>
            <th>Stock</th>
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
                    url: "{{urlFor('admin_purchases')}}",
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
                    { "data": "total" },
                    { "data": "date"},
                    { "data" : "stock"},
                    { "data": "id"}
                ],
                fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $('td:eq(0)', nRow).html(aData['number']);
                    $('td:eq(1)', nRow).html('Rs '+aData['total']);
                    $('td:eq(2)', nRow).html(aData['date']);

                    if(aData['stock'] == 1) {
                        $('td:eq(3)', nRow).html('<span class="label label-success">Received</span>');
                    } else if (aData['stock'] == 0){
                        $('td:eq(3)', nRow).html('<span class="label label-warning">Pending</span>');
                    } 
                    $('td:eq(4)', nRow).html('<a onclick="addURL(this)" href="{{urlFor("admin_purchases_order_view", {"number" : ""})}}" class="btn btn-xs btn-warning" data-number="'+aData['number']+'">View</a>');
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