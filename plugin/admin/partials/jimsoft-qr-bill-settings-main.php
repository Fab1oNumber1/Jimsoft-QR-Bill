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
		'type' => 'sectionend',
		'desc' => '',
		'id'   => $prefix . 'banking_config_settings'
	),
	array(
		'name'  => __( 'Rechnungssteller' ),
		'type'  => 'title',
		'id'    => $prefix . 'creditor_config_settings',
		'value' => 'test'
	),
	array(
		'id'   => $prefix . 'creditor_company',
		'name' => __( 'Firma', 'jimsoft-qr-bill' ),
		'type' => 'text',
	),
	array(
		'id'   => $prefix . 'creditor_salutation',
		'name' => __( 'Anrede', 'jimsoft-qr-bill' ),
		'type' => 'text',
	),
	array(
		'id'   => $prefix . 'creditor_first_name',
		'name' => __( 'Vorname', 'jimsoft-qr-bill' ),
		'type' => 'text',
	),
	array(
		'id'   => $prefix . 'creditor_last_name',
		'name' => __( 'Nachname', 'jimsoft-qr-bill' ),
		'type' => 'text',
	),
	array(
		'id'   => $prefix . 'creditor_street',
		'name' => __( 'Strasse', 'jimsoft-qr-bill' ),
		'type' => 'text',
	),
	array(
		'id'   => $prefix . 'creditor_zip',
		'name' => __( 'PLZ', 'jimsoft-qr-bill' ),
		'type' => 'text',
	),
	array(
		'id'   => $prefix . 'creditor_city',
		'name' => __( 'Stadt', 'jimsoft-qr-bill' ),
		'type' => 'text',
	),
	array(
		'type' => 'sectionend',
		'id'   => $prefix . 'creditor_config_settings'
	),

	array(
		'name'  => __( 'PDF-Rechnung Konfiguration', 'jimsoft-qr-bill' ),
		'type'  => 'title',
		'id'    => $prefix . 'pdf_config_settings',
		'value' => ''
	),
	array(
		'id'       => $prefix . 'pdf_font_size',
		'name'     => __( 'Schriftgrösse', 'jimsoft-qr-bill' ),
		'type'     => 'number',
		'placeholder' => '10'
	),
	array(
		'id'          => $prefix . 'pdf_order_details_title',
		'name'        => __( 'Bestelldetails Titel', 'jimsoft-qr-bill' ),
		'type'        => 'text',
		'desc_tip'    => 'Leer lassen um keinen Titel anzuzeigen',
		'placeholder' => 'Bestellung [order_number]',
		'value' => get_option($prefix . 'pdf_order_details_title') ? get_option($prefix . 'pdf_order_details_title') : 'Bestellung #[order_number]'
	),
	array(
		'id'          => $prefix . 'pdf_order_details_text',
		'name'        => __( 'Bestelldetails Text', 'jimsoft-qr-bill' ),
		'type'        => 'textarea',
		'desc_tip'    => 'Leer lassen um keinen Text anzuzeigen',
		'cols' => 5
	),
	array(
		'id'       => $prefix . 'pdf_order_details',
		'name'     => __( 'Bestellpositionen anzeigen', 'jimsoft-qr-bill' ),
		'type'     => 'checkbox'
	),
	array(
		'id'       => $prefix . 'pdf_table_cellpadding',
		'name'     => __( 'Tabellenzellen Padding', 'jimsoft-qr-bill' ),
		'type'     => 'number'
	),
	array(
		'id'       => $prefix . 'pdf_color_primary',
		'name'     => __( 'Farbe Primär', 'jimsoft-qr-bill' ),
		'type'     => 'color',
		'desc_tip' => 'Primäre Farbe für die Rechnung',
	),
	array(
		'id'       => $prefix . 'pdf_color_table_odd',
		'name'     => __( 'Farbe Tabellenzeile ungerade', 'jimsoft-qr-bill' ),
		'type'     => 'color'
	),
	array(
		'id'       => $prefix . 'pdf_color_table_even',
		'name'     => __( 'Farbe Tabellenzeile gerade', 'jimsoft-qr-bill' ),
		'type'     => 'color'
	),
	array(
		'id'          => $prefix . 'pdf_logo',
		'name'        => __( 'Logo anzeigen', 'jimsoft-qr-bill' ),
		'type'        => 'checkbox'
	),
	array(
		'id'          => $prefix . 'pdf_logo_url',
		'name'        => __( 'Logo (URL)', 'jimsoft-qr-bill' ),
		'type'        => 'text'
	),
	array(
		'id'          => $prefix . 'pdf_logo_x',
		'name'        => __( 'Logo Position X', 'jimsoft-qr-bill' ),
		'type'        => 'number'
	),
	array(
		'id'          => $prefix . 'pdf_logo_y',
		'name'        => __( 'Logo Position Y', 'jimsoft-qr-bill' ),
		'type'        => 'number'
	),
	array(
		'id'          => $prefix . 'pdf_logo_w',
		'name'        => __( 'Logo Breite', 'jimsoft-qr-bill' ),
		'type'        => 'number'
	),
	array(
		'id'          => $prefix . 'pdf_logo_h',
		'name'        => __( 'Logo Höhe', 'jimsoft-qr-bill' ),
		'type'        => 'number'
	),


	array(
		'id'          => $prefix . 'pdf_address',
		'name'        => __( 'Debitor Adresse anzeigen', 'jimsoft-qr-bill' ),
		'type'        => 'checkbox'
	),
	array(
		'id'          => $prefix . 'pdf_address_x',
		'name'        => __( 'Adresse Position X', 'jimsoft-qr-bill' ),
		'type'        => 'number',
		'desc_tip'    => 'Millimeter von dem linken Seitenrand',
		'placeholder'    => 'Millimeter von dem linken Seitenrand',
	),
	array(
		'id'          => $prefix . 'pdf_address_y',
		'name'        => __( 'Adresse Position Y', 'jimsoft-qr-bill' ),
		'type'        => 'number',
		'desc_tip'    => 'Millimeter von dem oberem Seitenrand',
		'placeholder'    => 'Millimeter von dem oberem Seitenrand',
	),

	array(
		'id'          => $prefix . 'pdf_creditor',
		'name'        => __( 'Kreditor Textfeld', 'jimsoft-qr-bill' ),
		'type'        => 'textarea'
	),
	array(
		'id'          => $prefix . 'pdf_creditor_x',
		'name'        => __( 'Kreditor Position X', 'jimsoft-qr-bill' ),
		'type'        => 'number',
		'desc_tip'    => 'Millimeter von dem linken Seitenrand',
		'placeholder'    => 'Millimeter von dem linken Seitenrand',
	),
	array(
		'id'          => $prefix . 'pdf_creditor_y',
		'name'        => __( 'Kreditor Position Y', 'jimsoft-qr-bill' ),
		'type'        => 'number',
		'desc_tip'    => 'Millimeter von dem oberem Seitenrand',
		'placeholder'    => 'Millimeter von dem oberem Seitenrand',
	),
	array(
		'id'          => $prefix . 'pdf_date',
		'name'        => __( 'Datum anzeigen', 'jimsoft-qr-bill' ),
		'type'        => 'checkbox'
	),
	array(
		'id'          => $prefix . 'pdf_date_city',
		'name'        => __( 'Datum Ort', 'jimsoft-qr-bill' ),
		'type'        => 'text',
	),
	array(
		'id'          => $prefix . 'pdf_date_format',
		'name'        => __( 'Datum Format', 'jimsoft-qr-bill' ),
		'type'        => 'text',
		'value'        => get_option($prefix . 'pdf_date_format') ? get_option($prefix . 'pdf_date_format') : 'd.m.Y',
	),
	array(
		'id'          => $prefix . 'pdf_date_x',
		'name'        => __( 'Datum Position X', 'jimsoft-qr-bill' ),
		'type'        => 'number',
	),
	array(
		'id'          => $prefix . 'pdf_date_y',
		'name'        => __( 'Datum Position Y', 'jimsoft-qr-bill' ),
		'type'        => 'number',
	),

	array(
		'type' => 'sectionend',
		'id'   => $prefix . 'pdf_config_settings'
	),

);