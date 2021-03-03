<?php
	require('header.php');
?>

<body>
	<div class="container-fluid ml-4 mr-4">
        <h1>Форма проверки строки</h1>

        <p>Проверка строки (()()()()))((((()()()))(()()()(((()))))))</p>
        <form method="POST" class="container-fluid" action="check.php">
            <div class="form-group row">
                <input class="form-control col-7" name="string"><br />
                <div class="col-5">
                    <button class="btn btn-primary" type="submit">Отправить</button>
                </div>
            </div>
        </form>
    </div>
</body>