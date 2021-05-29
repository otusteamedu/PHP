<?php

/** @var \App\Entity\User $user */

?>

<h1 class="h3">Привет, <?= $user->getUsername() ?></h1>
<p><a href="/bank-operation">Получить сведения о банковских операциях</a> </p>
