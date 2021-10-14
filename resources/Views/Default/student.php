<div>
    <p>Класс в котором вы учитесь: <b><?php echo $user->getSchoolClass();?></b></p>
    <?php if (!empty($user->getGroup())) : ?>
        <p>Вы состоите в группе: <b><?php echo $user->getGroup();?></b></p>
    <?php endif; ?>
</div>
