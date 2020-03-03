<?php
/**
 * @var array $data
 */
?>
<form method="post">
    <input type="hidden" name="action" value="edit_element">
    <input type="hidden" name="category_id" value="<?php echo $data['category_id']; ?>">
    <div class="form-group">
        <label for="name_elem">Название</label>
        <input class="form-control" id="name_elem" name="elem[name]"
               value="<?php echo $data['name']; ?>">
    </div>
    <div class="form-group">
        <label for="code_elem">Код</label>
        <input class="form-control" id="code_elem" name="elem[code]"
               value="<?php echo $data['code']; ?>">
    </div>
    <div class="form-group">
        <label for="sort_elem">Сортировка</label>
        <input class="form-control" id="sort_elem" name="elem[sort]"
               value="<?php echo $data['sort']; ?>">
    </div>
    <?php
    foreach ($data['properties'] as $codeProp => $property) {
        //$property // property_type
        ?>
        <div class="form-group">
            <label for="<?php echo $codeProp; ?>_props"><?php echo $property['property_name']; ?>(свойство)</label>
            <input class="form-control prop_type_<?php echo $property['property_type'];?>" id="<?php echo $codeProp; ?>_props"
                   name="prop[<?php echo $codeProp; ?>]" value="<?php echo $property['value']; ?>">
        </div>
        <?php
    }
    ?>
    <input type="submit" class="btn btn-primary" value="сохранить">
</form>
<a href="<?php echo $data['back_url']; ?>">К списку</a>
