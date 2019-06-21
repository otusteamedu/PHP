<?php
require 'vendor/autoload.php';

use AZ\Zolotukhin\Mail\Mailchecker;

$checked_msg = false;
$email = '';

if (!empty($_POST['email'])) {
    $email = strip_tags($_POST['email']);

    $mailCheck = new Mailchecker();

    list($result, $response) = $mailCheck->mailCheck($email);

    if (is_array($response)) {

        if (!empty($result)) {

            $checked_msg = '<div class="alert alert-success" role="alert">
                                Email exist!
                            </div>';

            $checked_msg .= '<div><h3 class="text-center">Detailed info</h3>';

            foreach ($response as $key => $data) {
                if (!empty($key)) {
                    $checked_msg .= "<br><br>";
                }
                $checked_msg .= "Domain: " . $data['host']
                              . "<br>Class: " . $data['class']
                              . "<br>TTL: " . $data['ttl']
                              . "<br>Type: " . $data['type']
                              . "<br>PRI: " . $data['pri']
                              . "<br>mail server: " . $data['target']
                              . "<br>Server IP: " . gethostbyname($data['target']) ;
            }
            $checked_msg .= '</div>';

        } else {
            $checked_msg = '<div class="alert alert-danger" role="alert">
                                Email not exist!
                            </div>';
        }
    } else {
        $checked_msg = '<div class="alert alert-warning" role="alert">
                                Email not correct!
                        </div>';
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Mail checker</title>
</head>
<body>

<div class="row justify-content-center">
    <div class="col-4">
        <h1>Checking email for exist</h1>
        <div><?= $checked_msg ?></div>
        <form action="" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Email:</label>
                <input type="email"
                       class="form-control"
                       id="exampleInputEmail1"
                       aria-describedby="emailHelp"
                       name="email"
                       value="<?= $email ?>"
                       placeholder="Enter email here"
                >
            </div>
            <button type="submit" class="btn btn-primary">Check it!</button>
        </form>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>


