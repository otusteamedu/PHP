<?php
/**
 * @var array $data
 */
?>
<?php if ($data && array_key_exists('elements', $data)) { ?>
    <ul>
        <?php
        foreach ($data['elements'] as $datum) {
            ?>
            <li><a href="<?php echo $datum['url']; ?>"><?php echo $datum['name']; ?></a><?php
            if($datum['elems']){

                ?>
                <ol>
                    <?php
                    foreach ($datum['elems'] as $elem) {
                        ?><li><a href="<?php echo $elem['url']; ?>"><?php echo $elem['name']; ?></a><?php
                    }
                    ?>
                </ol>

                <?php
            }

            ?></li><?
        }
        ?>
    </ul>
    <?php
} ?>
<a href="<?php echo $data['back_url']; ?>">Ксписку</a>