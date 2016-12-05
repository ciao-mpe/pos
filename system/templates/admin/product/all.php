{% extends 'includes/admin/default.php' %}

{% block title %} All Products {% endblock %}

{% block header %}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
{% endblock %}

{% block content %}
    
    <table id="products" class="table table-striped table-bordered table-hover datatable">
        <thead>
            <th>#</th>
            <th>Title</th>
            <th>Code</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Actions</th>
        </thead>

        <tfoot>
            <tr>
                <th></th>
                <th id="product_title"></th>
                <th id="product_code"></th>
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
            $('#products tfoot #product_title').html( '<input type="text" placeholder="Search title" />' );
            $('#products tfoot #product_code').html( '<input type="text" placeholder="Search code" />' );

            var table = $('#products').DataTable({
                "processing": true,
                "serverSide": true,
                "pageLength": 10,
                "ajax": {
                    url: "{{urlFor('product_all')}}",
                    type: "GET",
                    data: "",
                    error: function(){ 
                        $(".product-error").html("");
                        $("#products").append('<tbody class="errors"><tr><th colspan="6">No data found in the server</th></tr></tbody>');
                        $("#products_processing").css("display","none");
                    }
                },
                "columns": [
                    { "data": "id" },
                    { "data": "title" },
                    { "data": "code" },
                    { "data": "price" },
                    { "data": "quantity" },
                    { "data": "image" }
                ],
                fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    var image = "";
                    if(aData['image'] != "") {
                        image = "{{images}}/products/"+aData['image']+".jpeg";
                    } else {
                        image = "{{images}}/img_not_found.svg"
                    }
                    $('td:eq(0)', nRow).html('<img class"product-img" width="64" height="48" src="'+image+'">');
                    $('td:eq(1)', nRow).html(aData['title']);
                    $('td:eq(2)', nRow).html(aData['code']);
                    $('td:eq(3)', nRow).html('Rs '+aData['price']);
                    $('td:eq(4)', nRow).html(aData['quantity']);

                    if({{return_url}}) {
                        $('td:eq(5)', nRow).html('<a onclick="addURL(this)" href="{{urlFor("admin_purchases_order_add", {"id" : ""})}}" class="btn btn-xs btn-primary" data-id="'+aData['id']+'">Add</a>');
                    } else {
                        $('td:eq(5)', nRow).html('<a onclick="addURL(this)" href="{{urlFor("product_edit", {"id" : ""})}}" class="btn btn-xs btn-warning" data-id="'+aData['id']+'">Edit</a>');
                    }
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