<?php

function getCurrentDate() {
    return $date = date('Y-m-d H:i:s');
}

function scriviLog($path, $content) {
    file_put_contents($path, $content.PHP_EOL, FILE_APPEND);
}

function formatDate($date) {
    $formatedDateObject = DateTime::createFromFormat("m/d/y", $date);
    return date_format($formatedDateObject, 'Y-m-d');
}

function creaContatto($nomeCognome){
    try {
        $data = array (
            'firstname'=> $nomeCognome['nome'],
            'lastname' => $nomeCognome['cognome'],
            'assigned_user_id' => '19x1', // 19=Users Module ID, 1=First user Entity ID
        );
        scriviLog('custom_import/import-common.log.txt', getCurrentDate() .' Creazione contatto: '.$nomeCognome['nome']. ' ' .$nomeCognome['cognome'] );
        $newRecord = vtws_create('Contacts', $data, $GLOBALS['current_user']);
        return $newRecord['id'];
    } catch (WebServiceException $ex) {
        echo $ex->getMessage();
        scriviLog('custom_import/' . $GLOBALS['module'] . '/error_log.txt', getCurrentDate() . ' Creazione contatto: '.$nomeCognome['nome']. ' ' .$nomeCognome['cognome'] . $ex->getMessage());
    }
}

function creaAzienda($nomeAzienda) {
    try {
        $data = array (
            'accountname'=> $nomeAzienda,
            'assigned_user_id' => '19x1', // 19=Users Module ID, 1=First user Entity ID
        );
        scriviLog('custom_import/import-common.log.txt', getCurrentDate() .' Creazione azienda: '.$nomeAzienda);
        $newRecord = vtws_create('Accounts', $data, $GLOBALS['current_user']);
        return $newRecord['id'];
    } catch (WebServiceException $ex) {
        echo $ex->getMessage();
        scriviLog('custom_import/' . $GLOBALS['module'] . '/error_log.txt', getCurrentDate() . ' Creazione azienda: ' .$nomeAzienda. ' ' . $ex->getMessage());
    }
}

function creaProdotto($nomeProdotto) {
    try {
        $data = array (
            'productname'=> $nomeProdotto,
            'assigned_user_id' => '19x1', // 19=Users Module ID, 1=First user Entity ID
        );
        scriviLog('custom_import/import-common.log.txt', getCurrentDate() .' Creazione prodotto: '.$nomeProdotto);
        $newRecord = vtws_create('Products', $data, $GLOBALS['current_user']);
        return $newRecord['id'];
    } catch (WebServiceException $ex) {
        echo $ex->getMessage();
        scriviLog('custom_import/' . $GLOBALS['module'] . '/error_log.txt', getCurrentDate() . ' Creazione prodotto: '.$nomeProdotto. ' ' . $ex->getMessage());
    }
}
