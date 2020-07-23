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
?>

<?php

function go_to()
{
    $path = opendir('./' . str_replace('./', './' . $_GET['path'], './'));
    echo '<table cellpadding="10">'
        . '<tr class="info">'
        . '<td>' . 'TYPE' . '</td>'
        . '<td>' . 'NAME' . '</td>'
        . '<td>' . 'ACTION' . '</td>'
        . '</tr>';
    while (($fName = readdir($path)) !== FALSE) {

        if ($fName != '.' && $fName != '..' && $fName != '.git' && get_file_extension($fName) == 'dir') {
            echo '<tr>' . '<td>' . get_file_extension($fName) . '</td>'
                . '<td>' . '<a href="index.php?path=' . $_GET['path'] .  '/' . $fName . '">' . $fName . '</td>'
                . '<td>' . 'PLACEHOLDER' . '</td>' . '</tr>';
        }
        if ($fName != '.' && $fName != '..' && get_file_extension($fName) != 'dir') {
            echo '<tr>' . '<td>' . get_file_extension($fName) . '</td>'
                . '<td>' . $fName . '</td>'
                . '<td>' . 'PLACEHOLDER' . '</td>' . '</tr>';
        }
    }
    echo '</table>';
    echo '$_GET path ---' . $_GET['path'] . '<br>';
    echo '$_SERVER[QUERY_STRING] ---' . $_SERVER['QUERY_STRING']. '<br>';
    echo '$_SERVER[REQUEST_URI]---' . $_SERVER['REQUEST_URI'];

}
?>