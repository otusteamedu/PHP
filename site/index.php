<?php
class validator{
  public $badReqest=false;
  public $postdata;
  public $bracketsBalansno=false;

  public function isRequest(){
    $this->postdata = urldecode(file_get_contents("php://input"));
    $this->bracketsValidator($_POST["string"]);
}

public function bracketsValidator($string){
        $new_string = preg_replace('/[^\(\)]/', '', $string);
        if (!empty($new_string)) {
            $this->bracketsBalansno= $this->correctBracket($string);
        }
    
}
public function correctBracket($string)
{
    if (!empty($string)) {
        $rep_string = preg_replace('/[\(]{1}[\)]{1}/', '', $string, $limit = -1, $count);
        if ($count > 0) {
            return $this->correctBracket($rep_string);
        } else {
          return true;
        }
    }
    return false;
}

function isValid () {
    if (empty($this->postdata)) {
       $this->badReqest=true;
    } else if (mb_strlen($this->postdata) != 47 && !empty($this->postdata)) {
      $this->badReqest=true;
    } else if($this->bracketsBalansno){
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
        document.getElementById('redirect').innerHTML =
            '<form style="display:none;" position="absolute" method="post" action="/"><input id="redirbtn" type="submit" name="string" value="(((((((((((((((((((())))))))))))))))))))"></form>';
        document.getElementById('redirbtn').click();
    }
    </script>
</body>

</html>