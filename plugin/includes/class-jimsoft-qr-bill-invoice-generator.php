<?php

use Mpdf\Mpdf;
use Sprain\SwissQrBill\DataGroup\Element\AdditionalInformation;
use Sprain\SwissQrBill\DataGroup\Element\CreditorInformation;
use Sprain\SwissQrBill\DataGroup\Element\PaymentAmountInformation;
use Sprain\SwissQrBill\DataGroup\Element\PaymentReference;
use Sprain\SwissQrBill\QrBill;

/**
 * The file that defines the generator class
 *
 * A class definition that generates PDF Invoices
 *
 * @link       https://jimsoft.ch
 * @since      1.0.0
 *
 * @package    Jimsoft_Qr_Bill
 * @subpackage Jimsoft_Qr_Bill/includes
 */

class Jimsoft_Qr_Bill_Invoice_Generator {

	protected $loader;

	public function __construct() {

		$this->generate();

	}

	private function get_option($key) {
		return get_option('jimsoft-qr-bill_'.$key, true);
	}
	public function generate() {

		$normal_iban = $this->get_option('normal_iban', true);
		$qr_iban = $this->get_option('qr_iban', true);
		$creditor_company = $this->get_option('creditor_company', true);
		$creditor_salutation = $this->get_option('creditor_salutation', true);
		$creditor_first_name = $this->get_option('creditor_first_name', true);
		$creditor_last_name = $this->get_option('creditor_last_name', true);
		$creditor_street = $this->get_option('creditor_street', true);
		$creditor_zip = $this->get_option('creditor_zip', true);
		$creditor_city = $this->get_option('creditor_city', true);

		$qrBill = QrBill::create();

		$qrBill->setCreditor(
			\Sprain\SwissQrBill\DataGroup\Element\CombinedAddress::create(
				$creditor_company,
				$creditor_street,
				$creditor_zip . ' ' . $creditor_city,
				'CH'
			)
		);
		$qrBill->setPaymentReference(
			PaymentReference::create(
				PaymentReference::TYPE_NON
			)
		);
		$qrBill->setCreditorInformation(
			CreditorInformation::create($normal_iban)
		);

		$qrBill->setAdditionalInformation(
			AdditionalInformation::create(
				'Test Invoice Webshop'
			)
		);

		$qrBill->setPaymentAmountInformation(
			PaymentAmountInformation::create('CHF', 100)
		);

		$htmlOutput  = new Sprain\SwissQrBill\PaymentPart\Output\HtmlOutput\HtmlOutput($qrBill, 'de');

		$html = '
		<style>
		@page {
			margin: 0;
		}
		</style>';
		$html .= $htmlOutput->getPaymentPart();


		echo $html;
		exit;
		$mpdf = new Mpdf([
			'tempDir' => __DIR__ . '/tmp'
		]);
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		exit;
	}
}
