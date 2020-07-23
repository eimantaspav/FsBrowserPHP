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


// KELIO KINTAMASIS, KURI PADUODU NUSKAITYTI VELIAU SU READDIR();
$path = opendir('./' . str_replace('./', './' . $_GET['path'], './'));
// LENTELES PRADZIA
echo '<table cellpadding="10">'
    . '<tr class="info">'
    . '<td>' . 'TYPE' . '</td>'
    . '<td>' . 'NAME' . '</td>'
    . '<td>' . 'ACTION' . '</td>'
    . '</tr>';
// NUSKAITOMAs IR I LENTELE SUDEDAMAS PADUOTOS DIREKTORIJOS TURINYS
while (($fName = readdir($path)) !== FALSE) {
    // NESPAUSDINAMI ./, ..', .git FOLDERIAI, FOLDERIAMS PAGAL JU EXTENSIONO LYGYBE PRISKIRIAMAS <a> ELEMENTAS
    if ($fName != '.' && $fName != '..' && $fName != '.git' && get_file_extension($fName) == 'dir') {
        echo '<tr>' . '<td>' . get_file_extension($fName) . '</td>'
            . '<td>' . '<a href="index.php?path=' . $_GET['path'] .  '/' . $fName . '">' . $fName . '</td>'
            . '<td>PLACEHOLDER</td>';
    }
    // NESPAUSDINAMI ./, ..', .git FOLDERIAI, FAILAI NEGAUNA <a> ELEMENTO
    if ($fName != '.' && $fName != '..' && get_file_extension($fName) != 'dir') {
        echo '<tr>' . '<td>' . get_file_extension($fName) . '</td>'
            . '<td>' . $fName . '</td>'
            . '<td>' . 'PLACEHOLDER' . '</td>' . '</tr>';
    }
}
echo '</table>';
// GRIZIMAS VIENA DIREKTORIJA ATGAL
echo '<td>' . '<a href="' . dirname($_SERVER['REQUEST_URI'], 1) . '">BACK</td>';
echo '<br>';
// GRIZIMAS I PRADINE DIREKTORIJA 
echo '<td>' . '<a href="./">HOME</td>';
echo '<br>';
// SPAUSDINAMA INFORMACIJA
echo '$_GET path ---' . $_GET['path'] . '<br>';
echo '$_SERVER[QUERY_STRING] ---' . $_SERVER['QUERY_STRING'] . '<br>';
echo '$_SERVER[REQUEST_URI]---' . $_SERVER['REQUEST_URI'] . '<br>';



?>

<!-- JAVA SCRIPT -->
<script>

</script>