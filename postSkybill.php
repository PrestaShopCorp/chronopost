<?php
/**
* MODULE PRESTASHOP OFFICIEL CHRONOPOST
* 
* LICENSE : All rights reserved - COPY AND REDISTRIBUTION FORBIDDEN WITHOUT PRIOR CONSENT FROM OXILEO
* LICENCE : Tous droits réservés, le droit d'auteur s'applique - COPIE ET REDISTRIBUTION INTERDITES SANS ACCORD EXPRES D'OXILEO
*
* @author    Oxileo SAS <contact@oxileo.eu>
* @copyright 2001-2015 Oxileo SAS
* @license   Proprietary - no redistribution without authorization
*/

if (!defined('_MYDIR_')) define('_MYDIR_', dirname(__FILE__));
require('../../config/config.inc.php');

if (!Tools::getIsset('orderid') && !Tools::getIsset('orders') && !Tools::getIsset('orderid')) die('<h1>Informations de commande non transmises</h1>');

require_once('chronopost.php');
include('libraries/ShippingServiceWSService.php');
include_once _MYDIR_.'/libraries/PointRelaisServiceWSService.php';


$multi = array();

if (!Tools::getIsset('shared_secret') || Tools::getValue('shared_secret') != Configuration::get('CHRONOPOST_SECRET'))
	die('Secret does not match.');


if (Tools::strlen(Configuration::get('CHRONOPOST_GENERAL_ACCOUNT')) < 8)
	die('Erreur : veuillez configurer le module avant de procéder à l\'édition des étiquettes.');

$return = false;

if (Tools::getIsset('multi'))
{
	$multi = Tools::getValue('multi');
	$multi = Tools::jsonDecode($multi, true);
} 
else $multi = array();

if (Tools::getIsset('orders'))
{
	$orders = Tools::getValue('orders');
	$orders = explode(';', $orders);
} 
else 
{
	$orders = array(Tools::getValue('orderid'));
	if (Tools::getIsset('return')) $return = true;
	if (Tools::getIsset('multiOne')) $multi = array($orders[0]=>Tools::getValue('multiOne'));
}


if (count($orders) == 0) die('<h1>Aucune commande sélectionnée</h1>');
require_once('libraries/PDFMerger.php');
@$pdf = new PDFMerger;

foreach ($orders as $orderid)
{
	if (array_key_exists($orderid, $multi))
		$nb = $multi[$orderid];
	else $nb = 1;

	$totalnb = $nb;

	while ($nb > 0)
	{
		$file = tempnam('temp', 'CHR');
		$fp = fopen($file, 'w');

		$lt = createLT($orderid, $totalnb, $return);
		if ($lt === null) 
		{ 
			/* error, skip it */
			$nb--;
			continue;
		}
		fwrite($fp, $lt);
		fclose($fp);
		chmod($file, 0644);

		if (file_exists('custom_pdf/config.json'))
		{
			/* personnalize */
			include_once('custom_pdf/CustomPDF.php');
			$cust = new CustomPDF($file, $orderid);
			$cust->generate();
		}

		$pdf->addPDF($file, 'all');
		$nb--;
	}
}

try {
	$pdf->merge('download', 'Chronopost-LT-'.date('Ymd-Hi').'.pdf');
} catch(Exception $e)
{
	echo '<p>Le fichier généré est invalide.</p>';
	echo '<p>Vérifiez la configuration du module et que les commandes visées disposent d\'adresses de livraison valides.</p>';
}


