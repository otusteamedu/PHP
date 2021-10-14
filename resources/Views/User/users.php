<div class="form-group row">
    <div class="col-md-2">
        <form>
        <div>
            <label for="class">Ученики класса</label>
        </div>
        <select id="users" name="users" onchange="ChangeUser(this);">
            <option value="0">-</option>
            <?php foreach($users as $user): ?>
                <option value="<?php echo $user->id?>"><?php echo $user->first_name . " " . $user->last_name?></option>
            <?php endforeach;?>
        </select>
        </form>
    </div>
    <div class="col-md-2">
        <div>
            <b>Ученик: </b>
            <span id="userName" name="userName"></span>
        </div>
        <div>
            <b>Класс: </b>
            <span id="userClass" name="userClass"></span>
        </div>
    </div>
    <div class="col-md-2">
        <form id="form_group" name="form_group" method="post">
            <div>
                <label for="class">Входит в группу</label>
            </div>
            <div>
                <select id="groups" name="groups" onchange="ChangeGroup(this);">
                    <option value="0">-</option>
                    <?php foreach($groups as $group): ?>
                        <option value="<?php echo $group->id?>"><?php echo $group->name?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <button type="button" onclick="changeUserGroup();">Сменить</button>
        </form>
    </div>
    <div class="col-md-2">
        <form method="post">
            <div>
                <label for="class">Список учеников в группе <b id="groupUsersCount" name="groupUsersCount"></b></label>
            </div>
            <div>
                <div id="groupUsers" name="groupUsers">
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-2">
        <form id="form_back" method="post" action="/default">
            <button type="submit">Вернуться</button>
        </form>
    </div>
</div>

