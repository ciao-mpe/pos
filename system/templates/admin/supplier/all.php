{% extends 'includes/admin/default.php' %}

{% block title %} All Suppliers {% endblock %}

{% block header %}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
{% endblock %}

{% block content %}
    
    <table id="supplier" class="table table-striped table-bordered table-hover datatable">
        <thead>
            <th>#</th>
            <th>Company Name</th>
            <th>Email</th>
            <th>Address</th>
            <th>Telephone</th>
            <th>Actions</th>
        </thead>

        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th id="email"></th>
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
            $('#supplier tfoot #email').html( '<input type="text" placeholder="Search email" />');

            var table = $('#supplier').DataTable({
                "processing": true,
                "serverSide": true,
                "pageLength": 10,
                "ajax": {
                    url: "{{urlFor('supplier_all')}}",
                    type: "GET",
                    data: "",
                    error: function(){ 
                        $(".supplier-error").html("");
                        $("#supplier").append('<tbody class="errors"><tr><th colspan="6">No data found in the server</th></tr></tbody>');
                        $("#supplier_processing").css("display","none");
                    }
                },
                "columns": [
                    { "data": "id" },
                    { "data": "company_name" },
                    { "data": "email" },
                    { "data": "address" },
                    { "data": "telephone" },
                    { "data": "id"}
                ],
                fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $('td:eq(0)', nRow).html(aData['id']);
                    $('td:eq(1)', nRow).html(aData['company_name']);
                    $('td:eq(2)', nRow).html(aData['email']);
                    $('td:eq(3)', nRow).html(aData['address']);
                    $('td:eq(4)', nRow).html(aData['telephone']);
                    $('td:eq(5)', nRow).html('<a onclick="addURL(this)" href="{{urlFor("supplier_edit", {"id" : ""})}}" class="btn btn-xs btn-warning" data-id="'+aData['id']+'">Edit</a>');
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
               return this.href + $(this).data('id');
            });
        }

    </script>
{% endblock %}