<form method="POST" action="{{ route('email.check') }}">
    <b>Email</b>
    {{ csrf_field() }}
    <input type="text" name="email">
    <button type="submit">Validate</button>
</form>
