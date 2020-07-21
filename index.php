<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="FsBrowser.css">
    <title>Document</title>
</head>

<body>
    <h1>Directory contents:</h1>

</body>

</html>

<?php
require 'functions.php';

// NU SKAITOMA DEFAULT DIREKTORIJA, VISKAS SUDEDAMA Į LENTELĘ
go_home();

if (isset($_GET['path'])) {
    go_to($_GET['path']);
}