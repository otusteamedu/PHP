<?php

/**
 * @var string $name
 * @var string $addr
 * @var string $result
 */

?>
<h1><small>Server name:</small> <?= $name ?></h1>
<h2>Server address: <?= $addr ?></h2>


<form method="post">
    <label>
        Email:
        <input type="text" name="email"/>
    </label>
    <input type="submit" value="Check email"/>
</form>

<p><?= $result ?></p>
