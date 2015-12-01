<?php
/**
* MODULE PRESTASHOP OFFICIEL CHRONOPOST
*
* LICENSE : All rights reserved - COPY && REDISTRIBUTION FORBIDDEN WITHOUT PRIOR CONSENT FROM OXILEO
* LICENCE : Tous droits réservés, le droit d'auteur s'applique - COPIE ET REDISTRIBUTION INTERDITES SANS ACCORD EXPRES D'OXILEO
*
* @author    Oxileo SAS <contact@oxileo.eu>
* @copyright 2001-2015 Oxileo SAS
* @license   Proprietary - no redistribution without authorization
*/

/* CONSTS PHP <5.3 */
if (!defined('_MYDIR_')) define('_MYDIR_', dirname(__FILE__));

require_once(_MYDIR_.'/libraries/range/RangePrice.php');
require_once(_MYDIR_.'/libraries/range/RangeWeight.php');

define('MIN_VERSION', '1.5');
define('MAX_VERSION', '1.7');

class Chronopost extends CarrierModule
{
	private $_postErrors = array();
	public $id_carrier;

	public static $productCodes = array(
		'CHRONOPOST_CARRIER_ID' => '01',
		'CHRONORELAIS_CARRIER_ID' =>'86',
		'CHRONO10_CARRIER_ID' =>'02',
		'CHRONO18_CARRIER_ID' =>16,
		'CHRONOEXPRESS_CARRIER_ID' =>17,
		'CHRONOCLASSIC_CARRIER_ID' =>44);


	public static $productCodesBAL = array(
		'CHRONOPOST_CARRIER_ID' => '01',
		'CHRONORELAIS_CARRIER_ID' =>86,
		'CHRONO10_CARRIER_ID' =>'02',
		'CHRONO18_CARRIER_ID' =>16,
		'CHRONOEXPRESS_CARRIER_ID' =>17,
		'CHRONOCLASSIC_CARRIER_ID' =>44);


	/* Module config at install-time */
	private static $_config = array(
		'chronorelais' =>array(
			'name' => 'Chronopost - Livraison express en point relais',
			'id_tax_rules_group' => 1,
			'url' => 'http://www.chronopost.fr/expedier/inputLTNumbersNoJahia.do?lang=fr_FR&listeNumeros=@',
			'active' => true,
			'deleted' => 0,
			'shipping_handling' => false,
			'range_behavior' => 0,
			'is_module' => false,
			/* shown in FO during carrier selection. length limited to 128 char I REPEAT 128 CHARS */
			'delay' => array('fr' =>'Colis livré le lendemain avant 13 h dans le relais Pickup de votre choix. Vous serez averti par e-mail et SMS.', 'en'=>'Parcels delivered the next day before 1pm in the Pickup relay of your choice. You\'ll be notified by e-mail and SMS.'),
			'shipping_external' => true,
			'external_module_name' => 'chronopost',
			'need_range' => true,
			/* .jpg file in img directory */
			'logo_filename' => 'chronorelais',
			/* name of the config key to contain carrier ID after module init */
			'configuration_item' => 'CHRONORELAIS_CARRIER_ID'
		),
		'chronopost' =>array(
			'name' => 'Chronopost - Livraison express à domicile',
			'id_tax_rules_group' => 1,
			'url' => 'http://www.chronopost.fr/expedier/inputLTNumbersNoJahia.do?lang=fr_FR&listeNumeros=@',
			'active' => true,
			'deleted' => 0,
			'shipping_handling' => false,
			'range_behavior' => 0,
			'is_module' => false,
			'delay' => array('fr' =>'Colis livré le lendemain matin avant 13h à votre domicile. La veille de la livraison, vous êtes averti par e-mail et SMS.', 'en'=>'Parcels delivered the next day before 13pm at your home.The day before delivery, You\'ll be notified by e-mail and SMS.'),
			'shipping_external' => true,
			'external_module_name' => 'chronopost',
			'need_range' => true,
			'logo_filename' => 'chronopost',
			'configuration_item' => 'CHRONOPOST_CARRIER_ID'
		),
		'chrono10' =>array(
			'name' => 'Chronopost - Livraison express à domicile',
			'id_tax_rules_group' => 1,
			'url' => 'http://www.chronopost.fr/expedier/inputLTNumbersNoJahia.do?lang=fr_FR&listeNumeros=@',
			'active' => true,
			'deleted' => 0,
			'shipping_handling' => false,
			'range_behavior' => 0,
			'is_module' => false,
			'delay' => array('fr' =>'Colis livré le lendemain matin avant 10h à votre domicile. La veille de la livraison, vous êtes averti par e-mail et SMS.', 'en'=>'Parcels delivered the next day before 10am at your home.The day before delivery, You\'ll be notified by e-mail and SMS.'),
			'shipping_external' => true,
			'external_module_name' => 'chronopost',
			'need_range' => true,
			'logo_filename' => 'chronopost',
			'configuration_item' => 'CHRONO10_CARRIER_ID'
		),
		'chrono18' =>array(
			'name' => 'Chronopost - Livraison express à domicile',
			'id_tax_rules_group' => 1,
			'url' => 'http://www.chronopost.fr/expedier/inputLTNumbersNoJahia.do?lang=fr_FR&listeNumeros=@',
			'active' => false,
			'deleted' => 0,
			'shipping_handling' => false,
			'range_behavior' => 0,
			'is_module' => false,
			'delay' => array('fr' =>'Colis livré le lendemain matin avant 18h à votre domicile. La veille de la livraison, vous êtes averti par e-mail et SMS.', 'en'=>'Parcels delivered the next day before 18pm at your home.The day before delivery, You\'ll be notified by e-mail and SMS.'),
			'shipping_external' => true,
			'external_module_name' => 'chronopost',
			'need_range' => true,
			'logo_filename' => 'chronopost',
			'configuration_item' => 'CHRONO18_CARRIER_ID'
		),
		'chronoexpress' =>array(
			'name' => 'Chrono Express',
			'id_tax_rules_group' => 1,
			'url' => 'http://www.chronopost.fr/expedier/inputLTNumbersNoJahia.do?lang=fr_FR&listeNumeros=@',
			'active' => true,
			'deleted' => 0,
			'shipping_handling' => false,
			'range_behavior' => 0,
			'is_module' => false,
			'delay' => array('fr' =>'Colis livré en 1 à 3 jours vers l\'Europe, en 48h vers les DOM et en 2 à 5 jours vers le reste du monde.', 'en'=>'Parcels delivered to Europe in 1 to 3 days, 48 hours to the DOM and 2 to 5 days to the rest of the world.'),
			'shipping_external' => true,
			'external_module_name' => 'chronopost',
			'need_range' => true,
			'logo_filename' => 'chronoexpress',
			'configuration_item' => 'CHRONOEXPRESS_CARRIER_ID'
		),
		'chronoclassic' =>array(
			'name' => 'Chrono Classic',
			'id_tax_rules_group' => 1,
			'url' => 'http://www.chronopost.fr/expedier/inputLTNumbersNoJahia.do?lang=fr_FR&listeNumeros=@',
			'active' => true,
			'deleted' => 0,
			'shipping_handling' => false,
			'range_behavior' => 0,
			'is_module' => false,
			'delay' => array('fr' =>'Colis livré en 1 à 3 jours vers l\'Europe.', 'Parcels delivered to Europe in 1 to 3 days'),
			'shipping_external' => true,
			'external_module_name' => 'chronopost',
			'need_range' => true,
			'logo_filename' => 'chronoexpress',
			'configuration_item' => 'CHRONOCLASSIC_CARRIER_ID'
		)
	);

