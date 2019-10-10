<p>Your request has been scheduled, request ID = <?= $requestId ?></p>

<form action="check_request" method="post">
    <input type="hidden" name="request_id" value="<?= $requestId ?>">
    <input type="submit" value="Check result" />
</form>

<a href="/">Back to index</a>

