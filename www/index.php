<?php
include_once 'vendor/autoload.php';
$host = 'db';
$db = 'hw5';
$username = 'postgres';
$password = 'newDAy01';
$dsn = "pgsql:host=$host;port=5432;dbname=$db;user=$username;password=$password";

try {
    $conn = \Tirei01\Hw12\Connector::getConnection($dsn);
    $redirect = '';
    $category = $_GET['category'] ? intval($_GET['category']) : 0;
    $property = $_GET['property'] ? intval($_GET['property']) : 0;
    switch ($_POST['action']){
        case 'add_property':
            $obCategory = new \Tirei01\Hw12\Storage\Mapper\Category($conn);
            $obSaveProperty = new \Tirei01\Hw12\Storage\Mapper\Property($conn);
            $saveProperty = new \Tirei01\Hw12\Storage\Property(
                $property,
                $_POST['name'],
                $_POST['type'],
                $obCategory->find($category),
                $_POST['sort'],
                $_POST['code'],
            );
            if($property > 0){
                $obSaveProperty->update($saveProperty);
            }else{
                $obSaveProperty->insert($saveProperty);
            }
            if($saveProperty->getId() > 0){
                $redirect = "Location: /?category=".$category."&property=".$saveProperty->getId();
            }
            break;
        case 'add_category':
            $obSaveCategoryMapper = new \Tirei01\Hw12\Storage\Mapper\Category($conn);
            $saveCategory = new \Tirei01\Hw12\Storage\Category(
                $category,
                $_POST['name'],
                $_POST['sort'],
                $_POST['code'],
            );
            if($category > 0){
                $obSaveCategoryMapper->update($saveCategory);
            }else{
                $obSaveCategoryMapper->insert($saveCategory);
            }
            if($saveCategory->getId() > 0){
                $redirect = "Location: /?category=".$saveCategory->getId();
            }
            break;
    }
    if($redirect){
        header($redirect, TRUE);
    }
    // TODO DEL THIS
    echo "<pre style='color:red; clear: both;'>";
    print_r($_POST);
    echo "</pre>";
    echo "<pre><form method='post'>";
    $curentCategory = null;
    $curentProperty = null;
    $obCategoryMapper = new \Tirei01\Hw12\Storage\Mapper\Category($conn);
    $obCatergoryCollection = $obCategoryMapper->findAll();
    /**@var \Tirei01\Hw12\Storage\Category $obCategory */
    ?>
    <ul>Категории
    <li><a href="/">all</a></li><?php
        $arCurrentCategory = array(
            'id' => 0,
            'name' => '',
            'code' => '',
            'sort' => 500,
        );
    foreach ($obCatergoryCollection as $obCategory) {
        if($_GET['category'] == $obCategory->getId()){
            $curentCategory = $obCategory;
            $arCurrentCategory = array(
                    'id' => $obCategory->getId(),
                    'name' => $obCategory->getName(),
                    'code' => $obCategory->getCode(),
                    'sort' => $obCategory->getSort(),
            );
        }
        ?><li><a href="/?category=<?php echo $obCategory->getId(); ?>"><?php echo  $obCategory->getName(); ?>[<?php echo $obCategory->getCode(); ?>]</a></li><?php
    }
    ?></ul>
    Добавить категорию
    <form method="post">
        <input type="hidden" name="action" value="add_category">
        Название
        <input name="name" value="<?php echo $arCurrentCategory['name']; ?>">
        Код
        <input name="code" value="<?php echo $arCurrentCategory['code']; ?>">
        Сортировка
        <input name="sort" value="<?php echo $arCurrentCategory['sort']; ?>">
        <input type="submit" value="сохранить">
    </form>

    <br /><?
    $obPropertyMapper = new \Tirei01\Hw12\Storage\Mapper\Property($conn);
    if($curentCategory !== null) {
        $arCatPropertys = $obPropertyMapper->findByCategory($curentCategory);
    }else{
        $arCatPropertys = $obPropertyMapper->findAll();
    }
    ?><ul><?php
    $arCurrentProperty = array(
        'id' => 0,
        'name' => '',
        'code' => '',
        'sort' => 500,
        'type' => 'string',
    );

    foreach ($arCatPropertys as $arCatProperty) {
        if($_GET['property'] == $arCatProperty->getId()){
            $curentProperty = $arCatProperty;
            $arCurrentProperty = array(
                'id' => $arCatProperty->getId(),
                'name' => $arCatProperty->getName(),
                'code' => $arCatProperty->getCode(),
                'sort' => $arCatProperty->getSort(),
                'type' => $arCatProperty->getType(),
            );
        }
        ?><li><a href="/?category=<?php echo $arCatProperty->getCategory()->getId(); ?>&property=<?php echo $arCatProperty->getId(); ?>"><?php echo $arCatProperty->getName(); ?></a> </li><?php
    }

    ?></ul>    Добавить свощйство
    <form method="post">
    <input type="hidden" name="action" value="add_property">
    Название
    <input name="name" value="<?php echo $arCurrentProperty['name']; ?>">
    Код
    <input name="code" value="<?php echo $arCurrentProperty['code']; ?>">
    Тип
    <select name="type">
        <option value="string" <?php echo $arCurrentProperty['type'] === 'string' ? 'checked':''; ?>>Строка</option>
        <option value="int" <?php echo $arCurrentProperty['type'] === 'int' ? 'checked':''; ?>>Число</option>
    </select>
    Сортировка
    <input name="sort" value="<?php echo $arCurrentProperty['sort']; ?>">
    <input type="submit" value="сохранить">
    </form><?php

    //va
    $value = new \Tirei01\Hw12\Storage\Value(
            0,
        $curentProperty,
        'Большой зал'
    );

    // TODO DEL THIS
    echo "<pre style='color:red; clear: both;'>";
    print_r($value);
    echo "</pre>";
    $valueMapper = new \Tirei01\Hw12\Storage\Mapper\Value($conn);
    //$valueMapper->insert($value);

    // TODO DEL THIS
    echo "<pre style='color:red; clear: both;'>";
    print_r($value);
    echo "</pre>";

} catch (PDOException $e) {
    // report error message
    echo $e->getMessage();
    echo "<br/>";
    echo $e->getTraceAsString();
}
echo "</form></pre>";
?>
