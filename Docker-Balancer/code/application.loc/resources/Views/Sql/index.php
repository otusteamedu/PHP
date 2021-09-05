<?php if (!isset($sql) || isset($sql['info']['error'])):?>
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Что-то не так!</h4>
        <div class="row">
            <div class="col"><?php echo $sql['title'] ?? 'ERROR!'?></div>
            <div class="col"><b><?php echo $sql['info']['error']['message']?></b></div>
        </div>
        <hr>
        <p class="mb-0">Необходимо произвести диагностику</p>
    </div>
<?php else :?>
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Проверка прошла успешно!</h4>
        <div class="row">
            <div class="col"><?php echo $sql['title'] ?? ''?></div>
            <div class="col"><b><?php echo $sql['info']['serverInfo'];?></b></div>
        </div>
        <hr>
        <p class="mb-0">Служба работает в штатном режиме</p>
    </div>
<?php endif?>


