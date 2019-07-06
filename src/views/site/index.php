Добавить событие:
<br>

<br>
<form action="/" class="addEvent">
    Приоритет: <input type="number" name="priority" value=""> 
    <br>
    <br>
    Параметр 1: <input type="text" name="param1" value=""> 
    <br>
    <br>
    Параметр 2: <input type="text" name="param2" value=""> 
    <br>
    <br>
    <input type="button" id="addEventButton" value=" Добавить событие ">
    <input type="button" id="delEventsButton" value=" Очистить события ">
</form>
<hr>
Найти:
<br><br>
<form action="/" class="findEvents">
    Параметр 1: <input type="text" name="param1" value=""> 
    <br>
    <br>
    Параметр 2: <input type="text" name="param2" value=""> 
    <br>
    <br>
    <input type="button" id="findEventsButton" value=" Найти событие ">
</form>
<div id="eventsSearch" style="display: none">
<br><br>

Результат:
<div id="eventsResults">

</div>

</div>


<hr>

Список событий:
<br><br>
<div id="eventsList">
<?php
    foreach ($asset['eventsList'] as $val) {
?>
	<div><?=$val?></div>
    
<?php
    }
?>

</div>