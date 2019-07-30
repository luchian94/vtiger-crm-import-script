<?php
$module = $_GET['module'];
if ($module != '') {
    include('custom_import/' . $module . '/import.php');
}

