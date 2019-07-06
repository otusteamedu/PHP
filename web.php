<?php

if($_SERVER["REQUEST_METHOD"] === "POST")
{
  switch($_SERVER["DOCUMENT_URI"])
  {
    case "/":
      $result = include __DIR__ . "/braces.php";
      print $result;
      break;

    default:
      http_response_code(405);
      print "Method not allowed";
  }
}
elseif($_SERVER["REQUEST_METHOD"] === "GET" || $_SERVER["REQUEST_METHOD"] === "HEAD")
{
  switch($_SERVER["DOCUMENT_URI"])
  {
    case "/":
      $result = "Welcome!";
      print $result;
      break;

    case "/pi":
      ob_start();
      phpinfo(~(2+64));
      print str_ireplace('.e {background', '.e {white-space: nowrap; background', ob_get_clean());
      break;

    default:
      http_response_code(404);
      print "Page not found.";
  }
}
else
{
  http_response_code(405);
  print "Method not allowed";
}