	public function __construct()
	{
		$this->name = 'chronopost';
		$this->tab = 'shipping_logistics';

		$this->version = '3.6.9';

		$this->author = $this->l('Oxileo for Chronopost');
		$this->module_key = '16ae9609f724c8d72cf3de62c060210c';
		$this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.6');

		parent::__construct();

		$this->displayName = $this->l('Chronopost and ChronoRelais');
		$this->description = $this->l('Manage Chronopost and Chronopost Pickup relay');
		$this->confirmUninstall = $this->l('Remember, once this module is uninstalled , you won\'t be able to edit Chronopost waybills or propose Pickup delivery point to your customers. Are you sure you wish to proceed?');

		// Check is SOAP is available
		if (!extension_loaded('soap')) $this->warning .= $this->l('The SOAP extension is not available or configured on the server ; The module will not work without this extension ! Please contact your host to activate it in your PHP installation.');
		if (!self::checkPSVersion())
			$this->warning .= $this->l('This module is incompatible with your Prestashop installation. You can visit the <a href = "http://www.chronopost.fr/transport-express/livraison-colis/accueil/produits-tarifs/expertise-sectorielle/e-commerce/plateformes">Chronopost.fr </a>website to download a comptible version.');

		// Check is module is properly configured
		if (Tools::strlen(Configuration::get('CHRONOPOST_GENERAL_ACCOUNT')) < 8)
			$this->warning .= $this->l('You have to configure the module with your Chronopost contract number. If you don\'t have one, please sign in to the following address <a href = "http://www.chronopost.fr/transport-express/livraison-colis/accueil/produits-tarifs/expertise-sectorielle/pid/8400" target = "_blank">www.mychrono.chronopost.fr</a>');
	}

	public function preInstall()
	{
		if (!self::checkPSVersion())
		{
			$this->context->controller->errors[] = 'This module is incompatible with your Prestashop installation. You can visit the <a href = "http://www.chronopost.fr/transport-express/livraison-colis/accueil/produits-tarifs/expertise-sectorielle/e-commerce/plateformes">Chronopost.fr </a>website to download a comptible version.';
			return false;
		}

		// Check for SOAP
		if (!extension_loaded('soap'))
		{
			$this->context->controller->errors[] = $this->l('The SOAP extension is not available or configured on the server ; The module will not work without this extension ! Please contact your host to activate it in your PHP installation.');
			return false;
		}

		if (!parent::install()) return false;

		// Admin tab
		if (!$this->_adminInstall()) return false;

		// register hooks
		if (!$this->registerHook('extraCarrier') || // For point relais GMap
			!$this->registerHook('updateCarrier') || // For update of carrier IDs
			!$this->registerHook('newOrder') || // Processing of selected BT, NOTE : processCarrier apparently not what we want
			!$this->registerHook('header') || //
			!$this->registerHook('backOfficeHeader') || //
			!$this->registerHook('adminOrder'))
				return false;
		return true;
	}

	/** INSTALLATION-RELATED FUNCTIONS **/
	public function install()
	{
		if (Shop::isFeatureActive())
			Shop::setContext(Shop::CONTEXT_ALL);

		DB::getInstance()->execute('CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'chrono_calculateproducts_cache2` (
			 `id` int(11) NOT null AUTO_INCREMENT,
			 `postcode` varchar(10) NOT null,
			 `country` varchar(2) NOT null,
			 `chrono10` tinyint(1) NOT null,
			 `chrono18` tinyint(1) NOT null,
			 `chronoclassic` tinyint(1) NOT null,
			 `last_updated` int(11) NOT null,
			 PRIMARY KEY (`id`)
			) ENGINE = MyISAM DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1 ;');

		Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'chrono_cart_relais` (
				`id_cart` int(10) NOT null,
				`id_pr` varchar(10) NOT null,
				PRIMARY KEY (`id_cart`)
			) ENGINE = MyISAM DEFAULT CHARSET = utf8;');

		Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'chrono_lt_history` (
				`id_order` int(10) NOT null,
				`lt` varchar(20) NOT null,
				`product` varchar(2) NOT null,
				`zipcode` varchar(10) NOT null,
				`country` varchar(2) NOT null,
				`insurance` int(10) NOT null,
				`city` varchar(32) NOT null,
				PRIMARY KEY (`id_order`, `lt`)
			) ENGINE = MyISAM DEFAULT CHARSET = utf8;');

		
		Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'chrono_quickcost_cache` (
			`id` int(11) NOT null AUTO_INCREMENT,
			`product_code` varchar(2) NOT null,
			`arrcode` varchar(10) NOT null,
			`weight` decimal(10,2) NOT null,
			`price` decimal(10,2) NOT null,
			`last_updated` int(11) NOT null,
			PRIMARY KEY (`id`)
			) ENGINE = MyISAM DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1 ;');


