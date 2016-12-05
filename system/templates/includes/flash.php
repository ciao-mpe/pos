{% if flash.error %}
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{flash.error}}
    </div>
{% endif %}

{% if flash.success %}
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{flash.success}}
    </div>
{% endif %}
