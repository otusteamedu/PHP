<?php
while (!connection_aborted() || PHP_SAPI == "cli") {

  //Code Logic
  for ($i = 1; $i <= 10000000; $i++)
  {
    $j = $j + $i;
  }

  //sleep 
  sleep(10);
}