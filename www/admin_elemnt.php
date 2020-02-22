<?php
include_once 'vendor/autoload.php';
$idCurrentCategory = intval($_GET['category']);
$obCurrentCategory = null;
$obCategoryMapper = new \Tirei01\Hw12\Storage\Mapper\Category();
$obCatCollect = $obCategoryMapper->findAll();
/**@var \Tirei01\Hw12\Storage\Category $category */
foreach ($obCatCollect as $category) {
    if ($idCurrentCategory == $category->getId()) {
        $obCurrentCategory = $category;
        break;
    }
}
if ($obCurrentCategory !== null) {
    $obPropOfCurrentCategory = new \Tirei01\Hw12\Storage\Mapper\Property();
    $obCollectOfProps = $obPropOfCurrentCategory->findByCategory($obCurrentCategory);
}
$idCurrentElem = null;
if (isset($_GET['element'])) {
    $idCurrentElem = intval($_GET['element']);
}
$obElementMapper = new \Tirei01\Hw12\Storage\Mapper\Element();
if ($idCurrentElem > 0) {
    $currentElement = $obElementMapper->find($idCurrentElem);
} elseif ($obCurrentCategory !== null) {
    $currentElement = new \Tirei01\Hw12\Storage\Element(intval($idCurrentElem), '', $obCurrentCategory, 500, '');
}
$obValueMapper = new \Tirei01\Hw12\Storage\Mapper\Value();
if ($_POST) {
    switch ($_POST['action']) {
        case 'add_element':
            $arElemField = $_POST['elem'];
            $arPropField = $_POST['prop'];
            $currentElement->setCode($arElemField['code']);
            $currentElement->setSort($arElemField['sort']);
            $currentElement->setName($arElemField['name']);
            $currentElement->setCategory($obCurrentCategory);
            if ($currentElement->getId() === 0) {
                $obElementMapper->insert($currentElement);
            } else {
                $obElementMapper->update($currentElement);
            }
            /**@var \Tirei01\Hw12\Storage\Property $obCollectOfProp */
            foreach ($obCollectOfProps as $obCollectOfProp) {
                $code = $obCollectOfProp->getCode();
                if (array_key_exists($code, $arPropField)) {
                    $value = $arPropField[$code];
                    $obValue = $obValueMapper->findByElem($currentElement, $obCollectOfProp);
                    if ($obValue === null) {
                        $obValue = new \Tirei01\Hw12\Storage\Value(
                            0, $obCollectOfProp, $currentElement, '', '', $obCurrentCategory
                        );
                    }
                    if ($obCollectOfProp->getType() === 'int') {
                        $obValue->setNumericValue(intval($value));
                    } else {
                        $obValue->setStringValue($value);
                    }
                    if ($obValue->getId() === 0) {
                        $obValueMapper->insert($obValue);
                    } else {
                        $obValueMapper->update($obValue);
                    }
                }
            }
            break;
    }
}
?>
<div class="list-group"><?php
    /**@var \Tirei01\Hw12\Storage\Category $category */
    foreach ($obCatCollect as $category) {
        $classCss = 'list-group-item list-group-item-action';
        if ($idCurrentCategory == $category->getId()) {
            $classCss = 'list-group-item list-group-item-action active';
        }
        ?>
        <a href="?category=<?php echo $category->getId(); ?>"
           class="<?php echo $classCss; ?>"><?php echo $category->getName(); ?></a>
        <?php
    }
    if ($obCurrentCategory !== null) {
        ?>
        <a href="admin_elemnt.php?category=<?php echo $obCurrentCategory->getId(); ?>&element=0">Добавить новый</a>
    <?php } ?>
</div>
<?php
if ($currentElement !== null) {
    if ($idCurrentElem !== null) {
        ?>
        <h2>Добавить элемент категории <?php echo $obCurrentCategory->getName(); ?></h2>
        <form method="post">
            <input type="hidden" name="action" value="add_element">
            <div class="form-group">
                <label for="name_elem">Название</label>
                <input class="form-control" id="name_elem" name="elem[name]"
                       value="<?php echo $currentElement->getName(); ?>">
            </div>
            <div class="form-group">
                <label for="code_elem">Код</label>
                <input class="form-control" id="code_elem" name="elem[code]"
                       value="<?php echo $currentElement->getCode(); ?>">
            </div>
            <div class="form-group">
                <label for="sort_elem">Сортировка</label>
                <input class="form-control" id="sort_elem" name="elem[sort]"
                       value="<?php echo $currentElement->getSort(); ?>">
            </div>
            <?php

            /**@var \Tirei01\Hw12\Storage\Property $obCollectOfProp */
            foreach ($obCollectOfProps as $obCollectOfProp) {
                /**@var \Tirei01\Hw12\Storage\Value $obValue */
                $obValue = $obValueMapper->findByElem($currentElement, $obCollectOfProp);
                if ($obValue === null) {
                    $obValue = new \Tirei01\Hw12\Storage\Value(
                        0, $obCollectOfProp, $currentElement, 0, '', $obCurrentCategory
                    );
                }
                $value = '';
                if ($obCollectOfProp->getType() === 'int') {
                    $value = $obValue->getNumericValue();
                } else {
                    $value = $obValue->getStringValue();
                }
                ?>
                <div class="form-group">
                    <label for="<?php echo $obCollectOfProp->getCode(); ?>_props"><?php echo $obCollectOfProp->getName(
                        ); ?>
                        (свойство)</label>
                    <input class="form-control" id="<?php echo $obCollectOfProp->getCode(); ?>_props"
                           name="prop[<?php echo $obCollectOfProp->getCode(); ?>]" value="<?php echo $value; ?>">
                </div>
                <?php
            }
            ?>


            <input type="submit" class="btn btn-primary" value="сохранить">
        </form>
        <?php
    } else {
        $obCollectionElem = $obElementMapper->findByCategory($obCurrentCategory);
        ?>
        <ul>
            <?php
            /**@var \Tirei01\Hw12\Storage\Element $item */
            foreach ($obCollectionElem as $item) {
                ?>
                <li><a href="admin_elemnt.php?category=<?php echo $item->getCategory()->getId(
                ); ?>&element=<?php echo $item->getId(); ?>">[<?php echo $item->getId(); ?>] <?php echo $item->getName(
                    ); ?></a> </li><?php
            }
            ?>

        </ul>
        <?php

    }

} ?>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
