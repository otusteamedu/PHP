<div>
    <div class="form-group row">
        <form id="form_class" name="form_class" method="post" action="/default/editScheduler">
        <div>
            <label for="class">Выбрать класс:</label>
        </div>
        <div>
            <select id="class" name="class">
                <?php foreach($classes as $class): ?>
                    <option value="<?php echo $class->id?>"><?php echo $class->name?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="">
            <button type="submit">Редактировать расписание</button>
            <button type="submit" onclick="ChangeAction('form_class', 'user');">Состав Класса/Группы</button>
        </div>
        </form>
    </div>
</div>
<div>
    <div class="form-group row">
        <form id="form_group" name="form_group" method="post" action="/default/editScheduler">
        <div>
            <label for="class">Выбрать группу:</label>
        </div>
        <div>
            <select id="group" name="group">
                <?php foreach($groups as $group): ?>
                    <option value="<?php echo $group->id?>"><?php echo $group->name?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="">
            <button type="submit">Редактировать расписание</button>
        </div>
        </form>
    </div>
</div>
