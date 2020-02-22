<?php
include_once 'vendor/autoload.php';
$obMapCategory = new \Tirei01\Hw12\Storage\Mapper\Category();
$obMapProperty = new \Tirei01\Hw12\Storage\Mapper\Property();
$obMapElement = new \Tirei01\Hw12\Storage\Mapper\Element();
$obMapValue = new \Tirei01\Hw12\Storage\Mapper\Value();
$obCollCategories = $obMapCategory->findAll();
echo '<h2>Категории:</h2>';
?><ul><?php
/**@var \Tirei01\Hw12\Storage\Category $obCollCategory */
foreach ($obCollCategories as $obCollCategory) {
    ?><li>[<?php echo $obCollCategory->getId(); ?>] <?php echo $obCollCategory->getName(); ?>
    <ul><b>Свойства категории</b>
        <?php
        $obCollProperties = $obMapProperty->findByCategory($obCollCategory);
        /**@var \Tirei01\Hw12\Storage\Property $obCollProperty */
        foreach ($obCollProperties as $obCollProperty) {
            ?><li>[<?php echo $obCollProperty->getId(); ?>] <?php echo $obCollProperty->getName() ?></li><?php
        }
        ?>
    </ul>
    <ul>
        <b>Элементы</b>
        <?php
        $obCollElements = $obMapElement->findByCategory($obCollCategory);
        /** @var \Tirei01\Hw12\Storage\Element $obCollElement */
        foreach ($obCollElements as $obCollElement) {
            ?><li>[<?php echo $obCollElement->getId(); ?>] <?php echo $obCollElement->getName(); ?>
            <ul>
                <b>Значения свойств</b>
                <?php
                /**@var \Tirei01\Hw12\Storage\Property $obCollProperty */
                foreach ($obCollProperties as $obCollProperty) {
                    /** @var \Tirei01\Hw12\Storage\Value $obValue */
                    $obValue = $obMapValue->findByElem($obCollElement, $obCollProperty);
                    $value = '';
                    if($obCollProperty->getType() === 'int'){
                        $value = $obValue->getNumericValue();
                    }else{
                        $value = $obValue->getStringValue();
                    }
                    ?>
                    <li><span><?php echo $obCollProperty->getName(); ?></span> = [<?php echo $obValue->getId(); ?>] - <span><?php echo $value; ?></span></li><?php
                }
                ?>

            </ul>

            </li><?php
        }
        ?>
    </ul>
    </li><?php
}
?>
</ul>
<a href="/admin.php">adminka</a>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">