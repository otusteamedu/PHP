<?php if ($data['id'] > 0) { ?>
    <h2>Изменить категорию</h2>
<?php } else {
    ?><h2>Добавить категорию</h2><?php
} ?>
<form method="post">
    <input type="hidden" name="action" value="edit_category">
    <div class="form-group">
        <label for="name_category">Название</label>
        <input class="form-control" id="name_category" name="name" value="<?php echo $data['name']; ?>">
    </div>
    <div class="form-group">
        <label for="code_category">Код</label>
        <input class="form-control" id="code_category" name="code" value="<?php echo $data['code']; ?>">
    </div>
    <div class="form-group">
        <label for="sort_category">Сортировка</label>
        <input class="form-control" id="sort_category" name="sort" value="<?php echo $data['sort']; ?>">
    </div>
    <input type="submit" class="btn btn-primary" value="сохранить">
</form>
<a href="<?php echo $data['back_url']; ?>">К списку</a>