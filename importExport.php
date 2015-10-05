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

include('../../config/config.inc.php');
require_once('chronopost.php');

if (!defined('_MYDIR_')) define('_MYDIR_', dirname(__FILE__));

if (!Tools::getIsset('shared_secret') || Tools::getValue('shared_secret') != Configuration::get('CHRONOPOST_SECRET'))
	die('Secret does not match.');

$cible = Tools::getValue('cible');

if ($cible)
{
	/* export */
	header('Content-Disposition: attachment; filename="export'.$cible.date('Ymd').'.csv"');
	if ($cible == 'CSS')
	{
		header('Content-Type: text/plain; charset=ISO-8859-1');
		include_once _MYDIR_.'/libraries/PointRelaisServiceWSService.php';
		foreach (_getChronoOrders() as $o)
		{
			/* Ingredients */
			$address = new Address($o->id_address_delivery);
			$country = new Country($address->id_country);
			$customer = new Customer($o->id_customer); /* for email address */
			$bt = '';

			
			if ($o->id_carrier == Configuration::get('CHRONORELAIS_CARRIER_ID'))
				$bt = $address->other;

			/* Stir everything together */
			echo $o->id.';';

			if ($address->company != '') echo _c($address->company).';';
			echo _c($address->firstname.' '.$address->lastname).';';
			if ($address->company == '') echo ';';

			echo _c($address->address1).';'._c($address->address2).';';
			echo _c($address->postcode).';';
			echo _c($address->city).';';
			echo $country->iso_code.';';
			if ($address->phone != '') echo $address->phone.';';
			else echo $address->phone_mobile.';';
			echo $customer->email.';';
			echo $bt.';';
			echo ';'; /* ref expé 2 */
			echo '1;'; /* Weight */

			if ($o->id_carrier == Configuration::get('CHRONOPOST_CARRIER_ID')) echo '13H;';
			if ($o->id_carrier == Configuration::get('CHRONOEXPRESS_CARRIER_ID')) echo 'EI;';
			if ($o->id_carrier == Configuration::get('CHRONORELAIS_CARRIER_ID')) echo 'PR;';

			if (Chronopost::isSaturdayOptionApplicable()) echo 'S;';
			else echo 'L;';
			echo Configuration::get('CHRONOPOST_GENERAL_SUBACCOUNT').';';
			echo ';'."\r\n";
		}
	}

	if ($cible == 'CSO')
	{
		header('Content-Type: text/plain; charset=US-ASCII');

		foreach (_getChronoOrders(false) as $o)
		{
			/* Ingredients */
			$address = new Address($o->id_address_delivery);
			$country = new Country($address->id_country);
			$customer = new Customer($o->id_customer); /* for email address */

			if (strpos($address->alias, 'Depot Chrono Relais ') === false) $bt = '';
			else $bt = Tools::substr($address->alias, 20); /* strlen(Depot [...])=20 */

			/* Stir everything together */
			echo ';'; /* "code destinataire" left empty */

			if ($address->company != '') echo _c($address->company).';';
			else echo ';';
			echo ';'; /* "suite raison sociale" (?) */
			echo _c($address->address1).';'._c($address->address2).';';
			echo ';'; /* "code porte" */

			echo $country->iso_code.';';
			echo _c($address->postcode).';';
			echo _c($address->city).';';
			echo _c($address->lastname).';';
			echo _c($address->firstname).';';
			if ($address->phone != '') echo $address->phone.';';
			else echo $address->phone_mobile.';';
			echo $customer->email.';';
			echo ';'; /* "numero tva" */

			if ($o->id_carrier == Configuration::get('CHRONOPOST_CARRIER_ID')) echo '1;';
			if ($o->id_carrier == Configuration::get('CHRONOEXPRESS_CARRIER_ID')) echo '4;';

			echo $o->id.';';
			echo ($o->getTotalWeight() == 0 ? 1 : ($o->getTotalWeight() * 1000)).';';

			echo ';;;';
			echo Configuration::get('CHRONOPOST_GENERAL_SUBACCOUNT').';';
			echo '1;Commande '.$o->id.';';
			echo ';';
			echo $o->total_paid.';';

			if (Chronopost::isSaturdayOptionApplicable()) echo '1;';
			else echo '2;';
			echo "\r\n";
		}

	}
}

function _c($value)
{
	return utf8_decode(str_replace('"', ' ', str_replace(';', ' ', strip_tags($value))));
}

function _getChronoOrders($withRelais = true)
{
	if (Tools::getIsset('multi'))
		$multi = Tools::jsonDecode(Tools::getValue('multi'), true);
	else $multi = array();

	$r = array();
	if (Tools::getIsset('orders'))
		$o = explode(';', Tools::getValue('orders'));
	else
		$o = Order::getOrdersIdByDate(date('Y-m-d H:i:s', 0), date('Y-m-d H:i:s'));

	foreach ($o as $i)
	{
		$or = new Order($i);

		if ($withRelais)
		{
			if (Chronopost::isChrono($or->id_carrier))
			{
				if (array_key_exists($i, $multi)) $cpt = $multi[$i];
				else $cpt = 1;

				for (; $cpt > 0; $cpt--)
					$r[] = $or;
			}
		}
		else
		{ // no relais export for CSO
			if (Chronopost::isChrono($or->id_carrier) && $or->id_carrier != Configuration::get('CHRONORELAIS_CARRIER_ID')) 
			{
				if (array_key_exists($i, $multi)) $cpt = $multi[$i];
				else $cpt = 1;

				for (; $cpt > 0; $cpt--)
					$r[] = $or;
			}
		}            
	}
	return $r;
}

?>