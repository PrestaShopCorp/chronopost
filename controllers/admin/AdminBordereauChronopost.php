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

class AdminBordereauChronopostController extends ModuleAdminController {

	public function __construct() {

		$this->table = 'order';
		$this->className = 'Order';
		$this->lang = false;
		$this->bootstrap = true;
		$this->deleted = false;
		$this->context = Context::getContext();
		$this->list_no_link = true; // so you can't click on rows. Ignore Prestashop docs. 

		$this->_select = '
			a.id_order AS id_pdf,
			CONCAT(LEFT(c.`firstname`, 1), \'. \', c.`lastname`) AS `customer`,
			osl.`name` AS `osname`,
			os.`color`,
			IF((SELECT COUNT(so.id_order) FROM `'._DB_PREFIX_.'orders` so WHERE so.id_customer = a.id_customer) > 1, 0, 1) as new,
			country_lang.name as cname,
			IF(a.valid, 1, 0) badge_success';

		$this->_join = '
			LEFT JOIN `'._DB_PREFIX_.'customer` c ON (c.`id_customer` = a.`id_customer`)
			INNER JOIN `'._DB_PREFIX_.'address` address ON address.id_address = a.id_address_delivery
			INNER JOIN `'._DB_PREFIX_.'country` country ON address.id_country = country.id_country
			INNER JOIN `'._DB_PREFIX_.'country_lang` country_lang ON (country.`id_country` = country_lang.`id_country` AND country_lang.`id_lang` = '.(int)$this->context->language->id.')
			LEFT JOIN `'._DB_PREFIX_.'order_state` os ON (os.`id_order_state` = a.`current_state`)
			LEFT JOIN `'._DB_PREFIX_.'order_state_lang` osl ON (os.`id_order_state` = osl.`id_order_state` AND osl.`id_lang` = '.(int)$this->context->language->id.')';
		$this->_orderBy = 'id_order';
		$this->_orderWay = 'DESC';


		$statuses = OrderState::getOrderStates((int)$this->context->language->id);
		foreach ($statuses as $status)
			$this->statuses_array[$status['id_order_state']] = $status['name'];
		
		$this->_where = 
			' AND (a.id_carrier='.((int)Configuration::get('CHRONOPOST_CARRIER_ID'))
			.' OR a.id_carrier='.((int)Configuration::get('CHRONORELAIS_CARRIER_ID'))
			.' OR a.id_carrier='.((int)Configuration::get('CHRONOEXPRESS_CARRIER_ID'))
			.' OR a.id_carrier='.((int)Configuration::get('CHRONO10_CARRIER_ID'))
			.' OR a.id_carrier='.((int)Configuration::get('CHRONO18_CARRIER_ID'))
			.' OR a.id_carrier='.((int)Configuration::get('CHRONOCLASSIC_CARRIER_ID'))
			.') ';
 		
		parent::__construct();

 		// fields_lists *HAS* to be initiated in constructor, not later
		$this->fields_list = array(
			'id_order' => array('title' => $this->l('ID'), 'align' => 'center', 'width' => 25),
			'customer' => array('title' => $this->l('Customer'), 'widthColumn' => 160, 'width' => 140, 'filter_key' => 'customer', 'tmpTableFilter' => true),
			'payment' => array('title' => $this->l('Payment'), 'width' => 100),
			'osname' => array(
				'title' => $this->l('Status'),
				'type' => 'select',
				'color' => 'color',
				'list' => $this->statuses_array,
				'filter_key' => 'os!id_order_state',
				'filter_type' => 'int',
				'order_key' => 'osname'
			),
			'date_add' => array('title' => $this->l('Date'), 'width' => 35, 'align' => 'right', 'type' => 'datetime', 'filter_key' => 'a!date_add')
		);

		$this->bulk_actions = array(
			'docket' => array(
				'text' => $this->l('Edition of the daily docket'),
				'icon' => 'icon-print'
			)
		);

		$this->displayInformation($this->l('Print the daily docket in duplicate, one for schedules pickup, the other is to be retained. Both must be signed.'));

	}

	
	public function processBulkDocket()
	{
		$order_box=Tools::getValue('orderBox');
		if (empty($order_box)) {
			$this->displayWarning($this->l('You must selected orders for the export'));
			return;
		}
		Tools::redirectAdmin('../modules/chronopost/generateBordereau.php?shared_secret='.Configuration::get('CHRONOPOST_SECRET').'&orders='.implode(';', $order_box));
	}

	public function initToolbar()
	{
		parent::initToolbar();
  		// Remove "Add" button from toolbar
		unset($this->toolbar_btn['new']);
		unset($this->toolbar_btn['export']);
	}

	protected function l($string, $class = null, $addslashes = false, $htmlentities = true)
	{
		return Translate::getModuleTranslation('chronopost', $string, Tools::substr(get_class($this),0,-10), null, false);
	}
}
