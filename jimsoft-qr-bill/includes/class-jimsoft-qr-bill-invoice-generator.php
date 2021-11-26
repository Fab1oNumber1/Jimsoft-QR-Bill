<?php

use Sprain\SwissQrBill\DataGroup\Element\AdditionalInformation;
use Sprain\SwissQrBill\DataGroup\Element\CombinedAddress;
use Sprain\SwissQrBill\DataGroup\Element\CreditorInformation;
use Sprain\SwissQrBill\DataGroup\Element\PaymentAmountInformation;
use Sprain\SwissQrBill\DataGroup\Element\PaymentReference;
use Sprain\SwissQrBill\DataGroup\Element\StructuredAddress;
use Sprain\SwissQrBill\QrBill;
use Sprain\SwissQrBill\PaymentPart\Output\TcPdfOutput\TcPdfOutput;
use Sprain\SwissQrBill\Reference\QrPaymentReferenceGenerator;
use Symfony\Component\Validator\ConstraintViolation;

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


	private $order;


	public function __construct( $order_id ) {

		//$this->generate();

		$order = wc_get_order( $order_id );


		if ( ! $order ) {
			throw new Exception( "Order does not exist" );
		}

		$this->order = $order;
	}


	private function get_option( $key ) {
		$value = get_option( Jimsoft_Qr_Bill::PREFIX . $key );
		if ( is_string( $value ) ) {
			$value = str_replace( '[order_number]', $this->order->get_order_number(), $value );
		}

		return $value;
	}


	/**
	 * Generate the a QR Bill as a PDF
	 *
	 */
	public function generate() {

		$order_id = $this->order->get_id();
		$order    = $this->order;

		$normal_iban                    = $this->get_option( 'normal_iban' );
		$qr_iban                        = $this->get_option( 'qr_iban' );
		$customer_identification_number = $this->get_option( 'customer_identification_number' );
		$creditor_company               = $this->get_option( 'creditor_company' );
		$creditor_salutation            = $this->get_option( 'creditor_salutation' );
		$creditor_first_name            = $this->get_option( 'creditor_first_name' );
		$creditor_last_name             = $this->get_option( 'creditor_last_name' );
		$creditor_street                = $this->get_option( 'creditor_street' );
		$creditor_zip                   = $this->get_option( 'creditor_zip' );
		$creditor_city                  = $this->get_option( 'creditor_city' );

		$qrBill = QrBill::create();


		$creditor_name = $creditor_company;

		if ( ! $creditor_company ) {
			$creditor_name = $creditor_first_name . ' ' . $creditor_last_name;
		}

		$qrBill->setCreditor(
			CombinedAddress::create(
				$creditor_name,
				$creditor_street,
				$creditor_zip . ' ' . $creditor_city,
				'CH'
			)
		);

		if ( $qr_iban ) {

		    if(!$customer_identification_number) {
		        $customer_identification_number = null;
            }

			$referenceNumber = QrPaymentReferenceGenerator::generate(
				$customer_identification_number,  // You receive this number from your bank (BESR-ID). Unless your bank is PostFinance, in that case use NULL.
				$order->get_order_number()
			);

			$qrBill->setPaymentReference(
				PaymentReference::create(
					PaymentReference::TYPE_QR,
					$referenceNumber
				)
			);
			$qrBill->setCreditorInformation(
				CreditorInformation::create( $qr_iban )
			);
		} else {
			$qrBill->setPaymentReference(
				PaymentReference::create(
					PaymentReference::TYPE_NON
				)
			);
			$qrBill->setCreditorInformation(
				CreditorInformation::create( $normal_iban )
			);
		}


		if($value = $this->get_option('invoice_additional_information')) {

			$qrBill->setAdditionalInformation(
				AdditionalInformation::create(
					$value
				)
			);
        }


		$qrBill->setUltimateDebtor(
			StructuredAddress::createWithStreet(
				$this->order->get_formatted_billing_full_name(),
				$this->order->get_billing_address_1(),
				$this->order->get_billing_address_2(),
				$this->order->get_billing_postcode(),
				$this->order->get_billing_city(),
				'CH'
			)
		);

		$qrBill->setPaymentAmountInformation(
			PaymentAmountInformation::create( 'CHF', $this->order->get_total() )
		);
		$violations = $qrBill->getViolations();

		if ( $violations->count() ) {
			?>
            <h3>Error List</h3>
            <table>

				<?php foreach ( $violations as $violation ): ?>
					<?php
					/** @var ConstraintViolation $violation */
					?>
                    <tr>
                        <th><?= $violation->getPropertyPath() ?></th>
                        <td><?= $violation->getMessage() ?></td>
                    </tr>
				<?php endforeach; ?>
                </tbody>
            </table>
			<?php
			exit;
		}


		$tcPdf = new TCPDF( 'P', 'mm', 'A4', true, 'UTF-8' );
		$tcPdf->setPrintHeader( false );
		$tcPdf->setPrintFooter( false );
		$tcPdf->AddPage();


		$tcPdf->SetFontSize( 10 );
		if ( is_numeric( $this->get_option( 'pdf_font_size' ) ) ) {
			$tcPdf->SetFontSize( $this->get_option( 'pdf_font_size' ) );
		}


		if ( $this->get_option( 'pdf_logo' ) === 'yes' ) {
			$this->printLogo( $tcPdf, $this->order );
		}
		if ( $this->get_option( 'pdf_creditor' ) ) {
			$this->printCreditor( $tcPdf, $this->order );
		}
		if ( $this->get_option( 'pdf_address' ) === 'yes' ) {
			$this->printAddress( $tcPdf, $this->order );
		}
		if ( $this->get_option( 'pdf_date' ) === 'yes' ) {
			$this->printDate( $tcPdf, $this->order );
		}


		$pdf_color_primary    = '#333333';
		$pdf_color_table_even = '#EFEFEF';
		$pdf_color_table_odd  = '#FFFFFF';

		if ( $value = $this->get_option( 'pdf_color_primary' ) ) {
			$pdf_color_primary = $value;
		}
		if ( $value = $this->get_option( 'pdf_color_table_odd' ) ) {
			$pdf_color_table_odd = $value;
		}
		if ( $value = $this->get_option( 'pdf_color_table_even' ) ) {
			$pdf_color_table_even = $value;
		}


		if ( $this->get_option( 'pdf_order_details' ) === 'yes' ) {
			ob_start();
			include __DIR__ . '/../wc-templates/order/order-details.php';
			$html_order = ob_get_clean();
			$tcPdf->writeHTML( $html_order );
		}

		$locale = 'en';

		if(get_bloginfo('language')) {
		    $locale = explode('-', get_bloginfo('language'))[0];
		}

		$output = new TcPdfOutput( $qrBill, $locale, $tcPdf );
		$output
			->setPrintable( false )
			->getPaymentPart();

		$examplePath = __DIR__ . "/tcpdf_example.pdf";
		$tcPdf->Output( $examplePath, 'I' );

		exit;
	}

	/**
	 * Print debitor address on pdf
	 *
	 * @param $tcPdf
	 * @param $order
	 */
	private function printAddress( $tcPdf, $order ) {

		$address = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() . PHP_EOL;
		$address .= $order->get_billing_address_1() . PHP_EOL;
		if ( $order->get_billing_address_2() ) {
			$address .= $order->get_billing_address_2() . PHP_EOL;
		}
		$address .= $order->get_billing_postcode() . ' ' . $order->get_billing_city() . PHP_EOL;


		$x = '';
		$y = '';

		if ( $value = $this->get_option( 'pdf_address_x' ) ) {
			$x = $value;
		}
		if ( $value = $this->get_option( 'pdf_address_y' ) ) {
			$y = $value;
		}

		$tcPdf->MultiCell( 0, 30, $address, 0, 'L', false, 1, $x, $y );
	}

	/**
	 * Print logo on PDF
	 *
	 * @param TCPDF $tcPdf
	 * @param $order
	 */
	private function printLogo( $tcPdf, $order ) {

		$url = $this->get_option( 'pdf_logo_url' );

		$w = 0;
		$h = 0;

		// get width and height from options
		if ( is_numeric( $this->get_option( 'pdf_logo_w' ) ) ) {
			$w = $this->get_option( 'pdf_logo_w' );
		}
		if ( is_numeric( $this->get_option( 'pdf_logo_h' ) ) ) {
			$h = $this->get_option( 'pdf_logo_h' );
		}

		$x = '';
		$y = '';

		// get position from options
		if ( is_numeric( $this->get_option( 'pdf_logo_x' ) ) ) {
			$x = $this->get_option( 'pdf_logo_x' );
		}
		if ( is_numeric( $this->get_option( 'pdf_logo_y' ) ) ) {
			$y = $this->get_option( 'pdf_logo_y' );
		}
		$tcPdf->Image( $url, $x, $y, $w, $h );

	}

	/**
	 * Print Creditor textarea on PDF
	 *
	 * @param TCPDF $tcPdf
	 * @param $order
	 */
	private function printCreditor( $tcPdf, $order ) {

		$x = '';
		$y = '';

		if ( is_numeric( $this->get_option( 'pdf_creditor_x' ) ) ) {
			$x = $this->get_option( 'pdf_creditor_x' );
		}
		if ( is_numeric( $this->get_option( 'pdf_creditor_y' ) ) ) {
			$y = $this->get_option( 'pdf_creditor_y' );
		}

		$tcPdf->MultiCell( 0, 30, $this->get_option( 'pdf_creditor' ), 0, 'L', false, 1, $x, $y );

	}

	/**
	 * Print date and location on PDF
	 *
	 * @param TCPDF $tcPdf
	 * @param $order
	 */
	private function printDate( $tcPdf, $order ) {

		$x = '';
		$y = '';

		if ( is_numeric( $this->get_option( 'pdf_date_x' ) ) ) {
			$x = $this->get_option( 'pdf_date_x' );
		}
		if ( is_numeric( $this->get_option( 'pdf_date_y' ) ) ) {
			$y = $this->get_option( 'pdf_date_y' );
		}


		$string = '';

		if ( $this->get_option( 'pdf_date_city' ) ) {
			$string .= $this->get_option( 'pdf_date_city' ) . ', ';
		}
		$string .= date( $this->get_option( 'pdf_date_format' ) );

		$tcPdf->MultiCell( 0, 0, $string, 0, 'L', false, 1, $x, $y );

	}
}
