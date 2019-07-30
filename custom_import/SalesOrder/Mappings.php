<?php

// I campi relazionali (che contengono ID di un altro modulo) devono essere mappati con "@@@rel" alla fine.
// In questo caso lo script andrà a cercarsi ID del record dalla tabella crmentity basandosi sulla label
// La relazione con gli Users del sistema viene gestita in modo diversamente

$mappings = [
    'comm_id' => 'Commessa',
    'comm_modello_inverter@@@rel' => 'Modello inverter',
    'comm_committente@@@rel' => 'Committente',
    'comm_data_inizio_lavori' => 'Data inizio lavori',
    'comm_data_fine_lavori' => 'Data fine lavori',
    'comm_stato_impianto' => 'Stato impianto',
    'comm_data_dich_conformita@@@date' => 'Data invio dichiarazione conformita',
    'comm_dichiarazione_conformita' => 'Dichiarazione conformita',
    'comm_data_collaudo' => 'Data collaudo',
    'comm_alimentazione_impianto' => 'Alimentazione impianto',
    'comm_contratto_fornitura' => 'Contratto fornitura',
    'comm_potenza_contrattuale' => 'Potenza contrattuale',
    'comm_proprieta_immobile@@@rel' => 'Proprieta immobile',
    'comm_capocantiere@@@rel' => 'Capocantiere',
    'comm_responsabile_tecnico@@@rel' => 'Responsabile Tecnico commessa',
    'comm_nome_intestatario' => 'Nome intestatario',
    'comm_cognome_intestatario' => 'Cognome intestatario',
    'comm_commerciale@@@rel' => 'Commerciale',
    'comm_tipologia' => 'Tipologia',
    'comm_subappalto' => 'Subappalto',
    'comm_area_svolgimento' => 'Area Svolgimento attivita',
    'comm_descr_micro' => 'Descrizione commessa micro specializzazione',
    'comm_descr_macro' => 'Descrizione commessa macro',
    'comm_comp_dich_consumo' => 'Compilazione Dichiarazione Consumo',
    'comm_descr_intervento' => 'Descrizione dettaglio intervento',
    'comm_n_fattura' => 'N. Fattura',
    'comm_data_fattura' => 'Data fattura',
    'comm_costo' => 'Costo commessa',
    'comm_importo_commessa' => 'Importo imponibile fattura',
    'bill_street' => 'Indirizzo di fatturazione',
    'bill_city' => 'Citta di fatturazione',
    'bill_state' => 'Provincia di fatturazione',
    'bill_country' => 'Paese di fatturazione',
    'comm_kw_impianto' => 'kW Impianto',
    'comm_tipologia_impianto' => 'Tipologia impianto',
    'comm_warranty_card_sunpower' => 'Warranty card sunpower',
    'comm_est_garanzia_fronius' => 'Scadenza garanzia inverter',
    'comm_modello_moduli@@@rel' => 'Modello moduli',
    'comm_modello_spi_display@@@rel' => 'Modello SPI',
    'comm_data_scadenza_ver_spi' => 'Data scadenza verifica SPI',
    'comm_modello_spg@@@rel' => 'Modello SPGo',
    'comm_modello_accumulo_display@@@rel' => 'Modello accumulo',
    'comm_sogg_adeguamento_243' => 'Soggetto adeguamento 243',
    'comm_sogg_adeguamento_421' => 'Soggetto adeguamento 421',
    'comm_sogg_adeguamento_a70' => 'Soggetto adeguamento A.70',
    'comm_sogg_adeguamento_595' => 'Soggetto adeguamento 595',
    'comm_matricola_contatore' => 'Matricola contatore',
    'comm_tipo_contatore' => 'Tipo contatore',
    'comm_data_ultima_taratura@@@date' => 'Data ultima taratura',
    'comm_data_prossima_taratura@@@date' => 'Data prossima taratura',
    'comm_numero_sim' => 'Numero SIM',
    'comm_proprieta' => 'Proprieta',
    'comm_gestione_dpr_462_2001' => 'Gestione DPR 462-2001',
    'comm_sogg_adeguamento_786' => 'Soggetto adeguamento 786',
    'comm_data_ultima_verifica@@@date' => 'Data ultima verifica',
    'comm_data_prossima_ver786@@@date' => 'Data prossima verifica 786',
    'comm_data_prossima_verifica@@@date' => 'Data prossima verifica',
    'comm_data_ultima_verifica786@@@date' => 'Data ultima verifica 786',
    'comm_data_domanda_connessione@@@date' => 'Data invio domanda connessione',
    'comm_conf_mod_unico_parte1' => 'Conferma modello unico parte 1',
    'comm_scheda_terna' => 'Scheda terna',
    'comm_data_consegna_step2' => 'Data consegna step 2',
    'comm_data_entrata_esercizio@@@date' => 'Data entrata in esercizio impianto',
    'comm_contratto_conto_energia' => 'Contratto conto energia',
    'comm_tariffa_riconosciuta' => 'Importo tariffa riconosciuta',
    'comm_stato_pratica_ce' => ' Stato pratica CE',
    'cf_1158' => 'LOGIN GSE',
    'cf_1160' => 'PSW GSE',
    'comm_convenzione_ssp' => 'Convenzione SSP',
    'comm_verifica_pod' => 'Verifica POD',
    'comm_data_invio' => 'Data di invio',
    'comm_stampa_conv_copia' => 'Stampa convenzione copia personale',
    'comm_statp_pratica_ssp' => 'Stato pratica SSP',
    'comm_conf_copia_gse' => 'Conferma copia per GSE',
    'ship_street' => 'Indirizzo impianto',
    'ship_city' => 'Citta impianto',
    'ship_code' => 'CAP Impianto',
    'ship_state' => 'Provincia impianto'
];