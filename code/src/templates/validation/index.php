<?php

/**
 * @var string $result
 */

?>
<h1 class="h3">Validation email</h1>

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
