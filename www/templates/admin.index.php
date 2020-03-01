<ul>
    <?php foreach ($data['menu_list'] as $datum) {
        ?> <li><a href="<?php echo $datum['url']; ?>"><?php echo $datum['name']; ?></a> </li><?
    }
?>
</ul>