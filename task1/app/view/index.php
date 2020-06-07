<?php
/**
 * @see \App\Action\Index
 * @see \App\Action\Validate
 * @var string|null $message
 * @var string|null $text
 */
?>
<html>
<body>
    <form method="post" action="/app.php?r=validate">
        <label>Validate text <input name="text" value="<?=$text ?? null?>" /></label>
        <button type="submit">Submit</button>
    </form>
    <?php if (!empty($message)) { ?>
        <p>Result: <?=$message?></p>
    <?php } ?>
</body>
</html>