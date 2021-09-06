<?php if (!isset($nodeIp) || isset($nodeIp['error'])):?>
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Что-то не так!</h4>
        <div class="row">
            <div class="col">Node Ip Address:</div>
            <div class="col"><b><?php echo $nodeIp['error']['message']?></b></div>
        </div>
        <hr>
        <p class="mb-0">Необходимо произвести диагностику</p>
    </div>
<?php else :?>
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Проверка прошла успешно!</h4>
        <div class="row">
            <div class="col">Node Ip Address:</div>
            <div class="col"><b><?php echo $nodeIp['info']?></b></div>
        </div>
        <hr>
        <p class="mb-0">Служба работает в штатном режиме</p>
    </div>
<?php endif?>
