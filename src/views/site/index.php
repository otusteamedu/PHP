<div class="left">
<h3>Оставить свой отыв о нашей работе</h3>
<form id="sendFeedback">
<textarea style="width: 400px; height: 250px;" id="msgText"></textarea><br>
<button id="sendBtn">Отправить</button>
</form>
<br>
<br>
<h3>Отзывы:</h3>
<?php
foreach ($asset['feedbackList'] as $indx => $val) {?>

<?=substr($val['msgDate'], 0, 16)?><br>
<?=$val['msgText']?><br>
<?php
if ($val['msgAnswer'] != '') {?>
    <b>Ответ:</b><br><span style="color: red;"><?=$val['msgAnswer']?></span><br>
<?
}
?>
<hr>

<?php
}
?>
</div>
<div class="left">
<h3>Администратор</h3>
<div id="requestList">

</div>
</div>