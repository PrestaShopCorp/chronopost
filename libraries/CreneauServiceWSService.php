<?php
class searchDeliverySlot {
	/** @var string */	public $callerTool;
	/** @var string */	public $productType;
	/** @var string */	public $customerAdress1;
	/** @var string */	public $customerAdress2;
	/** @var string */	public $customerZipCode;
	/** @var string */	public $customerCity;
	/** @var string */	public $customerCountry;
	/** @var string */	public $recipientAdress1;
	/** @var string */	public $recipientAdress2;
	/** @var string */	public $recipientZipCode;
	/** @var string */	public $recipientCity;
	/** @var string */	public $recipientCountry;
	/** @var string */	public $injectionSite;
	/** @var int */	public $weight;
	/** @var dateTime */	public $dateBegin;
	/** @var dateTime */	public $dateEnd;
	/** @var string */	public $customerDeliverySlotClosed;
}

class searchDeliverySlotResponse {
	/** @var deliverySlotResponse */	public $return;
}

class deliverySlotResponse extends wsResponse {
	/** @var string */	public $codeTuile;
	/** @var rdvCreneau */	public $rdvCreneauList;
}

class wsResponse {
	/** @var int */	public $code;
	/** @var string */	public $message;
}

class rdvCreneau {
	/** @var string */	public $deliverySlotCode;
	/** @var string */	public $deliveryDate;
	/** @var int */	public $dayOfWeek;
	/** @var int */	public $startHour;
	/** @var int */	public $startMinutes;
	/** @var int */	public $endHour;
	/** @var int */	public $endMinutes;
	/** @var string */	public $tariffLevel;
	/** @var string */	public $status;
	/** @var string */	public $codeStatus;
	/** @var int */	public $note;
	/** @var boolean */	public $incitementFlag;
	/** @var int */	public $rank;
	/** @var int */	public $position;
}

class confirmDeliverySlot {
	/** @var string */	public $callerTool;
	/** @var string */	public $productType;
	/** @var string */	public $codeSlot;
	/** @var string */	public $codeTuile;
}

class confirmDeliverySlotResponse {
	/** @var serviceResponse */	public $return;
}

class serviceResponse extends wsResponse {
	/** @var serviceProduit */	public $serviceProduit;
}

class serviceProduit {
	/** @var string */	public $codeProduit;
	/** @var string */	public $codeService;
}


/**
 * CreneauServiceWSService class
 * 
 *  
 * 
 * @author    {author}
 * @copyright {copyright}
 * @package   {package}
 */
class CreneauServiceWSService extends \SoapClient {

	const WSDL_FILE = "CreneauServiceWSService.xml";
	private $classmap = array(
			'searchDeliverySlot' => 'searchDeliverySlot',
			'searchDeliverySlotResponse' => 'searchDeliverySlotResponse',
			'deliverySlotResponse' => 'deliverySlotResponse',
			'wsResponse' => 'wsResponse',
			'rdvCreneau' => 'rdvCreneau',
			'confirmDeliverySlot' => 'confirmDeliverySlot',
			'confirmDeliverySlotResponse' => 'confirmDeliverySlotResponse',
			'serviceResponse' => 'serviceResponse',
			'serviceProduit' => 'serviceProduit',
			);

	public function __construct($wsdl = null, $options = array()) {
		foreach($this->classmap as $key => $value) {
			if(!isset($options['classmap'][$key])) {
				$options['classmap'][$key] = $value;
			}
		}
		if(isset($options['headers'])) {
			$this->__setSoapHeaders($options['headers']);
		}
		parent::__construct($wsdl ?: self::WSDL_FILE, $options);
	}

	/**
	 *  
	 *
	 * @param searchDeliverySlot $parameters
	 * @return searchDeliverySlotResponse
	 */
	public function searchDeliverySlot(searchDeliverySlot $parameters) {
		return $this->__soapCall('searchDeliverySlot', array($parameters), array(
						'uri' => 'http://cxf.soap.ws.creneau.chronopost.fr/',
						'soapaction' => ''
					)
			);
	}

	/**
	 *  
	 *
	 * @param confirmDeliverySlot $parameters
	 * @return confirmDeliverySlotResponse
	 */
	public function confirmDeliverySlot(confirmDeliverySlot $parameters) {
		return $this->__soapCall('confirmDeliverySlot', array($parameters), array(
						'uri' => 'http://cxf.soap.ws.creneau.chronopost.fr/',
						'soapaction' => ''
					)
			);
	}

}


