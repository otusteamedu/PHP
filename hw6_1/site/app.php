<?php
use App\ValidatorEmail;


$email[] = '123456@i.ru';
$email[] = '123456@ru.name.ru';
$email[] = 'login@i.ru';
$email[] = 'логин-1@i.ru';
$email[] = 'login.3@i.ru';
$email[] = 'login.3-67@i.ru';
$email[] = '1login@ru.name.ru';
$email[] = '1login_@i.ru';
$email[] = '_login@i.ru';
$email[] = '_login@ru.name.ru';
$email[] = 'логинlogin@i.ru';
$email[] = 'loginлогин@i.ru';
$email[] = '.123456@i.ru ';
$email[] = '123456-@i.ru';
$email[] = '@123456@i.ru';
$email[] = '123456@.ru';
$email[] = '123456@ru';
$email[] = 'login@.ru';
$email[] = '123456@ru.name.ru.ua';
$email[] = '123456@i.ру';
$email[] = '123456@ru.name.ру';
$email[] = 'roliol27@yandex.ru';
$email[] = 'grigorjev-andrey2011@yandex.ru';
$email[] = 'av.priakhin@gmail.com';


$val= new ValidatorEmail;
$val->validate($email);