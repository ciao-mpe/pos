{% extends 'includes/admin/default.php' %}

{% block title %} All Staff Members {% endblock %}

{% block header %}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
{% endblock %}

{% block content %}
    
    <table id="staff" class="table table-striped table-bordered table-hover datatable">
        <thead>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </thead>

        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th id="email"></th>
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
            $('#staff tfoot #email').html( '<input type="text" placeholder="Search email" />');

            var table = $('#staff').DataTable({
                "processing": true,
                "serverSide": true,
                "pageLength": 10,
                "ajax": {
                    url: "{{urlFor('staff_all')}}",
                    type: "GET",
                    data: "",
                    error: function(){ 
                        $(".staff-error").html("");
                        $("#staff").append('<tbody class="errors"><tr><th colspan="6">No data found in the server</th></tr></tbody>');
                        $("#staff_processing").css("display","none");
                    }
                },
                "columns": [
                    { "data": "id" },
                    { "data": "name" },
                    { "data": "email" },
                    { "data": "uid"}
                ],
                fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $('td:eq(0)', nRow).html(aData['id']);
                    $('td:eq(1)', nRow).html(aData['name']);
                    $('td:eq(2)', nRow).html(aData['email']);
                    $('td:eq(3)', nRow).html('<a onclick="addURL(this)" href="{{urlFor("staff_edit", {"id" : ""})}}" class="btn btn-xs btn-warning" data-id="'+aData['uid']+'">Edit</a>');
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