		// pre install
		if (!$this->preInstall()) return false;

		// init config
		if (!Configuration::updateValue('CHRONOPOST_SECRET', sha1(microtime(true).mt_rand(10000, 90000)))
			|| !Configuration::updateValue('CHRONOPOST_CORSICA_SUPPLEMENT', '19.60'))
				return false;

		// add carriers in back office
		if (!$this->createChronopostCarriers(self::$_config))
			return false;

		return true;
	}

	private function _adminInstall()
	{
		$tab_export = new Tab();
		$tab_export->class_name = 'AdminExportChronopost';
		$tab_export->id_parent = Tab::getIdFromClassName('AdminParentShipping');
		$tab_export->module = 'chronopost';
		foreach (Language::getLanguages(false) as $language)
				$tab_export->name[$language['id_lang']] = $this->l('Chronopost Export');

		$tab_import = new Tab();
		$tab_import->class_name = 'AdminImportChronopost';
		$tab_import->id_parent = Tab::getIdFromClassName('AdminParentShipping');
		$tab_import->module = 'chronopost';
		foreach (Language::getLanguages(false) as $language)
				$tab_import->name[$language['id_lang']] = $this->l('Chronopost Import');

		$tab_bordereau = new Tab();
		$tab_bordereau->class_name = 'AdminBordereauChronopost';
		$tab_bordereau->id_parent = Tab::getIdFromClassName('AdminParentShipping');
		$tab_bordereau->module = 'chronopost';
		foreach (Language::getLanguages(false) as $language)
				$tab_bordereau->name[$language['id_lang']] = $this->l('Daily docket');

		return $tab_import->add() && $tab_export->add() && $tab_bordereau->add();
	}


	public static function checkPSVersion()
	{
		return ((version_compare(_PS_VERSION_, MIN_VERSION) >= 0) && (version_compare(_PS_VERSION_, MAX_VERSION) < 0));
	}


	public static function createChronopostCarriers($carrierConfig)
	{
		if (Shop::isFeatureActive())
				Shop::setContext(Shop::CONTEXT_ALL);

		// Create carriers from config
		foreach ($carrierConfig as $carrierName => $config)
		{
			$carrier = new Carrier();
			$carrier->name = $config['name'];
			$carrier->id_tax_rules_group = $config['id_tax_rules_group'];
			$carrier->url = $config['url'];
			$carrier->active = $config['active'];
			$carrier->deleted = $config['deleted'];
			$carrier->delay = $config['delay'];
			$carrier->shipping_handling = $config['shipping_handling'];
			$carrier->range_behavior = $config['range_behavior'];
			$carrier->is_module = $config['is_module'];
			$carrier->shipping_external = $config['shipping_external'];
			$carrier->external_module_name = $config['external_module_name'];
			$carrier->need_range = $config['need_range'];

			$languages = Language::getLanguages(true);

			foreach ($languages as $language)
			{
				if (array_key_exists($language['iso_code'], $config['delay']))
					$carrier->delay[$language['id_lang']] = $config['delay'][$language['iso_code']];
				else
					$carrier->delay[$language['id_lang']] = $config['delay']['fr'];
			}

			if ($carrier->add())
			{
				Configuration::updateValue($config['configuration_item'], (int)$carrier->id);

				// ASSIGN GROUPS
				$groups = Group::getgroups(true);
				foreach ($groups as $group)
					Db::getInstance()->Execute('INSERT INTO '._DB_PREFIX_.'carrier_group VALUE (\''.(int)($carrier->id).'\',\''.(int)($group['id_group']).'\')');

				// ASSIGN ZONES
				$zones = Zone::getZones();
				foreach ($zones as $zone)
					$carrier->addZone($zone['id_zone']);

				// RANGE PRICE
				$rp = new RangePrice();
				$rp->id_carrier = $carrier->id;
				$rp->delimiter1 = 0;
				$rp->delimiter2 = 100000;
				$rp->add();

				$fp = fopen(_MYDIR_.'/csv/'.$carrierName.'.csv', 'r');
				// insert prices per weight range
				while ($line = fgetcsv($fp))
				{
					$rangeWeight = new RangeWeight();
					$rangeWeight->id_carrier = $carrier->id;
					$rangeWeight->delimiter1 = $line[0];
					$rangeWeight->delimiter2 = $line[1];
					$rangeWeight->price_to_affect = $line[2];
					$rangeWeight->add();
				}

				//copy logo
				if (!copy(dirname(__FILE__).'/views/img/'.$config['logo_filename'].'.jpg', _PS_SHIP_IMG_DIR_.'/'.$carrier->id.'.jpg'))
					return false;
			}
		}
		return true;
	}

	public function uninstall()
	{
		$carriers = array(
			Configuration::get('CHRONORELAIS_CARRIER_ID'),
			Configuration::get('CHRONOPOST_CARRIER_ID'),
			Configuration::get('CHRONOEXPRESS_CARRIER_ID'),
			Configuration::get('CHRONO10_CARRIER_ID'),
			Configuration::get('CHRONO18_CARRIER_ID'),
			Configuration::get('CHRONOCLASSIC_CARRIER_ID')
		);

		foreach ($carriers as $cid)
		{
			$c = new Carrier($cid);
			if (Validate::isLoadedObject($c))
			{
				$c->deleted = true;
				$c->save();
			}
		}

		$tab = new Tab(Tab::getIdFromClassName('AdminExportChronopost'));
		if (!$tab->delete()) return false;

		$tab = new Tab(Tab::getIdFromClassName('AdminImportChronopost'));
		if (!$tab->delete()) return false;

		$tab = new Tab(Tab::getIdFromClassName('AdminBordereauChronopost'));
		if (!$tab->delete()) return false;

		return parent::uninstall();
	}



	public static function gettingReadyForSaturday()
	{
		if (Configuration::get('CHRONOPOST_SATURDAY_ACTIVE') != 'yes') return false;

		$start = new DateTime('last sun');
		// COMPAT < 5.36 : no chaining (returns null)
		$start->modify('+'.Configuration::get('CHRONOPOST_SATURDAY_DAY_START').' days');
		$start->modify('+'.Configuration::get('CHRONOPOST_SATURDAY_HOUR_START').' hours');
		$start->modify('+'.Configuration::get('CHRONOPOST_SATURDAY_MINUTE_START').' minutes');
		$end = new DateTime('last sun');
		$end->modify('+'.Configuration::get('CHRONOPOST_SATURDAY_DAY_END').' days');
		$end->modify('+'.Configuration::get('CHRONOPOST_SATURDAY_HOUR_END').' hours');
		$end->modify('+'.Configuration::get('CHRONOPOST_SATURDAY_MINUTE_END').' minutes');

		if ($end < $start) $end->modify('+1 week');
		$now = new DateTime();

		if ($start <= $now && $now <= $end)
			return true;

		return false;
	}

	public static function isSaturdayOptionApplicable()
	{
		if (Configuration::get('CHRONOPOST_SATURDAY_CHECKED') != 'yes') return false;
		else return self::gettingReadyForSaturday();
	}

	public static function trackingStatus($id_order, $shipping_number)
	{
		// MAIL::SEND is bugged in 1.5 !
		// http://forge.prestashop.com/browse/PNM-754 (Unresolved as of 2013-04-15)
		// Context fix (it's that easy)
		Context::getContext()->link = new Link();
		// Fix context by adding employee
		if(!Context::getContext()->cookie->exists())
		{
			$cookie = new Cookie('psAdmin');
			Context::getContext()->employee = new Employee($cookie->id_employee);
		}

		$o = new Order($id_order);
		$o->shipping_number = $shipping_number;
		$o->save();

		// New in 1.5
		$id_order_carrier = Db::getInstance()->getValue('
				SELECT `id_order_carrier`
				FROM `'._DB_PREFIX_.'order_carrier`
				WHERE `id_order` = '.(int)$id_order);

		$order_carrier = new OrderCarrier($id_order_carrier);
		$order_carrier->tracking_number = $shipping_number;
		$order_carrier->id_order = $id_order;
		$order_carrier->id_carrier = $o->id_carrier;
		$order_carrier->update();
		// No, there is no method in Order to retrieve the orderCarrier object(s)

		$history = new OrderHistory();
		$history->id_order = (int)($o->id);
		$history->id_order_state = _PS_OS_SHIPPING_;
		$history->changeIdOrderState(_PS_OS_SHIPPING_, $id_order);
		$history->save();

		$customer = new Customer($o->id_customer);
		$carrier = new Carrier($o->id_carrier);
		$tracking_url = str_replace('@', $o->shipping_number, $carrier->url);
		
		$templateVars = array(
			'{tracking_link}' => '<a href = "'.$tracking_url.'">'.$o->shipping_number.'</a>',
			'{tracking_code}' => $o->shipping_number,
			'{firstname}' => $customer->firstname,
			'{lastname}' => $customer->lastname,
			'{id_order}' => (int)($o->id)
		);

		Mail::Send($o->id_lang, 'tracking', 'Tracking number for your order', $templateVars, $customer->email,
			$customer->firstname.' '.$customer->lastname, null, null, null, null, _MYDIR_.'/mails/', true);
	}

	public static function errorStatus($id_order)
	{
		/*
		Must be kept as a placeholder for customized deployments.

		$history = new OrderHistory();
		$history->id_order = (int)($id_order);
		$history->changeIdOrderState(10, (int)($id_order)); // TODO with conf value
		$history->save();
		*/
	}


	public static function amountToInsure($id_order)
	{
		if (Configuration::get('CHRONOPOST_ADVALOREM_ENABLED') == 0) return -1;
		$order = new Order($id_order);
		if ($order->total_products < (float)Configuration::get('CHRONOPOST_ADVALOREM_MINVALUE')) return 0;
		return $order->total_products;
	}

	public function hookUpdateCarrier($params)
	{
		if (Shop::isFeatureActive())
			Shop::setContext(Shop::CONTEXT_ALL);

		// Ensures that if our carrier ID changes after a modification, we still have it up-to-date
		if ((int)($params['id_carrier']) == (int)(Configuration::get('CHRONORELAIS_CARRIER_ID')))
			Configuration::updateValue('CHRONORELAIS_CARRIER_ID', $params['carrier']->id);

		else if ((int)($params['id_carrier']) == (int)(Configuration::get('CHRONOPOST_CARRIER_ID')))
			Configuration::updateValue('CHRONOPOST_CARRIER_ID', $params['carrier']->id);

		else if ((int)($params['id_carrier']) == (int)(Configuration::get('CHRONOEXPRESS_CARRIER_ID')))
			Configuration::updateValue('CHRONOEXPRESS_CARRIER_ID', $params['carrier']->id);

		else if ((int)($params['id_carrier']) == (int)(Configuration::get('CHRONO10_CARRIER_ID')))
					Configuration::updateValue('CHRONO10_CARRIER_ID', $params['carrier']->id);

		else if ((int)($params['id_carrier']) == (int)(Configuration::get('CHRONO18_CARRIER_ID')))
					Configuration::updateValue('CHRONO18_CARRIER_ID', $params['carrier']->id);
		else if ((int)($params['id_carrier']) == (int)(Configuration::get('CHRONOCLASSIC_CARRIER_ID')))
					Configuration::updateValue('CHRONOCLASSIC_CARRIER_ID', $params['carrier']->id);

		// Ensures Chrono18 && Chrono13 not selected at the same time
		$c18 = new Carrier(Configuration::get('CHRONO18_CARRIER_ID'));
		$c13 = new Carrier(Configuration::get('CHRONOPOST_CARRIER_ID'));

		if (($params['carrier']->id == Configuration::get('CHRONOPOST_CARRIER_ID') && (int)$params['carrier']->active == 1
				&& $c18->active == 1)
			|| ($params['carrier']->id == Configuration::get('CHRONO18_CARRIER_ID') && (int)$params['carrier']->active == 1
				&& $c13->active == 1))
		{
			$params['carrier']->active = 0;
			$params['carrier']->save();

			echo '<script>alert("'.$this->l('You can\'t activate simultaneously Chronopost before 13h and before 18h.').'");
				history.back();
			</script>';
			exit();
		}
	}

	public function hookNewOrder($params)
	{
		// Are we dealing with Chronorelais here ?
		if (Configuration::get('CHRONORELAIS_CARRIER_ID') != $params['order']->id_carrier) return;

		$relais = Db::getInstance()->getValue('SELECT id_pr FROM `'._DB_PREFIX_.'chrono_cart_relais` WHERE id_cart = '.(int)$params['cart']->id);
		if (!$relais) return;

		include_once _PS_MODULE_DIR_.'/chronopost/libraries/PointRelaisServiceWSService.php';

		// Update order delivery address to PR address (new in 2.8.4 per support #300)

		// Data
		$cart = $params['cart'];
		if (!Validate::isLoadedObject($cart)) return;

		$current_address = new Address($cart->id_address_delivery);

		// Getting relais details
		// We have to use PointRelaisService so we are in Chronopost's most up-to-date environnement
		$ws = new PointRelaisServiceWSService();
		$paramsw = new rechercheDetailPointChronopost ();
		$paramsw->accountNumber = Configuration::get('CHRONOPOST_GENERAL_ACCOUNT');
		$paramsw->password = Configuration::get('CHRONOPOST_GENERAL_PASSWORD');
		$paramsw->identifiant = $relais;
		$bt = $ws->rechercheDetailPointChronopost($paramsw)->return->listePointRelais;

		// Populate Address object
		$a = new Address();
		$a->alias = 'Point ChronoRelais '.$bt->identifiant;
		$a->id_customer = $cart->id_customer;
		$a->id_country = Country::getByIso('FR');
		$a->company = Tools::substr($bt->nom, 0, 32);
		$a->lastname = $current_address->lastname;
		$a->firstname = $current_address->firstname;
		$a->address1 = $bt->adresse1;
		$a->address2 = isset($bt->adresse2) ? $bt->adresse2 : '';
		$a->postcode = $bt->codePostal;
		$a->city = $bt->localite;
		$a->phone = $current_address->phone;
		$a->phone_mobile = $current_address->phone_mobile;
		$a->other = $bt->identifiant; // ID Point Relais
		$a->active = 0;
		$a->deleted = 1;
		$a->id_customer = null;
		$a->id_manufacturer = null;

		// Save && assign to cart
		$a->save();
		$params['order']->id_address_delivery = $a->id;
		$params['order']->save();
	}


	public function hookBackOfficeHeader($params)
	{
		return '<script>
			$(document).ready(function() {
				$.get("'._MODULE_DIR_.'chronopost/async/updateTracking.php");
			});
		</script>
		';
	}

	public function hookHeader($params)
	{
		// check if on right page
		$file = Tools::getValue('controller');
		if (!in_array($file, array('order-opc', 'order', 'orderopc'))) return;

		$module_uri = _MODULE_DIR_.$this->name;
		$this->context->controller->addCSS($module_uri.'/views/css/chronorelais.css', 'all');
		$this->context->controller->addJS('https://maps.google.com/maps/api/js?sensor=false');
		$this->context->controller->addJS($module_uri.'/views/js/chronorelais.js');
	}

	public function hookExtraCarrier($params)
	{
		$address = new Address($params['cart']->id_address_delivery);
		$this->context->smarty->assign(
			array(
				'module_uri' =>__PS_BASE_URI__.'modules/'.$this->name,
				'cust_codePostal' => $address->postcode,
				'cust_firstname' => $address->firstname,
				'cust_lastname' => $address->lastname,
				'cartID' => $params['cart']->id,
				'carrierID' => Configuration::get('CHRONORELAIS_CARRIER_ID'),
				'carrierIntID' => (string)Cart::intifier(Configuration::get('CHRONORELAIS_CARRIER_ID').','),
				'cust_address' => $address->address1.' '.$address->address2.' '
			.$address->postcode.' '.$address->city,
				'cust_address_clean' => $address->address1.' '.$address->address2.' ',
				'cust_city' => $address->city
			)
		);

		return $this->context->smarty->fetch(dirname(__FILE__).'/views/templates/hook/chronorelais.tpl');
	}

	public static function getPointRelaisAddress($orderid)
	{
		$order = new Order($orderid);
		include_once _MYDIR_.'/libraries/PointRelaisServiceWSService.php';

		if ($order->id_carrier != Configuration::get('CHRONORELAIS_CARRIER_ID')) return null;


		$btid = Db::getInstance()->getRow('SELECT id_pr FROM `'._DB_PREFIX_.'chrono_cart_relais` WHERE id_cart = '.$order->id_cart);
		$btid = $btid['id_pr'];

		// Fetch BT object
		$ws = new PointRelaisServiceWSService();

		$p = new rechercheBtAvecPFParIdChronopostA2Pas();
		$p->id = $btid;
		$bt = $ws->rechercheBtAvecPFParIdChronopostA2Pas($p)->return;

		return $bt;

	}

	public static function minNumberOfPackages($orderid)
	{
		$order = new Order($orderid);
		$nblt = 1;


		if ($order->getTotalWeight() * Configuration::get('CHRONOPOST_GENERAL_WEIGHTCOEF') > 20 && $order->id_carrier == Configuration::get('CHRONORELAIS_CARRIER_ID'))
			$nblt = ceil($order->getTotalWeight() * Configuration::get('CHRONOPOST_GENERAL_WEIGHTCOEF') / 20);
		if ($order->getTotalWeight() * Configuration::get('CHRONOPOST_GENERAL_WEIGHTCOEF') > 30)
			$nblt = ceil($order->getTotalWeight() * Configuration::get('CHRONOPOST_GENERAL_WEIGHTCOEF') / 30);

		return $nblt;
	}

	public static function isChrono($id_carrier)
	{
		return $id_carrier == Configuration::get('CHRONOPOST_CARRIER_ID')
			|| $id_carrier == Configuration::get('CHRONORELAIS_CARRIER_ID')
			|| $id_carrier == Configuration::get('CHRONOEXPRESS_CARRIER_ID')
			|| $id_carrier == Configuration::get('CHRONO10_CARRIER_ID')
			|| $id_carrier == Configuration::get('CHRONO18_CARRIER_ID')
			|| $id_carrier == Configuration::get('CHRONOCLASSIC_CARRIER_ID');
	}

	public function hookAdminOrder($params)
	{
		$order = new Order((int)$params['id_order']);
		if (!Validate::isLoadedObject($order)) return '';

		if (!self::isChrono($order->id_carrier)) return '';
		$this->context->smarty->assign(
			array(
				'module_uri' =>__PS_BASE_URI__.'modules/'.$this->name,
				'id_order' => $params['id_order'],
				'chronopost_secret' => Configuration::get('CHRONOPOST_SECRET'),
				'bal' => Configuration::get('CHRONOPOST_BAL_ENABLED') == 1 && ($order->id_carrier == Configuration::get('CHRONOPOST_CARRIER_ID') || $order->id_carrier == Configuration::get('CHRONO18_CARRIER_ID')) ? 1 : 0,
				'saturday' => self::gettingReadyForSaturday() ? 1 : 0,
				'saturday_ok' => self::isSaturdayOptionApplicable() ? 1 : 0,
				'to_insure' =>  self::amountToInsure($params['id_order']),
				'nbwb' => self::minNumberOfPackages($params['id_order']),
				'return' => $order->id_carrier != Configuration::get('CHRONOEXPRESS_CARRIER_ID') && $order->id_carrier != Configuration::get('CHRONOCLASSIC_CARRIER_ID') ? 1 : 0
			)
		);
		if (version_compare(_PS_VERSION_, 1.6) >= 0)
			return $this->context->smarty->fetch(dirname(__FILE__).'/views/templates/hook/adminOrder-16.tpl');
		else
			return $this->context->smarty->fetch(dirname(__FILE__).'/views/templates/hook/adminOrder-15.tpl');
	}

	public static function calculateProducts($cart)
	{
		$a = new Address($cart->id_address_delivery);
		$c = new Country($a->id_country);

		$res = array('chrono10' => false, 'chronoclassic' => false, 'chrono18' => false);

		$cache = Db::getInstance()->executeS('SELECT chrono10, chrono18, chronoclassic, last_updated FROM `'._DB_PREFIX_.'chrono_calculateproducts_cache2` WHERE postcode = "'.pSQL($a->postcode).'" && country = "'.pSQL($c->iso_code).'"');

		if (empty($cache) || $cache[0]['last_updated'] + 24 * 3600 < time())
		{
			// QUICKCOST & CALCULATE PRODUCTS
			include_once(_MYDIR_.'/libraries/QuickcostServiceWSService.php');

			$ws = new QuickcostServiceWSService();
			$cp = new calculateProducts();

			$cp->accountNumber = Configuration::get('CHRONOPOST_GENERAL_ACCOUNT');
			$cp->password = Configuration::get('CHRONOPOST_GENERAL_PASSWORD');
			$cp->depZipCode = Configuration::get('CHRONOPOST_SHIPPER_ZIPCODE');
			$cp->depCountryCode = 'FR';
			$cp->weight = $cart->getTotalWeight() * Configuration::get('CHRONOPOST_GENERAL_WEIGHTCOEF') + 0.1;
			$cp->arrCountryCode = $c->iso_code;
			$cp->arrZipCode = $a->postcode;
			$cp->type = 'M';

			try {
				$cpres = $ws->calculateProducts($cp);
			} catch(Exception $e)
			{
				return $res;
			}

			if (empty($cpres->return->productList)) return $res;

			foreach ($cpres->return->productList as $product)
			{
				if ($product->productCode == 2)
					$res['chrono10'] = true;

				if ($product->productCode == 16)
					$res['chrono18'] = true;

				if ($product->productCode == 44)
					$res['chronoclassic'] = true;
			}

			// INSERT cache
			if (empty($cache))
			{
				$sql = 'INSERT INTO `'._DB_PREFIX_.'chrono_calculateproducts_cache2`
					(`postcode`,`country`, `chrono10`,`chrono18`, `chronoclassic`,`last_updated`) VALUES
					("'.pSQL($a->postcode).'", "'.pSQL($c->iso_code).'", '.($res['chrono10'] == true?1:0).', '.($res['chrono18'] == true?1:0).',
					'.($res['chronoclassic'] == true?1:0).', '.time().')';
				Db::getInstance()->Execute($sql);
			}
			else // UPDATE cache
				Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'chrono_calculateproducts_cache2`
					SET `chrono10` = '.($res['chrono10'] == true ? 1 : 0).', `chrono18` = '.($res['chrono18'] == true?1:0).',
					 `chronoclassic` = '.($res['chronoclassic'] == true?1:0).',
					 `last_updated` = '.time().' WHERE postcode = "'.pSQL($a->postcode).'" && country = "'.pSQL($c->iso_code).'"');
		}
		else
		{
			$res['chrono10'] = $cache[0]['chrono10'];
			$res['chrono18'] = $cache[0]['chrono18'];
			$res['chronoclassic'] = $cache[0]['chronoclassic'];
		}

		return $res;
	}


	/** CARRIER-RELATED FUNCTIONS **/
	public function getOrderShippingCost($cart, $shipping_cost)
	{
		$productCode = 1;
		$classicAvailable = true;
		$relaisAvailable = true;
		if ($cart->id_address_delivery == 0) return $shipping_cost; // CASE NOT LOGGED IN

		$a = new Address($cart->id_address_delivery);
		$c = new Country($a->id_country);

		foreach ($cart->getProducts() as $p)
		{
			// check if no product > 20 kg
			if ($p['weight'] * Configuration::get('CHRONOPOST_GENERAL_WEIGHTCOEF') > 20)
				$relaisAvailable = false;

			if ($p['weight'] * Configuration::get('CHRONOPOST_GENERAL_WEIGHTCOEF') > 30)
			{
				$classicAvailable = false;
				break;
			}
		}

		if (!$classicAvailable) return false;

		// CALCULATE PRODUCTS
		if ($this->id_carrier == Configuration::get('CHRONO10_CARRIER_ID') || $this->id_carrier == Configuration::get('CHRONOCLASSIC_CARRIER_ID') || $this->id_carrier == Configuration::get('CHRONO18_CARRIER_ID'))
			$calculatedProducts = self::calculateProducts($cart);

		switch ($this->id_carrier)
		{
			case Configuration::get('CHRONORELAIS_CARRIER_ID'):
				$productCode = self::$productCodes['CHRONORELAIS_CARRIER_ID'];
				if ($c->iso_code != 'FR' && $c->iso_code != 'FX')
					return false;

				if (!$relaisAvailable) return false;
			break;

			case Configuration::get('CHRONOPOST_CARRIER_ID'):
				$productCode = self::$productCodes['CHRONOPOST_CARRIER_ID'];
				if ($c->iso_code != 'FR' && $c->iso_code != 'FX') return false;
			break;

			case Configuration::get('CHRONO10_CARRIER_ID'):
				if ($calculatedProducts['chrono10'] == false) return false;
				$productCode = self::$productCodes['CHRONO10_CARRIER_ID'];
			break;

			case Configuration::get('CHRONO18_CARRIER_ID'):
				if ($c->iso_code != 'FR' && $c->iso_code != 'FX') return false;
				if ($calculatedProducts['chrono18'] == false) return false;
				$productCode = self::$productCodes['CHRONO18_CARRIER_ID'];
			break;

			case Configuration::get('CHRONOEXPRESS_CARRIER_ID'):
				if ($c->iso_code == 'FR' || $c->iso_code == 'FX') return false;
				$productCode = self::$productCodes['CHRONOEXPRESS_CARRIER_ID'];
			break;

			case Configuration::get('CHRONOCLASSIC_CARRIER_ID'):
				if ($calculatedProducts['chronoclassic'] == false) return false;
				$productCode = self::$productCodes['CHRONOCLASSIC_CARRIER_ID'];
			break;
		}

		if (Configuration::get('CHRONOPOST_QUICKCOST_ENABLED') == 0)
		{

			if ($c->iso_code == 'FR' && $a->postcode >= 20000 && $a->postcode < 21000)
				return $shipping_cost + (float)Configuration::get('CHRONOPOST_CORSICA_SUPPLEMENT');

			// Let's just use Prestashop's native calculations
			return $shipping_cost;
		}

		$arrcode = (($c->iso_code == 'FR' || $c->iso_code == 'FX')?$a->postcode:$c->iso_code);
		$cache = Db::getInstance()->executeS('SELECT price, last_updated FROM `'._DB_PREFIX_.'chrono_quickcost_cache` WHERE arrcode = "'.pSQL($arrcode).'" && product_code="'.$productCode.'" && weight="'.$cart->getTotalWeight().'"');

		if (!empty($cache) && $cache[0]['last_updated'] + 24 * 3600 > time())
		{
			// return from cache
			return $cache[0]['price'];
		}

		include_once(_MYDIR_.'/libraries/QuickcostServiceWSService.php');
		$ws = new QuickcostServiceWSService();
		$qc = new quickCost();
		$qc->accountNumber = Configuration::get('CHRONOPOST_GENERAL_ACCOUNT');
		$qc->password = Configuration::get('CHRONOPOST_GENERAL_PASSWORD');
		$qc->depCode = Configuration::get('CHRONOPOST_SHIPPER_ZIPCODE');
		$qc->arrCode = $arrcode;
		$qc->weight = $cart->getTotalWeight();
		if ($qc->weight == 0) $qc->weight = 0.1; // 0 yeilds an error

		$qc->productCode = $productCode;

		$qc->type = 'M';

		try {
			$res = $ws->quickCost($qc);

		} catch(Exception $e)
		{
			return $shipping_cost;
		}

		if ($res->return->amountTTC != 0)
		{
			if(empty($cache))
			{
				DB::getInstance()->query('INSERT INTO '._DB_PREFIX_.'chrono_quickcost_cache (product_code, arrcode, weight, price, last_updated) VALUES (
						"'.pSQL($productCode).'",
						"'.pSQL($arrcode).'",
						"'.(float)$cart->getTotalWeight().'",
						"'.(float)$res->return->amountTTC.'",
						"'.time().'")
				');
			}
			else 
				DB::getInstance()->query('UPDATE '._DB_PREFIX_.'chrono_quickcost_cache SET price="'.(float)$res->return->amount.'", last_updated='.time().'
					WHERE arrcode = "'.pSQL($arrcode).'" and product_code="'.pSQL($productCode).'" and weight="'.(float)$cart->getTotalWeight().'"
				');

			return $res->return->amountTTC;
		}
		if ($res->return->amount != 0)
			return $res->return->amount;


		return $shipping_cost;
	}

	public function getOrderShippingCostExternal($params)
	{
		return $this->getOrderShippingCost($params, 0);
	}

	/** ADMINISTRATION **/
	private function _generateChronoForm($prefix)
	{
		$prefix = Tools::strtolower($prefix);
		$var_name = Tools::strtoupper($prefix);
		$vars = array('civility', 'name', 'name2', 'address', 'address2', 'zipcode', 'city', 'contactname', 'email', 'phone', 'mobile');
		$smarty = array();
		$smarty['prefix'] = $prefix;

		foreach ($vars as $var)
			$smarty[$var] = Configuration::get('CHRONOPOST_'.$var_name.'_'.Tools::strtoupper($var));

		$this->context->smarty->assign($smarty);
		return $this->context->smarty->fetch(dirname(__FILE__).'/views/templates/admin/contact.tpl');
	}

	private function _dayField($fieldName, $default)
	{
		$selected = Configuration::get('CHRONOPOST_SATURDAY_'.Tools::strtoupper($fieldName));
		if ($selected === false) $selected = $default;

		$this->context->smarty->assign(
			array(
				'selected' => $selected,
				'field_name' => $fieldName
			)
		);

		return $this->context->smarty->fetch(dirname(__FILE__).'/views/templates/admin/days.tpl');
	}

	private function _hourField($fieldName, $default)
	{
		$selected = Configuration::get('CHRONOPOST_SATURDAY_'.Tools::strtoupper($fieldName));
		if ($selected === false) $selected = $default;

		// Smarty is so painful
		$this->context->smarty->assign(
			array(
				'selected' => $selected,
				'field_name' => $fieldName
			)
		);

		return $this->context->smarty->fetch(dirname(__FILE__).'/views/templates/admin/hours.tpl');
	}

	private function _minuteField($fieldName, $default = 0)
	{
		$selected = Configuration::get('CHRONOPOST_SATURDAY_'.Tools::strtoupper($fieldName));
		if ($selected === false) $selected = $default;

		// Can't stop the pain
		$this->context->smarty->assign(
			array(
				'selected' => $selected,
				'field_name' => $fieldName
			)
		);

		return $this->context->smarty->fetch(dirname(__FILE__).'/views/templates/admin/minutes.tpl');
	}

	private function _postValidation()
	{
		return true;
	}

	private function _postProcess()
	{
		if (Shop::isFeatureActive())
				Shop::setContext(Shop::CONTEXT_ALL);

		foreach (Tools::getValue('chronoparams') as $prefix => $var)
			foreach ($var as $varname => $value)
				Configuration::updateValue('CHRONOPOST_'.Tools::strtoupper($prefix).'_'.Tools::strtoupper($varname), $value);

		return true;
	}

	public function getContent()
	{
		$html = '';
		if (Tools::isSubmit('submitchronoRelaisConfig'))
		{
			if ($this->_postValidation() && $this->_postProcess())
				$html .= Module::displayConfirmation($this->l('Settings updated.'));
		}
		return $html.$this->displayForm();
	}

	public function displayForm()
	{
		$printMode = array(
			'PDF' => $this->l('PDF file'),
			'THE' => $this->l('Thermal printer'),
			'SPD' => $this->l('PDF without delivery proof')
			//'SER' =>'Imprimante thermique Chronopost'
		);

		$unitCoef = array(
			'KG' => '1',
			'G' => '0.001'
		);

		$this->adminDisplayInformation($this->l('Offer to your customers the first Express delivery service with the offical Chronopost module for Prestashop 1.5 and 1.6. With Chronopost, your customer will have the choice of the main delivery modes within 24h : at home,  at a Pickup point or at the office !')
			.'<br/>'.$this->l('Your customers will also have the Predict service :  They are notified by email or SMS the day before the delivery and can reschedule the delivery or ask to be delivered at a pickup point among more than 17 000 points (post offices, Pickup relay or Chronopost agencies).').'<br/><br/>'.
			$this->l('Expand your business internationally with Chronopost international delivery service which is included in this module.').'<br/>'.
			$this->l('Find all these services in the Chronopost e-commerce pack : MyChrono.').'<br/>'.
			$this->l('To activate the module on your site, contact us at ').'<a href="mailto:demandez-a-chronopost@chronopost.fr">demandez-a-chronopost@chronopost.fr</a>');

		// smarty-chain !
		$this->context->smarty->assign(
			array(
				'post_uri' => $_SERVER['REQUEST_URI'],
				'chronopost_secret' => Configuration::get('CHRONOPOST_SECRET'),
				'print_modes' => $printMode,
				'selected_print_mode' => Configuration::get('CHRONOPOST_GENERAL_PRINTMODE'),
				'weights' => $unitCoef,
				'selected_weight' => Configuration::get('CHRONOPOST_GENERAL_WEIGHTCOEF'),
				'module_dir' => _MODULE_DIR_,
				'general_account' => Configuration::get('CHRONOPOST_GENERAL_ACCOUNT'),
				'general_subaccount' => Configuration::get('CHRONOPOST_GENERAL_SUBACCOUNT'),
				'general_password' => Configuration::get('CHRONOPOST_GENERAL_PASSWORD'),
				'saturday_active' => Configuration::get('CHRONOPOST_SATURDAY_ACTIVE'),
				'saturday_checked' => Configuration::get('CHRONOPOST_SATURDAY_CHECKED'),
				'day_start' => $this->_dayField('day_start', 4),
				'hour_start' => $this->_hourField('hour_start', 18),
				'minute_start' => $this->_minuteField('minute_start'),
				'day_end' => $this->_dayField('day_end', 5),
				'hour_end' => $this->_hourField('hour_end', 16),
				'minute_end' => $this->_minuteField('minute_end'),
				'corsica_supplement' => Configuration::get('CHRONOPOST_CORSICA_SUPPLEMENT'),
				'quickcost_enabled' => Configuration::get('CHRONOPOST_QUICKCOST_ENABLED'),
				'advalorem_enabled' => Configuration::get('CHRONOPOST_ADVALOREM_ENABLED'),
				'advalorem_minvalue' => Configuration::get('CHRONOPOST_ADVALOREM_MINVALUE'),
				'bal_enabled' => Configuration::get('CHRONOPOST_BAL_ENABLED'),
				'shipper_form' => $this->_generateChronoForm('shipper'),
				'customer_form' => $this->_generateChronoForm('customer')
			)
		);

		return $this->context->smarty->fetch(dirname(__FILE__).'/views/templates/admin/config.tpl');
	}
}

?>
