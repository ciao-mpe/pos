<div class="thumbnail">
    <a href="{{urlFor('product', {slug: product.slug})}}" title="{{product.title}} image">
      {% if product.image %}
        <img src="{{images}}/products/{{product.image}}.jpeg">
      {% else %}
        <img src="{{images}}/not_found.jpg">
      {% endif %}
    </a>
    
    <div class="caption">
        <h4> 
            <a href="{{urlFor('product', {'slug' : product.slug})}}" title="{{product.title}}">
                {{product.title | length > 30 ? product.title|slice(0, 30) ~ '...' : product.title }}
            </a>
        </h4>
        <p>
            {{product.description | length > 150 ? product.description|slice(0, 150) ~ '...' : product.description}}
        </p>
        <p>
            <a class="btn btn-success" href="{{urlFor('product', {'slug' : product.slug})}}" role="button">Add to cart</a>
        </p>
    </div>
</div>