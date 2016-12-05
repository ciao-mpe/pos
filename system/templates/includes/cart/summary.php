 <table class="table">
    <tr>
        <td>Sub Total</td>
        <td>Rs {{basket.total | number_format(2)}}</td>
    </tr>
    <tr>
        <td>Shipping</td>
        <td>Free</td>
    </tr>
    <tr>
        <td class="success">Total</td>
        <td class="success">Rs {{basket.total | number_format(2)}}</td>
    </tr>
</table>