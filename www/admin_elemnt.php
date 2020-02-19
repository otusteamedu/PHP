<?php
include_once 'vendor/autoload.php';
$idCurrentCategory = $_GET['category'];
$obCurrentCategory = null;

$idCurrentElem = $_GET['element'];
$obCurrentElem = null;

if($_POST){


    // TODO DEL THIS
    echo "<pre style='color:red; clear: both;'>";
    print_r($_POST);
    echo "</pre>";
}

$obCategoryMapper = new \Tirei01\Hw12\Storage\Mapper\Category();
$obCatCollect = $obCategoryMapper->findAll();
?>
<div class="list-group"><?php
    /**@var \Tirei01\Hw12\Storage\Category $category */
    foreach ($obCatCollect as $category) {
        $classCss = 'list-group-item list-group-item-action';
        if ($idCurrentCategory == $category->getId()) {
            $obCurrentCategory = $category;
            $classCss = 'list-group-item list-group-item-action active';
        }
        ?>
        <a href="?category=<?php echo $category->getId(); ?>"
           class="<?php echo $classCss; ?>"><?php echo $category->getName(); ?></a>
        <?php
    }
    if($obCurrentCategory !== null){
    ?>
    <a href="admin_elemnt.php?category=<?php echo $obCurrentCategory->getId(); ?>&element=0">Добавить новый</a>
    <?php } ?>
</div>
<?php
if($idCurrentElem !== null){
    $obCurrentElem = new \Tirei01\Hw12\Storage\Mapper\Element();
    if($idCurrentElem > 0){
        $obCurrentElem->find($idCurrentElem);

    }else{
        $idCurrentElem = new \Tirei01\Hw12\Storage\Element($idCurrentElem, '', $obCurrentCategory, 500, '');
    }
?>
<h2>Добавить элемент категории <?php echo $obCurrentCategory->getName(); ?></h2>
<form method="post">
    <input type="hidden" name="action" value="add_property">
    <div class="form-group">
        <label for="name_elem">Название</label>
        <input class="form-control" id="name_elem" name="elem[name]" value="<?php echo $idCurrentElem->getName(); ?>">
    </div>
    <div class="form-group">
        <label for="code_elem">Код</label>
        <input class="form-control" id="code_elem" name="elem[code]" value="<?php echo $idCurrentElem->getCode(); ?>">
    </div>
    <div class="form-group">
        <label for="sort_elem">Сортировка</label>
        <input class="form-control" id="sort_elem" name="elem[sort]" value="<?php echo $idCurrentElem->getSort(); ?>">
    </div>
    <?php
    $obPropOfCurrentCategory = new \Tirei01\Hw12\Storage\Mapper\Property();
    $obCollectOfProps = $obPropOfCurrentCategory->findByCategory($obCurrentCategory);
    /**@var \Tirei01\Hw12\Storage\Property $obCollectOfProp */
    foreach ($obCollectOfProps as $obCollectOfProp) {

        ?>
        <div class="form-group">
            <label for="<?php echo $obCollectOfProp->getCode(); ?>_props"><?php echo $obCollectOfProp->getName(); ?></label>
            <input class="form-control" id="<?php echo $obCollectOfProp->getCode(); ?>_props" name="prop[<?php echo $obCollectOfProp->getCode(
            ); ?>]" value="">
        </div>
        <?php
    }
    ?>


    <input type="submit" class="btn btn-primary"  value="сохранить">
</form>
<?php } ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
