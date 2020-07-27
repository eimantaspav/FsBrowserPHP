<?php
session_set_cookie_params(10);
session_start();
$loginErrorMsg = '';
if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
    if ($_POST['username'] == 'Eimantas' && $_POST['password'] == '123') {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = 'Eimantas';
    } else {
        $loginErrorMsg = 'Wrong username or password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="FsBrowser.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<script>
    function hi(name) {

        console.log('' + name);
    }
</script>

<body>
</body>

</html>

<?php

// FUNKCIJU PAEMIMAS
require 'functions.php';

if (!$_SESSION['logged_in'] == true) {
    echo ('<div class="form"><form class="login" action="" method="POST">');
    echo ('<input type="text" name="username" placeholder="Eimantas" required autofocus></br>');
    echo ('<input type="password" name="password" placeholder="123" required><br>');
    echo ('<button class="login_btn" type="submit" name="login">Login</button>');
    echo ('</form></div>');
    echo ('<h1>' . $loginErrorMsg . '<h1>');
    die();
}


$username = $_SESSION['username'];

echo '<h1>Directory contents:</h1>';

echo '<p class="currentDir">Current directory: ' . $_GET['path'] . '</p>';

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
        echo '<tr>' . '<td class="extension">' . get_file_extension($fName) . '</td>'
            . '<td class="fnames">' . '<a href="index.php?path=' . $_GET['path'] .  '/' . $fName . '">' . $fName . '</td>';
    }
    // NESPAUSDINAMI ./, ..', .git FOLDERIAI, FAILAI NEGAUNA <a> ELEMENTO
    if ($fName != '.' && $fName != '..' && $fName != '.git' && get_file_extension($fName) != 'dir') {
        echo '<tr>' . '<td class="extension">' . get_file_extension($fName) . '</td>'
            . '<td class="fnames">' . $fName . '</td>'
            . '<td class="buttonTD"><form method="POST">
             <input type="hidden" name="del" value=' . str_replace(' ', '&nbsp;', $fName) . '>
             <input class="buttons" type="submit" value="DELETE">
            </form>
            <form   style="display: inline-block" action="" method="post">
            <input type="hidden" name="download" value=' . str_replace(' ', '&nbsp;', $fName) . '>
            <input class="buttons" type="submit" value="DOWNLOAD">
           </form></td>';
    }
}
echo '</table>';
// NAUJOS DIREKTORIJOS FORMA IR SUKURIMO LOGIKA
echo '<form class="new_Dir" method="POST">
<input type="text" name="new_dir" value="">
<input  class="new_Dir_submit"type="submit" value="Create Directory">
</form></td>';

if (isset($_POST['new_dir'])) {
    $pathForNewDir = './' . $_GET['path'] . '/' . $_POST['new_dir'];
    mkdir($pathForNewDir, 0755, true);
    header("Refresh:0");
}

// UPLOAD 
echo '<br>
<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="upload" id="img" style="display:none;"/>
<button class="uploadBtn1" type="button">
<label for="img">Choose file</label>
</button>
<button class="uploadBtn2" type="submit">Upload file</button>
 </form>
<br>';



if (isset($_GET['action']) and $_GET['action'] == 'logout') {
    session_start();
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    unset($_SESSION['logged_in']);
}




// GRIZIMAS VIENA DIREKTORIJA ATGAL, MYGTUKAS NEKURIAMAS PRADINEJE DIREKTORIJOJE
if ($_SERVER['REQUEST_URI'] != '/FsBrowserPHP/' && $_SERVER['REQUEST_URI'] != '/FsBrowserPHP/index.php?path=') {
    echo '<td>' . '<a class="btn" href="' . dirname($_SERVER['REQUEST_URI'], 1) . '">BACK</a></td>';
}
echo '<br>';
// GRIZIMAS I PRADINE DIREKTORIJA, MYGTUKAS NEKURIAMAS PRADINEJE DIREKTORIJOJE 
if ($_SERVER['REQUEST_URI'] != '/FsBrowserPHP/' && $_SERVER['REQUEST_URI'] != '/FsBrowserPHP/index.php?path=') {
    echo '<td>' . '<a class="btn" href="./">HOME</a></td>';
}
echo '<br>';

echo ('<div><form action="logout" method="POST">');
echo ('<button class="logout_btn" type="submit" name="logout">LOGOUT</button>');
echo ('</form></div>');
// file download logic
if (isset($_POST['download'])) {
    $dlFilePath = './' . $_GET["path"] . '/' . $_POST['download'];
    $dlFilePathFixed = str_replace("&nbsp;", " ", htmlentities($dlFilePath, null, 'utf-8'));
    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename=' . basename($dlFilePathFixed));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($dlFilePathFixed));
    readfile($dlFilePathFixed);
    exit;
}

// file upload logic
if (isset($_FILES['upload'])) {
    $errors = array();
    $file_name = $_FILES['upload']['name'];
    $file_size = $_FILES['upload']['size'];
    $file_tmp = $_FILES['upload']['tmp_name'];
    $file_type = $_FILES['upload']['type'];
    $file_ext = strtolower(end(explode('.', $_FILES['upload']['name'])));

    $extensions = array("jpeg", "jpg", "png", "pdf");

    if (in_array($file_ext, $extensions) === false) {
        $errors[] = "extension not allowed, please choose a JPEG, PNG or PDF file.";
    }

    if ($file_size > 2097152) {
        $errors[] = 'File size must be below 2 MB';
    }

    if (empty($errors) == true) {
        move_uploaded_file($file_tmp, './' . $_GET["path"] . '/' . $file_name);
        //    echo "Success";
    } else {
        echo ($_FILES);
        echo ('<br>');
        print_r($errors);
    }
}

// JEIGU REIKES ATSISPAUSDINTI INFO
// echo '$_GET path ---' . $_GET['path'] . '<br>';
// echo '$_SERVER[QUERY_STRING] ---' . $_SERVER['QUERY_STRING'] . '<br>';
// echo '$_SERVER[REQUEST_URI]---' . $_SERVER['REQUEST_URI'] . '<br>';

// FAILO ISTRYNIMO LOGIKA
if (isset($_POST['del'])) {
    $pathDelFile = './' . $_GET['path'] . '/' . $_POST['del'];
    $pathDelFileFixed = str_replace("&nbsp;", " ", htmlentities($pathDelFile, null, 'utf-8'));
    if (is_file($pathDelFileFixed)) {
        if (file_exists($pathDelFileFixed)) {
            unlink($pathDelFileFixed);
            header("Refresh:0");
        }
    }
}

?>

<!-- JAVA SCRIPT -->