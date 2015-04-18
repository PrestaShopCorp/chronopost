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

if (defined('__PS_VERSION_'))
	exit('Restricted Access');

class AdminImportChronopostController extends ModuleAdminController {

	public function __construct()
	{
		$this->bootstrap = true;
		$this->context = Context::getContext();
		// we're not actually using the database but apparently still need this
		$this->className = 'Configuration';
		$this->table = 'configuration';

		parent::__construct();

		$fields = array(
			'importfile' => array(
				'title' => $this->l('Select file to import'),
				'visibility' => Shop::CONTEXT_ALL,
				'type' => 'file',
				'name' => 'import'
			)
		);
		$this->fields_options = array(
			'general' => array(
				'title' => $this->l('Management of imports using a third-party application (eg : Chronoship Office, Chronoship Station... )'),
				'icon' => 'icon-cogs',
				'fields' =>	$fields,
				'submit' => array('title' => $this->l('Import file')),
			),
		);

		$this->displayInformation($this->l('Use this function to massively assign Chronopost parcel numbers to the desired orders. This is useful if you edit your waybills from a third-party application. (Eg ChronoShip Office ChronoShip Station ...). The expected file must be in CSV format with semicolon separator.<br/><br/>It must contain 2 columns : <ol><li>Prestashop orders reference</li><li>Chronopost tracking number</li></ol><br/>The orders status will be "Shipment in transit". An email contaning the tracking number and a link to follow the parcel will be sent to the customer.'));

	}

	public function processUpdateOptions()
	{
		if (!array_key_exists('import', $_FILES) || $_FILES['import']['error'] != UPLOAD_ERR_OK)
		{
			$this->errors[] = sprintf(Tools::displayError('The file you provided failed to upload.'));
			return;
		}

		$fp = fopen($_FILES['import']['tmp_name'], 'r');

		while ($line = fgetcsv($fp, 0, ';'))
		{
			if (!is_numeric($line[0])) continue;
			Chronopost::trackingStatus($line[0], $line[1]);
			//echo 'Commande n°'.$line[0].' mise à jour avec succès.<br/>';
		}

		$this->confirmations[] = $this->l('File successfully uploaded, the orders have been updated.');
		fclose($fp);
		unlink($_FILES['import']['tmp_name']); /* clean up after yourself, will ya ? */
	}

	protected function l($string, $class = null, $addslashes = false, $htmlentities = true)
	{
		return Translate::getModuleTranslation('chronopost', $string, Tools::substr(get_class($this),0,-10), null, false);
	}
}
