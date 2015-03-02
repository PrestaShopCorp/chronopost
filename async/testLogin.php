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

include('../libraries/QuickcostServiceWSService.php');
include('../../../config/config.inc.php');

/* Check secret */
if (!Tools::getIsset('shared_secret') || Tools::getValue('shared_secret') != Configuration::get('CHRONOPOST_SECRET'))
	die('Secret does not match.');

if (!Tools::getIsset('account')
	|| !Tools::getIsset('password')) die('Parameter Error');

$service = new QuickcostServiceWSService();
$quick = new quickCost();
$quick->accountNumber = Tools::getValue('account');
$quick->password = Tools::getValue('password');
$quick->depCode = '92500';
$quick->arrCode = '75001';
$quick->weight = '1';
$quick->productCode = '1';
$quick->type = 'D';

$res = $service->quickCost($quick);

if ($res->return->errorCode == 0) die('OK');
elseif ($res->return->errorCode == 3) echo 'Le nom d\'utilisateur ou le mot de passe saisi est incorrect.';
else echo 'Une erreur système est survenue, contactez le support Chronopost si le problème persiste.';
