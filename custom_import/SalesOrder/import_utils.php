<?php

include 'Mappings.php';

function fixHeaders($headers) {
    $fixedHeaders = [];
    foreach ($headers as $key => $value) {
        $fixedHeaders[$key] = trim($value);
    }

    return $fixedHeaders;
}

function creaCommessa($row) {
    $datiCommessa = getFieldMappings($row);

    $datiCommessa['productid'] = getFirstProduct();// campo obbligatorio necessario per la creazione
    $datiCommessa['invoicestatus'] = '1';// campo obbligatorio necessario per la creazione
    $datiCommessa['LineItems'] = '1'; // campo obbligatorio necessario per la creazione
    $datiCommessa['assigned_user_id'] = '19x1'; // 19=Users Module ID, 1=First user Entity ID

    print_r($datiCommessa);
    
    try {
        $commessa = vtws_create('SalesOrder', $datiCommessa, $GLOBALS['current_user']);

        // SET PREVENTIVO DELLA COMMESSA (per qualche motivo il vtws_crete non iserisce il riferimento al preventivo)
        $newCommessaID = explode('x', $commessa['id'])[1];
        $quoteCrmId = getModuleID($row["Nome Preventivo"]);
        $quoteID = explode('x', $quoteCrmId)[1];
        setPreventivoCommessa($newCommessaID, $quoteID);
    } catch (WebServiceException $ex) {
        scriviLog('custom_import/' . $GLOBALS['module'] . '/error_log.txt', getCurrentDate() . ' Creazione commessa: ' . $ex->getMessage());
    }
}

function aggiornaCommessa($id, $row){
    $vtwsID = vtws_getWebserviceEntityId('SalesOrder', $id);
    $datiCommessa = getFieldMappings($row);

    $datiCommessa['id'] = $vtwsID;

    $datiCommessa['productid'] = getFirstProduct();// campo obbligatorio necessario per la creazione
    $datiCommessa['invoicestatus'] = '1';// campo obbligatorio necessario per la creazione
    $datiCommessa['LineItems'] = '1'; // campo obbligatorio necessario per la creazione

    print_r($datiCommessa);

    try {
        vtws_revise($datiCommessa, $GLOBALS['current_user']);

        // SET PREVENTIVO DELLA COMMESSA (per qualche motivo il vtws_crete non iserisce il riferimento al preventivo)
        $quoteCrmId = getModuleID($row["Nome Preventivo"]);
        $quoteID = explode('x', $quoteCrmId)[1];
        setPreventivoCommessa($id, $quoteID);
    } catch (WebServiceException $ex) {
        echo $ex->getMessage();
        scriviLog('custom_import/' . $GLOBALS['module'] . '/error_log.txt', getCurrentDate() . ' Aggiornamento commessa: ' . $ex->getMessage());
    }
}

function getFieldMappings($row) {
    $mappingArray = [];

    foreach( $GLOBALS['mappings'] as $field => $key){
        $fieldParts = explode('@@@',$field);
        if ( count($fieldParts) > 1) {
            $fieldName = $fieldParts[0];
            $fieldType = $fieldParts[1];

            switch ($fieldType) {
                case 'date':
                    $dateValue = getValue($row, $key);
                    $dateValue = formatDate($dateValue);
                    $mappingArray[$fieldName] = $dateValue;
                    break;
                case 'rel':
                    $mappingArray[$fieldName] = getModuleID($row[$key]);
                    break;
            }
        }else{
            $mappingArray[$field] = getValue($row, $key);
        }
    }

    return $mappingArray;
}

function setPreventivoCommessa($commessaID, $quoteID){
    global $adb;

    $adb->pquery("UPDATE vtiger_salesorder SET quoteid = {$quoteID} WHERE salesorderid = {$commessaID}");
}

function getModuleID($cellValue) {
    if (!$cellValue) {
        return null;
    }

    $module = getModuleNameFromCsvCell($cellValue);
    $modValue = getValueFromCsvCell($cellValue);
    return getCRMID($module, $modValue);
}

function getCRMID($module, $value){
    global $adb;

    if ($module === 'Users') {
        return getUserID($value);
    }

    $escapedValue = $adb->sql_escape_string($value);
    $escapedValue = trim($escapedValue);
    $q = "SELECT crmid FROM vtiger_crmentity AS entity WHERE deleted = 0 AND label LIKE '%{$escapedValue}%'";
    $result = $adb->pquery($q);
    if ( !$adb->num_rows($result) ) {
        switch ($module) {
            case 'Contacts':
                return creaContatto( getNomeCognome($value) );
                break;
            case 'Accounts':
                return creaAzienda( $value );
                break;
            case 'Products':
                return creaProdotto( $value );
                break;
            case 'Quotes':
                scriviLog('custom_import/' . $GLOBALS['module'] . '/MissingQuotes.txt', getCurrentDate() . ' Preventivo '.$value.' non esiste.');
                return null;
                break;
            default:
                return null;
        }
    }
    $rowData = $adb->query_result_rowdata($result, 0);
    $crmID = $rowData['crmid'];
    return vtws_getWebserviceEntityId($module, $crmID);
}

function getModuleNameFromCsvCell($cellValue) {
    return explode('::::',$cellValue)[0];
}

function getValueFromCsvCell($cellValue) {
    return explode('::::',$cellValue)[1];
}

function getValue($row, $key){
    return $row[$key] ? $row[$key] : null;
}

function getUserID($value){
    global $adb;

    $nomeCognome = getNomeCognome($value);
    $escapedNome = $adb->sql_escape_string($nomeCognome["nome"]);
    $escapedCognome = $adb->sql_escape_string($nomeCognome["cognome"]);
    $q = "SELECT id FROM vtiger_users WHERE first_name LIKE '{$escapedNome}' AND last_name LIKE '{$escapedCognome}'";
    $result = $adb->pquery($q);
    if ( !$adb->num_rows($result) ) {
        return null;
    }
    $rowData = $adb->query_result_rowdata($result, 0);
    $userID = $rowData['id'];
    return vtws_getWebserviceEntityId('Users', $userID);
}

function getNomeCognome( $cellValue ) {
    $retVal = [];
    $parts = explode(' ',trim($cellValue));
    if ( count($parts) > 2 ) {
        $retVal['cognome'] = end($parts);
        array_pop($parts);
        $retVal['nome'] = implode(' ', $parts);
    } else {
        $retVal['nome'] = $parts[0];
        $retVal['cognome'] = $parts[1];
    }
    return $retVal;
}

// Il metodo serve solo per l'import delle commesse perché richiedono sempre un prodotto quindi prendo il primo che trovo nel sistema
function getFirstProduct() {
    $q = "SELECT * FROM Products LIMIT 0,1";
    $q = $q . ';';
    $product = vtws_query($q, $GLOBALS['current_user']);
    return $product[0]['id'];
}

