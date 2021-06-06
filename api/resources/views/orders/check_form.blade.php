@if(!empty($status))
    Order status is {{ $status }}
@endif
@if(!empty($orderId))
    Your order id is {{$orderId}}
@endif
<form action="/check-status">
    <label>
        Order id
        <input type="text" name="order_id">
    </label>
    <button type="submit">Check</button>
</form>
