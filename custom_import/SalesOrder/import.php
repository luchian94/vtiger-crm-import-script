<?php
if (!ini_get("auto_detect_line_endings")) {
    ini_set("auto_detect_line_endings", TRUE);
}

date_default_timezone_set('Europe/Rome');

//ini_set('display_errors','on'); version_compare(PHP_VERSION, '5.5.0') <= 0 ? error_reporting(E_WARNING & ~E_NOTICE & ~E_DEPRECATED) : error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);

require_once 'includes/runtime/LanguageHandler.php';
require_once 'includes/Loader.php';
require_once 'includes/runtime/BaseModel.php';
require_once 'includes/runtime/Globals.php';
require_once 'include/Webservices/Utils.php';
require_once 'include/Webservices/Query.php';
require_once 'include/Webservices/Create.php';
include_once 'include/Webservices/Revise.php';
include_once 'include/Webservices/Delete.php';
include_once 'include/Webservices/Retrieve.php';
require_once 'modules/Users/Users.php';
require_once 'custom_import/ImportCommon.php';
require_once 'import_utils.php';


$user = new Users();
$current_user = $user->retrieveCurrentUserInfoFromFile(Users::getActiveAdminId());

$separator = ";";
$fileName = "custom_import/" . $module . "/Import_commesse_def_220519.csv";
//$fileName = "custom_import/" . $module . "/test.csv";
$fileHandle = fopen($fileName, "r");

$all_rows = array();
$header = fgetcsv($fileHandle, 0, $separator, "\"", "\"");
$header = fixHeaders($header);

while ($row = fgetcsv($fileHandle, 0, $separator, "\"", "\"")) {
    $all_rows[] = array_combine($header, $row);
}

global $adb;

$totalCreated = 0;
$totalUpdated = 0;
/*foreach ($all_rows as $row) {
    $commessa = $row["Commessa"];

    $sql = "SELECT * FROM vtiger_salesorder inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_salesorder.salesorderid
WHERE vtiger_crmentity.deleted=0 AND comm_id LIKE ?";
    $result = $adb->pquery($sql, array($commessa));
    $noofrows = $adb->num_rows($result);

    $date = date('Y-m-d H:i:s');
    if ($noofrows > 0) {
        $totalUpdated++;
        $commessaID = $adb->query_result($result,0,"salesorderid");
        echo 'Updating commessa: '.$commessa.'<br>';
        scriviLog('custom_import/' . $module . '/log-importing.txt', $date .' Updating commessa: '.$commessa );
        aggiornaCommessa($commessaID, $row);
    } else {
        $totalCreated++;
        echo 'Creating commessa: '.$commessa.'<br>';
        scriviLog('custom_import/' . $module . '/log-importing.txt', $date .' Creating commessa: '.$commessa );
        creaCommessa($row, $module);
    }

    echo '<br>';
    echo '............';
    echo '<br>';

    usleep(500000);
}*/

echo 'Totale commesse create: ' . $totalCreated;
echo '<br>';
echo 'Totale commesse aggiornate: ' . $totalUpdated;

