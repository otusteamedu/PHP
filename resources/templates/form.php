<?php ?>

<form style="display: grid; gap: 10px; max-width: 260px" method="post" action="/form/">
    <label>Input your name
        <input name="name">
    </label>
    <label>Input your email
        <input name="email">
    </label>
    <label>Select date start
        <input name="date_from" type="date">
    </label>
    <label>Select date end
        <input name="date_to" type="date">
    </label>

    <button type="submit">Request</button>
</form>
