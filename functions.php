<?php

// GAUNAMA FAILO TIPO GALUNE KAIP STRINGAS, JEIGU TAI FOLDERIS, DUODAMA 'dir'
function get_file_extension($file_name)
{
    if (pathinfo($file_name, PATHINFO_EXTENSION) == '') {
        return "dir";
    } else {
        return pathinfo($file_name, PATHINFO_EXTENSION);
    }
}


?>