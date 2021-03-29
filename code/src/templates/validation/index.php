<?php

/**
 * @var string $name
 * @var string $addr
 * @var string $result
 */

?>
<h1 class="h2">Server name: <?= $name ?></h1>
<h2 class="h3">Server address: <?= $addr ?></h2>

<div class="row mt-4 ">
    <div class="col-md-6">
        <form method="post">
            <label>
                Email:
                <input type="text" name="email"/>
            </label>
            <input type="submit" value="Check email"/>
        </form>
    </div>
</div>

<p><?= $result ?></p>
