<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
    <style>
        p {
            text-align: center;
        }
    </style>
</head>
<body>
<center>
    <p style="border:20px slategrey ridge; border-radius: 50px; width: 150px; padding: 10px 5px;" >
        <?php
        require __DIR__ . '/./vendor/autoload.php';
        use www\src\MxEmailValidator;
        use www\src\SyntaxEmailValidator;

        echo $_SERVER['SERVER_ADDR'];
        ?>
    </p>
    <h1>Email Verification!</h1>
    <fieldset> <legend>Enter email to validate</legend>
        <p><label>
                <form action = "index.php" method="POST">
                <input type="text" name="email" placeholder="example@mail.com"/>
            </label></p>
    <h2>
        <?php
            if (isset($_POST['email'])) {
                $a = new SyntaxEmailValidator();
                $b = new MxEmailValidator();

                    if ($a->validate($_POST['email']) && $b->validate($_POST['email'])) {
                        echo "GOOD EMAIL!";
                    }
                    else {
                        echo "BAD EMAIL!";
                    }
            }
        ?>
    </h2>
</center>
</body>
</html>




