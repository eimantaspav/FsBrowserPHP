<?php
session_start();

// Download logic 
if (isset($_POST['download'])) {
    $dlFilePath = './' . $_GET["path"] . '/' . $_POST['download'];
    $dlFilePathFixed = str_replace("&nbsp;", " ", htmlentities($dlFilePath, null, 'utf-8'));
    ob_clean();
    ob_start();
    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename=' . basename($dlFilePathFixed));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($dlFilePathFixed));
    readfile($dlFilePathFixed);
    ob_flush();
    exit;
}

// Upload logic 
if (isset($_FILES['upload'])) {
    $errors = array();
    $file_name = $_FILES['upload']['name'];
    $file_size = $_FILES['upload']['size'];
    $file_tmp = $_FILES['upload']['tmp_name'];
    $file_type = $_FILES['upload']['type'];
    $file_ext = strtolower(end(explode('.', $_FILES['upload']['name'])));

    $extensions = array("txt", "jpeg", "jpg", "png", "pdf");

    if (in_array($file_ext, $extensions) === false) {
        $errors[] = "extension not allowed, please choose a JPEG, PNG or PDF file.";
    }

    if ($file_size > 2097152) {
        $errors[] = 'File size must be below 2 MB';
    }

    if (empty($errors) == true) {
        move_uploaded_file($file_tmp, './' . $_GET["path"] . '/' . $file_name);
    } else {
        echo ($_FILES);
        echo ('<br>');
        print_r($errors);
    }
}

// Login logic 
$loginErrorMsg = '';
if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
    if ($_POST['username'] == 'Eimantas' && $_POST['password'] == '123') {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = 'Eimantas';
    } else {
        $loginErrorMsg = 'Wrong username or password';
    }
}

// Logout logic 
if (isset($_POST['logout'])) {
    session_start();
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    unset($_SESSION['logged_in']);
    header("Refresh:0");
}

// New dir logic 
if (isset($_POST['new_dir'])) {
    $pathForNewDir = './' . $_GET['path'] . '/' . $_POST['new_dir'];
    mkdir($pathForNewDir, 0755, true);
}

// Deletion logic 
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
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="FsBrowser.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php

    // Login form 
    if (!$_SESSION['logged_in'] == true) {
        echo '<div class="form">
        <form class="login" action="" method="POST">
        <input class="login_input" type="text" name="username" placeholder="Eimantas" required autofocus></br>
        <input class="login_input" type="password" name="password" placeholder="123" required><br>
        <button class="login_btn" type="submit" name="login">Login</button>
        </form></div>
        <h1>' . $loginErrorMsg . '<h1>';
        die();
    }

    // Dirs and btns 
    echo '<h1>Directory contents:</h1>';
    echo '<p class="currentDir">Current directory: ' . $_GET['path'] . '</p>';
    $path = opendir('./' . str_replace('./', './' . $_GET['path'], './'));
    echo '<table cellpadding="10">'
        . '<tr class="info">'
        . '<td>' . 'TYPE' . '</td>'
        . '<td>' . 'NAME' . '</td>'
        . '<td>' . 'ACTION' . '</td>'
        . '</tr>';
    while (($fName = readdir($path)) !== FALSE) {
        if ($fName != '.' && $fName != '..' && $fName != '.git' && get_file_extension($fName) == 'dir') {
            echo '<tr>' . '<td class="extension">' . get_file_extension($fName) . '</td>'
                . '<td class="fnames">' . '<a href="index.php?path=' . $_GET['path'] .  '/' . $fName . '">' . $fName . '</td>';
        }
        if ($fName != '.' && $fName != '..' && $fName != '.git' && get_file_extension($fName) != 'dir') {
            echo '<tr>' . '<td class="extension">' . get_file_extension($fName) . '</td>'
                . '<td class="fnames">' . $fName . '</td>'
                . '<td class="buttonTD"><form method="POST">
             <input type="hidden" name="del" value=' . str_replace(' ', '&nbsp;', $fName) . '>
             <input class="buttons" type="submit" value="DELETE">
            </form>
            <form   style="display: inline-block" action="" method="post">
            <input type="hidden" name="download" value="' . str_replace(' ', '&nbsp;', $fName) . '">
            <input class="buttons" type="submit" value="DOWNLOAD">
           </form></td>';
        }
    }
    echo '</table>';
    echo '<form class="new_Dir" method="POST">
<input type="text" name="new_dir" value="">
<input  class="new_Dir_submit"type="submit" value="Create Directory">
</form></td>';


    echo '<br>
<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="upload" id="img" style="display:none;"/>
<button class="uploadBtn1" type="button">
<label for="img">Choose file</label>
</button>
<button class="uploadBtn2" type="submit">Upload file</button>
 </form><br>';

    if ($_SERVER['REQUEST_URI'] != '/FsBrowserPHP/' && $_SERVER['REQUEST_URI'] != '/FsBrowserPHP/index.php?path=') {
        echo '<td>' . '<a class="btn" href="' . dirname($_SERVER['REQUEST_URI'], 1) . '">BACK</a></td>';
    }
    echo '<br>';
    if ($_SERVER['REQUEST_URI'] != '/FsBrowserPHP/' && $_SERVER['REQUEST_URI'] != '/FsBrowserPHP/index.php?path=') {
        echo '<td>' . '<a class="btn" href="./">HOME</a></td><br>';
    }

    echo ('<div><form action="" method="POST">');
    echo ('<input type="hidden" name="logout">');
    echo ('<button class="logout_btn" type="submit">Logout</button>');
    echo ('</form></div>');
    ?>
</body>

</html>
<?php

function get_file_extension($file_name)
{
    if (pathinfo($file_name, PATHINFO_EXTENSION) == '') {
        return "dir";
    } else {
        return pathinfo($file_name, PATHINFO_EXTENSION);
    }
}

?>