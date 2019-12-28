<? include '../vendor/autoload.php'; ?>

<h1>Проверка парности скобок</h1>

<?
$arData2Chk = [
    '((())())',
    '(()()()()))((((()()()))(()()()(((()))))))',
    ' (()())()))(((()()()))(()()()(((()',
    'Lorem ipsum',
    ')(',
];

foreach ($arData2Chk as $v) {

    try{
        if (\Webfarrock\ChkBrakets::run($v)) {
            echo "\"{$v}\" <b>valid</b><br>";
        } else {
            echo "\"{$v}\" <b>not valid</b><br>";
        }
    }catch (\InvalidArgumentException $e){
        echo '<div style="color:red">Передана не корректная строка: '.$e.'</div>';
    }

}
?>




