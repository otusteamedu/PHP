<?php if (!isset($result)): ?>
    <p>Request ID <?= $requestId ?> doesn't exists</p>
<?php endif; ?>

<?php if (isset($result)): ?>
    <p><?= $result ?></p>
<?php endif; ?>

<form action="check_request" method="post">
    <input type="hidden" name="request_id" value="<?= $requestId ?>">
    <input type="submit" value="Refresh" />
</form>


<a href="/">Back to index</a>