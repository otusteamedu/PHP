<?php
// Страница авторизации

// Функция для генерации случайной строки
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
} 

// Соединямся с БД
include_once ($_SERVER['DOCUMENT_ROOT'] . "/parts/func.php"); 
include ("config/db.php");
$error_log = "";


// проверяем на POST
if(isset($_POST['submit']))
{
    // Вытаскиваем из БД запись, у которой логин равняеться введенному
    $query = mysqli_query($link,"SELECT user_id, user_password FROM users WHERE user_login='".trim(mysqli_real_escape_string($link,$_POST['login']))."' LIMIT 1");
    $data = mysqli_fetch_assoc($query);

    // Сравниваем пароли
    if($data['user_password'] === md5(md5(trim($_POST['password']))))
    {
        // Генерируем случайное число и шифруем его
        $hash = md5(generateCode(10));

        if(empty($_POST['not_attach_ip']))
        {
            // Если пользователя выбрал привязку к IP
            // Переводим IP в строку
            $insip = ", user_ip=INET_ATON('".$_SERVER['REMOTE_ADDR']."')";
        }

        $currant_date = date("Y-m-d");

        // Записываем в БД новый хеш авторизации и IP
        mysqli_query($link, "UPDATE users SET last_enter='".$currant_date."', user_hash='".$hash."' ".$insip." WHERE user_id='".$data['user_id']."'");

        // Ставим куки
		setcookie("id", $data['user_id'], time()+60*60*24*30);
        setcookie("hash", $hash, time()+60*60*24*30);
        //setcookie("id", $data['user_id'], time()+60*60*24*30);
        //setcookie("hash", $hash, time()+60*60*24*30,null,null,null,true); // httponly !!!
		
        // Переадресовываем браузер на страницу проверки нашего скрипта
        if (!isset($_GET['url'])) {
            header("Location: /panel/main"); exit();
        } else {
            header("Location: " . $_GET['url']); exit();
        }
        
    }
    else
    {
        $error_log = "Вы ввели неправильный логин/пароль";
    }
} 

if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{   
	
    $query = mysqli_query($link, "SELECT *,INET_NTOA(user_ip) AS `user_ip` FROM users WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");
    $userdata = mysqli_fetch_assoc($query);
    if(($userdata['user_hash'] === $_COOKIE['hash']) && ($userdata['user_id'] === $_COOKIE['id']) or (($userdata['user_ip'] === $_SERVER['REMOTE_ADDR'])  && ($userdata['user_ip'] != 0)))
    {
        if (!isset($_GET['url'])) {
            header("Location: /panel/main"); exit();
        } else {
            header("Location: " . $_GET['url']); exit();
        }
    }
}


$block = "";

$block .= '
<!DOCTYPE html>
<html lang="ru">
<head>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="/styles/login.css?v=22102019">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="apple-touch-icon" sizes="57x57" href="/images/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/images/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/images/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/images/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/images/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/images/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/images/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/images/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/images/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/images/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicons/favicon-16x16.png">
    <link rel="manifest" href="/images/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <title>Вход в образователную систему </title>
</head>
<body>

    <style>
        .logo a {
            background-image: url(/images/icons/'. $settings_logo_sm .') !important;
        }
    </style>
    <div class="err">'.$error_log.'</div>
    <div class="login-center">
        <div class="logo">
            <a href="/"></a>
        </div>
        <form method="POST">
            <h1>Вход в личный кабинет</h1>
            <label>
                <input name="login" type="text" required>
                <div class="move-text">Ваш логин</div>
            </label>
            <label>
                <input name="password" type="password" required>
                <div class="move-text">Ваш пароль</div>
            </label>
            <!--
            <label>
                <div class="checkbox-row">
                
                    <div class="checkbox-col"> 
                        Не прикреплять к IP(не безопасно)
                    </div>
                
                    <div class="checkbox-col">
                        <input type="checkbox" name="not_attach_ip">
                        <div class="checkbox-change"></div>
                    </div>
                </div>
               
            </label>
            -->
            <input name="submit" type="submit" value="Войти">
            <div class="recovery-back">
                <a href="recovery">Восстановить пароль</a>
            </div>
        </form>
    </div>
    <script src="/scripts/jquery.js"></script>
    <script src="/scripts/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="/scripts/jquery.cookie.js"></script>
    <script src="/scripts/common.js"></script>
</body>
</html>';


echo $block;


?>