<p>Server <?= $_SERVER['SERVER_ADDR'] ?>: <?= $_SERVER['SERVER_PORT'] ?></p>
<p>Client (remote): <?= $_SERVER['REMOTE_ADDR'] ?>: <?= $_SERVER['REMOTE_PORT'] ?></p>
<p>Hostname: <?= $_SERVER['HOSTNAME'] ?></p>

<hr>

<pre>
    <?php print_r($_SERVER); ?>
</pre>