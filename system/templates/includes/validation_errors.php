{% if errors %}
    <div class="errors">
        <ul>
        {% for error in errors %}
            <li>{{error | first}}</li>
        {% endfor %}
        </ul>
    </div>
{% endif %}