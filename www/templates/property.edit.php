<?php
/**
 * @var array $data
 */
?>
    <h2>Добавить свойство</h2>
    <form method="post">
        <input type="hidden" name="action" value="edit_property">
        <div class="form-group">
            <?php if ($data['id'] === 0) {
                ?>
                <label for="prop_category">Тип</label>
                <select class="form-control" id="prop_category" name="category_id">
                    <option value="null">. . .</option>
                    <?php foreach ($data['category'] as $category) {
                        ?>
                        <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?>
                        </option>
                        <?php
                    } ?>
                </select>
                <?php
            } else { ?>
                <label for="category_props">Категория</label>
                <input disabled="disabled" class="form-control" id="category_props" name="category_name"
                       value="<?php echo $data['category']['name']; ?>">
                <input class="form-control" name="category_id" type="hidden"
                       value="<?php echo $data['category']['id']; ?>">
            <?php } ?>
        </div>
        <div class="form-group">
            <label for="name_props">Название</label>
            <input class="form-control" id="name_props" name="name" value="<?php echo $data['name']; ?>">
        </div>
        <div class="form-group">
            <label for="code_props">Код</label>
            <input class="form-control" id="code_props" name="code" value="<?php echo $data['code']; ?>">
        </div>
        <div class="form-group">
            <label for="prop_type">Тип</label>
            <select class="form-control" id="prop_type" name="type">
                <option value="null">. . .</option>
                <?php
                foreach ($data['types'] as $type) {
                    ?>
                    <option value="<?php echo $type; ?>" <?php echo $data['type'] === $type ? 'selected'
                        : ''; ?>><?php echo $type; ?>
                    </option><?php
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="sort_props">Сортировка</label>
            <input class="form-control" id="sort_props" name="sort" value="<?php echo $data['sort']; ?>">
        </div>
        <input type="submit" class="btn btn-primary" value="сохранить">
    </form>
    <a href="<?php echo $data['back_url']; ?>">Ксписку</a>
<?php
// TODO DEL THIS
echo "<pre style='color:red; clear: both;'>";
var_dump($data);
echo "</pre>";