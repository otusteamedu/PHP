
<?php
class WebApp
{
    public $postdata;
    public $socket;
    public $string = '(()()()()))((((()()()))(()()()(((()))))))';
    public $posts = 'string=';
    public $contentsno = true;
    public $content;
    public $subStrContent;
   

    public function getContents()
    {
        if ($_POST['string']) {
            $this->contentsno = false;
            $this->postdata = file_get_contents("php://input");
            if (empty($this->postdata)) {
                header("HTTP/1.1 400 Bad Request");
            } else if (mb_strlen($this->postdata) != 48) {
                header("HTTP/1.1 400 Bad Request");
            } else {
                header('HTTP/1.1 200 OK;');
                echo $this->postdata;
            }
         
        }
    }

    public function openSocket()
    {
        $this->posts .= $this->string;
        $this->socket = fsockopen('mysite.local', 80, $errno, $errstr, 60);
        if (!$this->socket) {
            echo "$errstr ($errno)<br/>\n";
        }
    }
    public function socketWrite()
    {
        fwrite($this->socket, "POST / HTTP/1.1\r\n");
        fwrite($this->socket, "Host: mysite.local\r\n");
        fwrite($this->socket, "Content-Type: application/x-www-form-urlencoded\r\n");
        fwrite($this->socket, "Content-Length: " . strlen($this->posts) . "\r\n");
        fwrite($this->socket, "Connection:close\r\n\r\n");
        fwrite($this->socket, $this->posts);
    }
    public function socketRead()
    {
        while (!feof($this->socket)) {
            $this->content .= fgets($this->socket, 1024);
        }
    }
    public function subContent()
    {
        $pos = strpos($this->content, "Server: nginx");
        $this->subStrContent = mb_strimwidth($this->content, 0, $pos);
    }
    public function stadinContent()
    {
        echo $this->subStrContent;
        if (strlen($this->subStrContent) == 17) {
            echo "Верный запрос";
        } else {
            echo "Не верный запрос";
        }
    }
    public function isRequest(){
      if($this->contentsno){
        $this->openSocket();
        $this->socketWrite();
        $this->socketRead();
        $this->subContent();
        $this->stadinContent();

      }


    }
}

$web= new WebApp();
$web->getContents();
$web->isRequest();
?>


<html>
<body>
</body>
</html>