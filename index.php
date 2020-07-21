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
// FUNKCIJU PAEMIMAS
require 'functions.php';

// NUSKAITOMA DEFAULT DIREKTORIJA, VISKAS SUDEDAMA Į LENTELĘ
go_home();

// EJIMAS I KITAS DIREKTORIJAS
if (isset($_GET['path'])) {
    go_to($_GET['path']);
}
?>

<!-- JAVA SCRIPT -->
<script>
    // FUNKCIJA SLEPTI TURINIUI PAGAL JO ID
    function toggleDisplay() {
        var x = document.getElementById("dir");
        var y = document.getElementById("home_table");
        y.style.display = "none";
    }
    // ONCLICK TESTAS
    function test() {
        console.log('testas');
    }
</script>