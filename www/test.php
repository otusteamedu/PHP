<?php

$obPropertyMapper = new \Tirei01\Hw12\Storage\Mapper\Value($conn);
if ($curentProperty !== null) {
    $arValues = $obPropertyMapper->findByProperty($curentProperty)

    ?>
    <div><?php

        /**@var \Tirei01\Hw12\Storage\Value $obValue */
        foreach ($arValues as $obValue) {
            ?>
            <form method="post">
                <input type="hidden" name="action" value="add_value">
                <input type="hidden" name="value_id" value="<?php echo $obValue->getId(); ?>">
                <?php if ($arCurrentElement['type'] === 'string'){
                    ?><span>Тип:строка</span>
                    <input name="s_value" value="<?php echo $obValue->getStringValue(); ?>">
                    <?
                } elseif ($arCurrentElement['type'] === 'int'){
                    ?><span>Тип:число</span>
                    <input name="i_value" value="<?php echo $obValue->getNumericValue(); ?>"><?
                }?>
                <br>
                <input type="submit" value="сохранить">
            </form>
            <br>
            <?php
        }
        $obValueNew = new \Tirei01\Hw12\Storage\Value(
            0,
            $curentProperty,
            0,
            ''
        );
        ?>
        <span>Новое значение</span>
        <form method="post">
            <input type="hidden" name="action" value="add_value">
            <input type="hidden" name="value_id" value="<?php echo $obValueNew->getId(); ?>">
            <?php if ($arCurrentElement['type'] === 'string'){
                ?><span>Тип:строка</span>
                <input name="s_value" value="<?php echo $obValueNew->getStringValue(); ?>">
                <?
            } elseif ($arCurrentElement['type'] === 'int'){
                ?><span>Тип:число</span>
                <input name="i_value" value="<?php echo $obValueNew->getNumericValue(); ?>"><?
            }?>
            <br>
            <input type="submit" value="сохранить">
        </form>
    </div>


    <?php

}
