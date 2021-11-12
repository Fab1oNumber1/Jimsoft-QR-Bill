<?php

/** @var string $prefix */


$settings = array(
	array(
		'name' => __( 'Bankdaten' ),
		'type' => 'title',
		'id'   => $prefix . 'banking_config_settings'
	),
	array(
		'id'       => $prefix . 'normal_iban',
		'name'     => __( 'Standard IBAN', 'jimsoft-qr-bill' ),
		'type'     => 'text',
		'desc_tip' => __( 'Normale IBAN-Nummer (Falls keine QR-Iban vorhandne).', 'jimsoft-qr-bill' )
	),
	array(
		'id'       => $prefix . 'qr_iban',
		'name'     => __( 'QR-IBAN', 'jimsoft-qr-bill' ),
		'type'     => 'text',
		'desc_tip' => __( 'Das Fakturierungssystem mit QR-IBAN ist für diejenigen gedacht, die ein Fakturierungs- und Zahlungserfassungssystem haben möchten, das mit den orangen (ESR) und roten (ES) Einzahlungsscheinen des ESR-Systems kompatibel ist. Ihre Bank muss Ihnen hierzu eine QR-IBAN-Kontonummer zuweisen. Die QR-IBAN-Nummer ab der 5 Zahl beginnt mit 3. In Ihrem digitalen ISO20022-Kontoauszug (camt053) wird nur die Totalsumme aller Zahlungen des Tages ausgewiesen.', 'jimsoft-qr-bill' )
	),
	array(
		'id'       => $prefix . 'customer_identification_number',
		'name'     => __( 'Customer Identification Number', 'jimsoft-qr-bill' ),
		'type'     => 'text',
		'desc_tip' => __( '', 'jimsoft-qr-bill' )
	),
	array(
		'id'       => $prefix . 'pc_account_number',
		'name'     => __( 'PC Kontonummer', 'jimsoft-qr-bill' ),
		'type'     => 'text',
		'desc_tip' => __( '', 'jimsoft-qr-bill' )
	),
	array(
		'id'       => $prefix . 'clearing_no',
		'name'     => __( 'Clearing No', 'jimsoft-qr-bill' ),
		'type'     => 'text',
		'desc_tip' => __( '', 'jimsoft-qr-bill' )
	),
	array(
		'id'       => $prefix . 'esr_no',
		'name'     => __( 'ESR Teilnehmer No', 'jimsoft-qr-bill' ),
		'type'     => 'text',
		'desc_tip' => __( '', 'jimsoft-qr-bill' )
	),
	array(
		'type' => 'sectionend',
		'desc' => '',
		'id'   => $prefix . 'banking_config_settings'
	),
	array(
		'name' => __( 'Rechnungssteller' ),
		'type' => 'title',
		'id'   => $prefix . 'creditor_config_settings',
		'value' => 'test'
	),
	array(
		'id'       => $prefix . 'creditor_company',
		'name'     => __( 'Firma', 'jimsoft-qr-bill' ),
		'type'     => 'text',
	),
	array(
		'id'       => $prefix . 'creditor_salutation',
		'name'     => __( 'Anrede', 'jimsoft-qr-bill' ),
		'type'     => 'text',
	),
	array(
		'id'       => $prefix . 'creditor_first_name',
		'name'     => __( 'Vorname', 'jimsoft-qr-bill' ),
		'type'     => 'text',
	),
	array(
		'id'       => $prefix . 'creditor_last_name',
		'name'     => __( 'Nachname', 'jimsoft-qr-bill' ),
		'type'     => 'text',
	),
	array(
		'id'       => $prefix . 'creditor_street',
		'name'     => __( 'Strasse', 'jimsoft-qr-bill' ),
		'type'     => 'text',
	),
	array(
		'id'       => $prefix . 'creditor_zip',
		'name'     => __( 'PLZ', 'jimsoft-qr-bill' ),
		'type'     => 'text',
	),
	array(
		'id'       => $prefix . 'creditor_city',
		'name'     => __( 'Stadt', 'jimsoft-qr-bill' ),
		'type'     => 'text',
	),
	array(
		'type' => 'sectionend',
		'id'   => $prefix . 'creditor_config_settings'
	),
);