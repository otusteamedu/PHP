<?php
class validator{
  public $badReqest=false;
  public $postdata;
  public $bracketClose=0;
  public $bracketOpen=0;

function isRequest(){
    $this->postdata = urldecode(file_get_contents("php://input"));
    $string = str_split($_POST['string']); 
    for($i=0; $i<count($string); $i++){
        if($string[$i]==")")
        {
            $this->bracketClose++;               
        }else if($string[$i]=="(")
        {
            $this->bracketOpen++;
        }
    }
}
function isValid () {
    if (empty($this->postdata)) {
       $this->badReqest=true;
    } else if (mb_strlen($this->postdata) != 48 && !empty($this->postdata)) {
       $this->badReqest=true;
    } else if($this->bracketClose!=21|| $this->bracketOpen!=20){
         $this->badReqest=true;
    }
}
function sendMessage(){
     if($this->badReqest){
        header("HTTP/1.1 400 Bad Request");
        echo "Ошибка отправки 400 Bad Request";
     }else if(!$this->badReqest){
        header('HTTP/1.1 200 OK;');
        echo "Удачная отправка 200 OK";

     }
    }
function validate(){
    if ($_POST['string']) {
        $this->isRequest();
        $this->isValid ();
        $this->sendMessage();
    }
}
   
}

$valid= new validator;
$valid->validate();
?>
<html>
<body>
<button onclick="redir()">Next Page</button>
<div id="redirect"></div>
<script>
function redir() {
  document.getElementById('redirect').innerHTML = '<form style="display:none;" position="absolute" method="post" action="/"><input id="redirbtn" type="submit" name="string" value="(()()()()))((((()()()))(()()()(((()))))))"></form>';
  document.getElementById('redirbtn').click();
}
  </script>
</body>
</html>