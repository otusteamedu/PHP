<?php

$_POST += ["string" => ""];

return (
  function()
  {
    if(!strlen($_POST["string"]))
    {
      http_response_code(400);
      return "Input is missing or is empty";
    }

    $balance = 0;
    foreach(str_split($_POST["string"]) as $i => $chr)
    {
      if($chr === "(")
      {
        $balance++;
        $pos = $i + 1;
      }
      elseif($chr === ")")
      {
        $balance--;
        $pos = $i + 1;
        if($balance < 0)
        {
          break;
        }
      }
    }

    if($balance)
    {
      http_response_code(400);
      return "Unbalanced bracket found at position $pos";
    }

    return "Balance is fine";
  }
)();
