Расписание:
<form id="form_scheduler" name="form_scheduler" action="/scheduler/save" method="post">
    <input type="hidden" name="class_id" value="<?php echo $classId;?>"/>
    <input type="hidden" name="group_id" value="<?php echo $groupId;?>"/>
    <table class="graygound">
        <tr>
            <?php
            foreach ($daysOfWeek as $day) {
                echo "<th>&nbsp;</th><th>$day</th>";
            }
            ?>
        </tr>
        <?php for ($i = 1; $i <= $lessonsCount; $i++): ?>
            <tr>
                <?php foreach ($daysOfWeek as $key => $day) : ?>
                    <?php if (isset($editMode) && $editMode === true) : ?>
                        <td><?php echo $i?>)</td>
                        <td>
                            <select name="lesson<?php echo $i . '_' . $key?>">
                                <option value="0">-</option>
                                <?php foreach($lessons as $lesson): ?>
                                    <option <?php echo isset($schedule[$key]['lesson'.$i]) && $schedule[$key]['lesson'.$i] == $lesson->name ? "selected" :''?>
                                            value="<?php echo $lesson->id?>"><?php echo $lesson->name?></option>
                                <?php endforeach;?>
                            </select>
                        </td>
                    <?php else : ?>
                        <td><?php echo $i?>)</td><td><?php echo $schedule[$key]['lesson'.$i] ?? '-'?></td>
                    <?php endif; ?>
                <?php endforeach;?>
            </tr>
        <?php endfor;?>
        <tr><td>&nbsp;</td></tr>
    </table>
    <button class="<?php echo (isset($editMode) && $editMode === true) ? 'visible' : 'invisible'; ?>" type="submit">Сохранить</button>
    <button class="<?php echo (isset($editMode) && $editMode === true) ? 'visible' : 'invisible'; ?>" type="submit" onclick="ChangeAction('form_scheduler', 'default')">Отменить</button>
</form>

