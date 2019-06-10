<?php
//phpinfo();

$dsn = "pgsql:host=postgres;port=5432;dbname=postgres;user=postgres;password=password";

$conn = new PDO($dsn);
