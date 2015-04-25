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
include_once '../../../config/config.inc.php';

if (!Tools::getIsset('relaisID')
	|| !Tools::getIsset('cartID')) die('Parameter Error');


$cart=new Cart((int)Tools::getValue('cartID'));

if($cart->id_customer!=(int)Context::getContext()->customer->id)
	die('KO');

Db::getInstance()->execute('INSERT INTO `'._DB_PREFIX_.'chrono_cart_relais` VALUES ('
	.(int)Tools::getValue('cartID').', "'.pSQL(Tools::getValue('relaisID')).'") ON DUPLICATE KEY UPDATE id_pr="'.pSQL(Tools::getValue('relaisID')).'"');



echo 'OK';
