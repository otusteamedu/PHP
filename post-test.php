<?php
$form = <<<HERE
<form name="test" method="post" action="testpost">
  <p><b>Строка:</b><br>
   <input type="text" name="str" value="(()()()()))((((()()()))(()()()(((()))))))">
  </p>
  <p><input type="submit" value="Отправить">
   <input type="reset" value="Начальное значение"></p>
 </form>
HERE;
echo $form;