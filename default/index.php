<?php
// поверяем есть ли переменная string в POST и не пустая ли она.
if (empty($_POST['string'])) {
  // если пусто шлем код 400
  http_response_code(400);
  exit;
}
// не пусто - код 200
http_response_code(200);

