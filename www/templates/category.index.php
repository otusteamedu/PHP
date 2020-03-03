<?php if ($data && array_key_exists('elements', $data)) { ?>
    <ul>
        <?php
        foreach ($data['elements'] as $datum) {
            ?>
            <li><a href="<?php echo $datum['url']; ?>"><?php echo $datum['name']; ?></a> </li><?
        }
        ?>
    </ul>
    <?php
} ?>
<a href="<?php echo $data['back_url']; ?>">Ксписку</a>