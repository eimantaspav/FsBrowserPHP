<?php

// GAUNAMAS FAILO TIPO GALUNE KAIP STRINGAS, JEIGU TAI FOLDERIS, GAUNAMA 'DIR'
function get_file_extension($file_name)
{
    if (pathinfo($file_name, PATHINFO_EXTENSION) == '') {
        return "dir";
    } else {
        return pathinfo($file_name, PATHINFO_EXTENSION);
    }
}


function go_to($path)
{
    $path = opendir($path);
    echo '<table cellpadding="10">'
        . '<tr class="info">'
        . '<td>' . 'TYPE' . '</td>'
        . '<td>' . 'NAME' . '</td>'
        . '<td>' . 'ACTION' . '</td>'
        . '</tr>';
    while (($fName = readdir($path)) !== FALSE) {

        if ($fName != '.' && $fName != '..' && $fName != '.git' && is_dir($fName)) {
            echo '<tr>' . '<td>' . get_file_extension($fName) . '</td>'
                . '<td>' . '<a href="index.php?' . $fName . '">' . $fName . '</td>'
                . '<td>' . 'PLACEHOLDER' . '</td>' . '</tr>';
        } else if ($fName != '.' && $fName != '..' && is_dir($fName) == false) {
            echo '<tr>' . '<td>' . get_file_extension($fName) . '</td>'
                . '<td>' . $fName . '</td>'
                . '<td>' . 'PLACEHOLDER' . '</td>' . '</tr>';
        }
    }
    echo '</table>';
}


function go_home()
{
    $path = opendir('./');
    echo '<table cellpadding="10">'
        . '<tr class="info">'
        . '<td>' . 'TYPE' . '</td>'
        . '<td>' . 'NAME' . '</td>'
        . '<td>' . 'ACTION' . '</td>'
        . '</tr>';
    while (($fName = readdir($path)) !== FALSE) {

        if ($fName != '.' && $fName != '..' && $fName != '.git' && is_dir($fName)) {
            echo '<tr>' . '<td>' . get_file_extension($fName) . '</td>'
                . '<td>' . '<a href="index.php?path='. $fName. '">' . $fName . '</td>'
                . '<td>' . 'PLACEHOLDER' . '</td>' . '</tr>';
        
                
        }
        if ($fName != '.' && $fName != '..' && is_dir($fName) == false) {
            echo '<tr>' . '<td>' . get_file_extension($fName) . '</td>'
                . '<td>' . $fName . '</td>'
                . '<td>' . 'PLACEHOLDER' . '</td>' . '</tr>';
                
                
        }
      
     
    }

    echo '</table>';
}