function createLT($orderid, $totalnb = 1, $isReturn = false)
{
	$o = new Order($orderid);
	$a = new Address($o->id_address_delivery);
	$cust = new Customer($o->id_customer);

	// at least 2 skybills for orders >= 30kg
	$o = new Order($orderid);
	if ($o->getTotalWeight() * Configuration::get('CHRONOPOST_GENERAL_WEIGHTCOEF') >= 30 && $totalnb == 1)
	{
		echo '<script>alert(\'Vous devez générer au moins 2 étiquettes pour les commandes de plus de 30kg\');history.back();</script>';
		exit();
	}

	$recipient = new recipientValue();
	$recipient->recipientAdress1 = Tools::substr($a->address1, 0, 35);
	$recipient->recipientAdress2 = Tools::substr($a->address2, 0, 35);
	$recipient->recipientCity = Tools::substr($a->city, 0, 30);
	$recipient->recipientCivility = 'M';
	$recipient->recipientContactName = Tools::substr($a->firstname.' '.$a->lastname, 0, 35);
	$c = new Country($a->id_country);
	$recipient->recipientCountry = $c->iso_code;
	$recipient->recipientName = Tools::substr($a->company, 0, 35);
	$recipient->recipientName2 = Tools::substr($a->firstname.' '.$a->lastname, 0, 35);
	$recipient->recipientZipCode = $a->postcode;
	$recipient->recipientPhone = $a->phone_mobile == null ? $a->phone : $a->phone_mobile;
	$recipient->recipientMobilePhone = $a->phone_mobile;
	$recipient->recipientEmail = $cust->email;

	if ($isReturn) 
	{
		$recipient->recipientAdress1 = Configuration::get('CHRONOPOST_SHIPPER_ADDRESS');
		$recipient->recipientAdress2 = Configuration::get('CHRONOPOST_SHIPPER_ADDRESS2');
		$recipient->recipientCity = Configuration::get('CHRONOPOST_SHIPPER_CITY');
		$recipient->recipientCivility = Configuration::get('CHRONOPOST_SHIPPER_CIVILITY');
		$recipient->recipientContactName = Configuration::get('CHRONOPOST_SHIPPER_CONTACTNAME');
		$recipient->recipientCountry = 'FR';
		$recipient->recipientName = Configuration::get('CHRONOPOST_SHIPPER_NAME');
		$recipient->recipientName2 = Configuration::get('CHRONOPOST_SHIPPER_NAME2');
		$recipient->recipientZipCode = Configuration::get('CHRONOPOST_SHIPPER_ZIPCODE');
	}


	$esd = new esdValue();
	$esd->specificInstructions = 'aucune';
	//$esd->retrievalDateTime=date('Y-m-d\TH:i:s', $retrievalDateTime);
	//$esd->closingDateTime=>date('Y-m-d\TH:i:s', $closingDateTime);
	/*$esd->height=(float)$_POST['height'];
	$esd->width=(float)$_POST['width'];
	$esd->length=(float)$_POST['length'];*/

	$esd->height = '';
	$esd->width = '';
	$esd->length = '';

	$header = new headerValue();
	$params = new shipping();
	$skybill = new skybillValue();
	$skybill->evtCode = 'DC';
	$skybill->objectType = 'MAR';
	$skybill->productCode = '01'; // CHRONO 13

	if (Tools::getIsset('advalorem') && Tools::getValue('advalorem') == 'yes')
		$skybill->insuredValue = (int)Tools::getValue('advalorem_value');

	$header->accountNumber = Configuration::get('CHRONOPOST_GENERAL_ACCOUNT');
	$header->subAccount = Configuration::get('CHRONOPOST_GENERAL_SUBACCOUNT');
	$params->password = Configuration::get('CHRONOPOST_GENERAL_PASSWORD');

	$header->idEmit = 'PREST';

	$shipper = new shipperValue(); 
	$shipper->shipperAdress1 = Configuration::get('CHRONOPOST_SHIPPER_ADDRESS');
	$shipper->shipperAdress2 = Configuration::get('CHRONOPOST_SHIPPER_ADDRESS2');
	$shipper->shipperCity = Configuration::get('CHRONOPOST_SHIPPER_CITY');
	$shipper->shipperCivility = Configuration::get('CHRONOPOST_SHIPPER_CIVILITY');
	$shipper->shipperContactName = Configuration::get('CHRONOPOST_SHIPPER_CONTACTNAME');
	$shipper->shipperCountry = 'FR';
	$shipper->shipperName = Configuration::get('CHRONOPOST_SHIPPER_NAME');
	$shipper->shipperName2 = Configuration::get('CHRONOPOST_SHIPPER_NAME2');
	$shipper->shipperZipCode = Configuration::get('CHRONOPOST_SHIPPER_ZIPCODE');
	$shipper->shipperPhone = Configuration::get('CHRONOPOST_SHIPPER_PHONE');
	$shipper->shipperMobilePhone = Configuration::get('CHRONOPOST_SHIPPER_MOBILE');


	if ($isReturn)
	{
		$shipper = new shipperValue(); 
		$shipper->shipperAdress1 = Tools::substr($a->address1, 0, 35);
		$shipper->shipperAdress2 = Tools::substr($a->address2, 0, 35);
		$shipper->shipperCity = Tools::substr($a->city, 0, 30);
		$shipper->shipperCivility = 'M';
		$shipper->shipperContactName = Tools::substr($a->firstname.' '.$a->lastname, 0, 35);
		$shipper->shipperCountry = 'FR';
		$shipper->shipperName = Tools::substr($a->company, 0, 35);
		$shipper->shipperName2 = Tools::substr($a->firstname.' '.$a->lastname, 0, 35);
		$shipper->shipperZipCode = $a->postcode;
		$shipper->shipperPhone = $a->phone;
		$shipper->shipperMobilePhone = $a->phone_mobile;
	}

	$customer = new customerValue();
	$customer->customerAdress1 = Configuration::get('CHRONOPOST_CUSTOMER_ADDRESS');
	$customer->customerAdress2 = Configuration::get('CHRONOPOST_CUSTOMER_ADDRESS2');
	$customer->customerCity = Configuration::get('CHRONOPOST_CUSTOMER_CITY');
	$customer->customerCivility = Configuration::get('CHRONOPOST_CUSTOMER_CIVILITY');
	$customer->customerContactName = Configuration::get('CHRONOPOST_CUSTOMER_CONTACTNAME');
	$customer->customerCountry = 'FR';
	$customer->customerName = Configuration::get('CHRONOPOST_CUSTOMER_NAME');
	$customer->customerName2 = Configuration::get('CHRONOPOST_CUSTOMER_NAME2');
	$customer->customerZipCode = Configuration::get('CHRONOPOST_CUSTOMER_ZIPCODE');

	$ref = new refValue();
	$ref->recipientRef = $a->postcode;

	// CARRIER-SPECIFIC
	switch ($o->id_carrier)
	{
		case Configuration::get('CHRONORELAIS_CARRIER_ID'):
			if ($isReturn) break; // returns are Chrono13
			$skybill->productCode = Chronopost::$productCodes['CHRONORELAIS_CARRIER_ID'];
			$row = Db::getInstance()->getRow('SELECT id_pr FROM '._DB_PREFIX_.'chrono_cart_relais WHERE id_cart='.$o->id_cart);

			$ref->recipientRef = $row['id_pr'];
			
		break;

		case Configuration::get('CHRONOEXPRESS_CARRIER_ID'): 
			if ($isReturn) break; // returns are Chrono13
			$skybill->productCode = Chronopost::$productCodes['CHRONOEXPRESS_CARRIER_ID'];
		break;

		case Configuration::get('CHRONOPOST_CARRIER_ID'):
			$skybill->productCode = Chronopost::$productCodes['CHRONOPOST_CARRIER_ID'];
			if (Configuration::get('CHRONOPOST_BAL_ENABLED') == 1 && !$isReturn)
				$skybill->productCode = '58'; // CHRONO 13 + BAL
		break;

		case Configuration::get('CHRONO18_CARRIER_ID'):
			if ($isReturn) break; // returns are Chrono13
			$skybill->productCode = Chronopost::$productCodes['CHRONO18_CARRIER_ID'];
			if (Configuration::get('CHRONOPOST_BAL_ENABLED') == 1)
				$skybill->productCode = '2M'; // CHRONO 18/ + BAL
		break;

		case Configuration::get('CHRONO10_CARRIER_ID'): 
			if ($isReturn) break; // returns are Chrono13
			$skybill->productCode = Chronopost::$productCodes['CHRONO10_CARRIER_ID'];
		break;

		case Configuration::get('CHRONOCLASSIC_CARRIER_ID'): 
			if ($isReturn) break; // returns are Chrono13
			$skybill->productCode = Chronopost::$productCodes['CHRONOCLASSIC_CARRIER_ID'];
		break;
	}

	$ref->shipperRef = sprintf('%06d', $orderid);

	$skybill->service = '0';

	if ($o->id_carrier == Configuration::get('CHRONORELAIS_CARRIER_ID') ||
		$o->id_carrier == Configuration::get('CHRONOPOST_CARRIER_ID') ||
		$o->id_carrier == Configuration::get('CHRONO10_CARRIER_ID') ||
		$o->id_carrier == Configuration::get('CHRONO18_CARRIER_ID')) // Intl' service is always 0
		{ 

		// Called from hookAdminOrder
		if (Tools::getIsset('shipSaturday'))
			$skybill->service = '6';
		// Called from export admin
		if (Tools::getIsset('orders') && Chronopost::isSaturdayOptionApplicable())
			$skybill->service = '6';
		
		// Called from orders pane
		if (Tools::getIsset('orderid') && Chronopost::isSaturdayOptionApplicable())
			$skybill->service = '6';

		// Could be shipping for saturday but is not
		if (Chronopost::gettingReadyForSaturday() && $skybill->service != '6') $skybill->service = '1';
	}

	//echo Chronopost::gettingReadyForSaturday()." ".$skybill->service;

	$skybill->shipDate = date('Y-m-d\TH:i:s');
	$skybill->shipHour = date('H');

	// weight 0 when multishipping
	$skybill->weight = 0;
	// Only 1 skybill, put real weight. 
	if ($totalnb == 1) $skybill->weight = $o->getTotalWeight() * Configuration::get('CHRONOPOST_GENERAL_WEIGHTCOEF');

	$skybill->weightUnit = 'KGM';


	$skybillParams = new skybillParamsValue();
	$skybillParams->mode = Configuration::get('CHRONOPOST_GENERAL_PRINTMODE');

	$params->esdValue = $esd;
	$params->headerValue = $header;
	$params->shipperValue = $shipper;
	$params->customerValue = $customer;
	$params->recipientValue = $recipient;
	$params->refValue = $ref;
	$params->skybillValue = $skybill;

	$params->skybillParamsValue = $skybillParams;

	$service = new ShippingServiceWSService();

	$r = $service->shipping($params)->return;

/*
	var_dump($params);
	var_dump($service->shipping($params)->return);
*/

	if ($r->errorCode != 0)
		return null;

	// MAIL::SEND is bugged in 1.5 ! 
	// http://forge.prestashop.com/browse/PNM-754 (Unresolved as of 2013-04-15)
	// Context fix (it's that easy)
	Context::getContext()->link = new Link(); 

	if ($isReturn)
	{
		$customer = new Customer($o->id_customer);        
		Mail::Send($o->id_lang, 'return', 'Lettre de transport Chronopost pour le retour de votre commande', 
			array('{id_order}' => $o->id, '{firstname}' => $customer->firstname,
			'{lastname}' => $customer->lastname), $customer->email, 
			$customer->firstname.' '.$customer->lastname, null, null, 
			array('content' => $r->skybill, 'mime' => 'application/pdf', 'name' => $r->skybillNumber.'.pdf'), 
			null, _MYDIR_.'/mails/', true);
	}
	else
	{
		// Store LT for history
		Db::getInstance()->execute('INSERT INTO `'._DB_PREFIX_.'chrono_lt_history` VALUES (
				'.(int)$o->id.', 
				"'.pSQL($r->skybillNumber).'", 
				"'.pSQL($skybill->productCode).'",
				"'.pSQL($recipient->recipientZipCode).'",
				"'.pSQL($recipient->recipientCountry).'",
				"'.(isset($skybill->insuredValue) ? (int)$skybill->insuredValue : 0).'",
				"'.pSQL($recipient->recipientCity).'"
			)');

		Chronopost::trackingStatus($o->id, $r->skybillNumber);
	}

/*
	header('Content-type: application/pdf');
header('Content-Disposition: attachment; filename="downloaded.pdf"');

	echo $r->skybill; 
	die();*/
	return $r->skybill;
}
