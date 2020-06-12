<?php
/**
 * @see \App\Controller\EmailValidatorController
 * @var string|null $emails
 * @var array $result
 */
?>
<form method="post" action="/index.php?r=emailValidator/validate">
    <label>Validate emails <textarea name="emails" ><?=$emails ?? null?></textarea></label>
    <button type="submit">Submit</button>
</form>
<?php if (!empty($result)) { ?>
    <table>
        <tr><th>Email</th><th>Status</th></tr>
        <?php foreach ($result as $email => $valid) { ?>
            <tr><td><?=$email?></td><td><?=$valid ? 'Valid' : 'Invalid'?></td></tr>
        <?php } ?>
    </table>
<?php } ?>