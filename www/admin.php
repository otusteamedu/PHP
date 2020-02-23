<?php
include_once 'vendor/autoload.php';
try {
    $redirect = '';
    $category = $_GET['category'] ? intval($_GET['category']) : 0;
    $property = $_GET['property'] ? intval($_GET['property']) : 0;
    $value = $_POST['value_id'] ? intval($_POST['value_id']) : 0;
    switch ($_POST['action']) {
        case 'add_property':
            $obCategory = new \Tirei01\Hw12\Storage\Mapper\Category($conn);
            $obSaveProperty = new \Tirei01\Hw12\Storage\Mapper\Property($conn);
            $saveProperty = new \Tirei01\Hw12\Storage\Property(
                $property, $_POST['name'], $_POST['type'], $obCategory->find($category), $_POST['sort'], $_POST['code'],
            );
            if ($property > 0) {
                $obSaveProperty->update($saveProperty);
            } else {
                $obSaveProperty->insert($saveProperty);
            }
            if ($saveProperty->getId() > 0) {
                $redirect = "Location: /admin.php?category=" . $category . "&property=" . $saveProperty->getId();
            }
            break;
        case 'add_category':
            $obSaveCategory = new \Tirei01\Hw12\Storage\Mapper\Category($conn);
            $saveCategory = new \Tirei01\Hw12\Storage\Category(
                $category, $_POST['name'], $_POST['sort'], $_POST['code'],
            );
            if ($category > 0) {
                $obSaveCategory->update($saveCategory);
            } else {
                $obSaveCategory->insert($saveCategory);
            }
            if ($saveCategory->getId() > 0) {
                $redirect = "Location: /admin.php?category=" . $saveCategory->getId();
            }
            break;
        case 'add_value':
            $obSaveValue = new \Tirei01\Hw12\Storage\Mapper\Value($conn);
            $obSaveProperty = new \Tirei01\Hw12\Storage\Mapper\Property($conn);
            $obValueUpdate = new \Tirei01\Hw12\Storage\Value(
                $value, $obSaveProperty->find($property), $_POST['i_value'], $_POST['s_value'],
            );
            if ($value > 0) {
                $obSaveValue->update($obValueUpdate);
            } else {
                $obSaveValue->insert($obValueUpdate);
            }
            if ($obValueUpdate->getId() > 0) {
                $redirect = "Location: /admin.php?category=" . $category . "&property=" . $property;
            }
            break;
    }
    if ($redirect) {
        header($redirect, true);
    }
    echo "<form method='post'>";
    $curentCategory = null;
    $curentProperty = null;
    $obCategoryMapper = new \Tirei01\Hw12\Storage\Mapper\Category($conn);
    $obCatergoryCollection = $obCategoryMapper->findAll();
    /**@var \Tirei01\Hw12\Storage\Category $obCategory */
    ?>
    <ul>Категории
        <li><a href="/admin.php">all</a></li><?php
        $arCurrentCategory = array(
            'id' => 0,
            'name' => '',
            'code' => '',
            'sort' => 500,
        );
        foreach ($obCatergoryCollection as $obCategory) {
            if ($_GET['category'] == $obCategory->getId()) {
                $curentCategory = $obCategory;
                $arCurrentCategory = array(
                    'id' => $obCategory->getId(),
                    'name' => $obCategory->getName(),
                    'code' => $obCategory->getCode(),
                    'sort' => $obCategory->getSort(),
                );
            }
            ?>
            <li><a href="/admin.php?category=<?php echo $obCategory->getId(); ?>"><?php echo $obCategory->getName(); ?>
                [<?php echo $obCategory->getCode(); ?>]</a></li><?php
        }
        ?></ul>
    <h2>Добавить категорию</h2>
    <form method="post">
        <input type="hidden" name="action" value="add_category">
        <div class="form-group">
            <label for="name_category">Название</label>
            <input class="form-control" id="name_category" name="name" value="<?php echo $arCurrentCategory['name']; ?>">
        </div>
        <div class="form-group">
            <label for="code_category">Код</label>
            <input class="form-control" id="code_category" name="code" value="<?php echo $arCurrentCategory['code']; ?>">
        </div>
        <div class="form-group">
            <label for="sort_category">Сортировка</label>
            <input class="form-control" id="sort_category" name="sort" value="<?php echo $arCurrentCategory['sort']; ?>">
        </div>
        <input type="submit"  class="btn btn-primary" value="сохранить">
    </form>

    <br/><?
    $obPropertyMapper = new \Tirei01\Hw12\Storage\Mapper\Property($conn);
    if ($curentCategory !== null) {
        $arCatPropertys = $obPropertyMapper->findByCategory($curentCategory);

        ?>
        <ul><?php
            $arCurrentProperty = array(
                'id' => 0,
                'name' => '',
                'code' => '',
                'sort' => 500,
                'type' => 'string',
            );

            foreach ($arCatPropertys as $arCatProperty) {
                if ($_GET['property'] == $arCatProperty->getId()) {
                    $curentProperty = $arCatProperty;
                    $arCurrentProperty = array(
                        'id' => $arCatProperty->getId(),
                        'name' => $arCatProperty->getName(),
                        'code' => $arCatProperty->getCode(),
                        'sort' => $arCatProperty->getSort(),
                        'type' => $arCatProperty->getType(),
                    );
                }
                ?>
                <li><a href="/admin.php?category=<?php echo $arCatProperty->getCategory()->getId(
                ); ?>&property=<?php echo $arCatProperty->getId(); ?>"><?php echo $arCatProperty->getName(); ?></a>
                </li><?php
            }

            ?></ul>
        <h2>Добавить свойство</h2>
        <form method="post">
        <input type="hidden" name="action" value="add_property">
        <div class="form-group">
            <label for="name_props">Название</label>
            <input class="form-control" id="name_props" name="name" value="<?php echo $arCurrentProperty['name']; ?>">
        </div>
        <div class="form-group">
            <label for="code_props">Код</label>
            <input class="form-control" id="code_props" name="code" value="<?php echo $arCurrentProperty['code']; ?>">
        </div>
        <div class="form-group">
            <label for="prop_type">Тип</label>
            <select class="form-control" id="prop_type" name="type">
                <option value="string" <?php echo $arCurrentProperty['type'] === 'string' ? 'checked' : ''; ?>>Строка
                </option>
                <option value="int" <?php echo $arCurrentProperty['type'] === 'int' ? 'checked' : ''; ?>>Число</option>
            </select>
        </div>
        <div class="form-group">
            <label for="sort_props">Сортировка</label>
            <input class="form-control" id="sort_props" name="sort" value="<?php echo $arCurrentProperty['sort']; ?>">
        </div>
        <input type="submit" class="btn btn-primary"  value="сохранить">
        </form><?php

    }

} catch (PDOException $e) {
    echo "<pre>";
    echo $e->getMessage();
    echo "<br/>";
    echo $e->getTraceAsString();
    echo "</pre>";
}

?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">