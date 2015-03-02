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

header('Content-type: text/plain');
include('../../../config/config.inc.php');

define('_TRACKING_URL', 'https://www.chronopost.fr/tracking-cxf/TrackingServiceWS/trackSkybill?language=fr_FR&skybillNumber=%s');

/* No more than one update per hour */
if (time() - (int)Configuration::get('CHRONO_TRACKING_LAST_UPDATE') < 3600) die('NO UPDATE');

/* Orders in state "shipping", for our carriers, with a tracking number */
$orders = Db::getInstance()->ExecuteS('SELECT oc.id_order, oc.tracking_number FROM '._DB_PREFIX_.'order_carrier oc LEFT JOIN '
	._DB_PREFIX_.'orders o ON o.id_order=oc.id_order WHERE oc.id_carrier IN ('
	.(int)Configuration::get('CHRONORELAIS_CARRIER_ID').', '
	.(int)Configuration::get('CHRONOPOST_CARRIER_ID').', '
	.(int)Configuration::get('CHRONO10_CARRIER_ID').', '
	.(int)Configuration::get('CHRONO18_CARRIER_ID').', '
	.(int)Configuration::get('CHRONOEXPRESS_CARRIER_ID').', '
	.(int)Configuration::get('CHRONOCLASSIC_CARRIER_ID').')
	AND oc.tracking_number!=""  
	AND o.current_state='._PS_OS_SHIPPING_);

foreach ($orders as $order)
{
	$fp = fopen(sprintf(_TRACKING_URL, $order['tracking_number']), 'r');
	$xml = stream_get_contents($fp);
	fclose($fp);

	$xml = new SimpleXMLElement($xml);

	/* Registering needed namespaces. See http://stackoverflow.com/questions/10322464/ */
	$xml->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
	$xml->registerXPathNamespace('ns1', 'http://cxf.tracking.soap.chronopost.fr/');

	/* XPathing on namespaced XMLs can't be relative */
	foreach ($xml->xpath('//soap:Body/ns1:trackSkybillResponse/return/listEvents/events/code') as $event)
	{
		if (trim((string)$event) == 'D' || trim((string)$event) == 'D1' || trim((string)$event) == 'D2') /* code for a "delivery" event. */
		{
			$history = new OrderHistory();
			$history->id_order = (int)$order['id_order'];
			$history->changeIdOrderState(_PS_OS_DELIVERED_, (int)$order['id_order']);
			$history->save();
		}
	}
}

Configuration::updateValue('CHRONO_TRACKING_LAST_UPDATE', time());
