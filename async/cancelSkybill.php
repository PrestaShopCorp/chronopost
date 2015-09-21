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
require('../../../config/config.inc.php');
include_once '../libraries/TrackingServiceWSService.php';

/* Check secret */
if (!Tools::getIsset('shared_secret') || Tools::getValue('shared_secret') != Configuration::get('CHRONOPOST_SECRET'))
	die('Secret does not match.');

if (!Tools::getIsset('skybill')) die('Parameter Error');

$ws = new TrackingServiceWSService();
$params = new cancelSkybill();
$params->accountNumber = Configuration::get('CHRONOPOST_GENERAL_ACCOUNT');
$params->password = Configuration::get('CHRONOPOST_GENERAL_PASSWORD');
$params->language = 'fr_FR';
$params->skybillNumber = Tools::getValue('skybill');

echo Tools::jsonEncode($ws->cancelSkybill($params)->return);
