<?php
class resultTrackWithSenderRef {
	/** @var int */	public $errorCode;
	/** @var string */	public $errorMessage;
	/** @var listEvents */	public $listParcel;
}

class listEvents {
	/** @var event */	public $events;
	/** @var string */	public $skybillNumber;
}

class event {
	/** @var string */	public $code;
	/** @var dateTime */	public $eventDate;
	/** @var string */	public $eventLabel;
	/** @var boolean */	public $highPriority;
	/** @var string */	public $NPC;
	/** @var string */	public $officeLabel;
	/** @var string */	public $zipCode;
}

class resultTrackSearch {
	/** @var int */	public $errorCode;
	/** @var string */	public $errorMessage;
	/** @var infosPOD */	public $listInfosPOD;
}

class infosPOD {
	/** @var dateTime */	public $dateDeposit;
	/** @var string */	public $depositCountry;
	/** @var string */	public $depositZipCode;
	/** @var string */	public $objectType;
	/** @var string */	public $recipientCity;
	/** @var string */	public $recipientCountry;
	/** @var string */	public $recipientName;
	/** @var string */	public $recipientRef;
	/** @var string */	public $recipientZipCode;
	/** @var string */	public $shipperCity;
	/** @var string */	public $shipperRef;
	/** @var string */	public $shipperZipCode;
	/** @var event */	public $significantEvent;
	/** @var string */	public $skybillNumber;
}

class resultTrackSkybillV2 {
	/** @var int */	public $errorCode;
	/** @var string */	public $errorMessage;
	/** @var listEventInfoComps */	public $listEventInfoComp;
}

class listEventInfoComps {
	/** @var eventInfoComp */	public $events;
	/** @var string */	public $skybillNumber;
}

class eventInfoComp extends event {
	/** @var infoComp */	public $infoCompList;
}

class infoComp {
	/** @var string */	public $name;
	/** @var string */	public $value;
}

class resultTrackSkybill {
	/** @var int */	public $errorCode;
	/** @var string */	public $errorMessage;
	/** @var listEvents */	public $listEvents;
}

class resultCancelSkybill {
	/** @var int */	public $errorCode;
	/** @var string */	public $errorMessage;
	/** @var int */	public $statusCode;
}

class resultSearchPOD {
	/** @var int */	public $errorCode;
	/** @var string */	public $errorMessage;
	/** @var string */	public $formatPOD;
	/** @var base64Binary */	public $pod;
	/** @var boolean */	public $podPresente;
	/** @var int */	public $statusCode;
}

class resultSearchPODWithSenderRef {
	/** @var int */	public $errorCode;
	/** @var string */	public $errorMessage;
	/** @var parcelPOD */	public $listParcelPOD;
}

class parcelPOD {
	/** @var string */	public $formatPOD;
	/** @var base64Binary */	public $pod;
	/** @var boolean */	public $podPresente;
	/** @var string */	public $skybillNumber;
	/** @var int */	public $statusCode;
}

class trackWithSenderRef {
	/** @var string */	public $accountNumber;
	/** @var string */	public $password;
	/** @var string */	public $language;
	/** @var string */	public $sendersRef;
}

class trackWithSenderRefResponse {
	/** @var resultTrackWithSenderRef */	public $return;
}

class trackSearch {
	/** @var string */	public $accountNumber;
	/** @var string */	public $password;
	/** @var string */	public $language;
	/** @var string */	public $consigneesCountry;
	/** @var string */	public $consigneesRef;
	/** @var string */	public $consigneesZipCode;
	/** @var string */	public $dateDeposit;
	/** @var string */	public $dateEndDeposit;
	/** @var string */	public $parcelState;
	/** @var string */	public $sendersRef;
	/** @var string */	public $serviceCode;
}

class trackSearchResponse {
	/** @var resultTrackSearch */	public $return;
}

class trackSkybillV2 {
	/** @var string */	public $language;
	/** @var string */	public $skybillNumber;
}

class trackSkybillV2Response {
	/** @var resultTrackSkybillV2 */	public $return;
}

class trackSkybill {
	/** @var string */	public $language;
	/** @var string */	public $skybillNumber;
}

class trackSkybillResponse {
	/** @var resultTrackSkybill */	public $return;
}

class cancelSkybill {
	/** @var string */	public $accountNumber;
	/** @var string */	public $password;
	/** @var string */	public $language;
	/** @var string */	public $skybillNumber;
}

class cancelSkybillResponse {
	/** @var resultCancelSkybill */	public $return;
}

class searchPOD {
	/** @var string */	public $accountNumber;
	/** @var string */	public $password;
	/** @var string */	public $language;
	/** @var string */	public $skybillNumber;
	/** @var boolean */	public $pdf;
}

class searchPODResponse {
	/** @var resultSearchPOD */	public $return;
}

class searchPODWithSenderRef {
	/** @var string */	public $accountNumber;
	/** @var string */	public $password;
	/** @var string */	public $language;
	/** @var string */	public $sendersRef;
	/** @var boolean */	public $pdf;
}

class searchPODWithSenderRefResponse {
	/** @var resultSearchPODWithSenderRef */	public $return;
}


/**
 * TrackingServiceWSService class
 * 
 *  
 * 
 * @author    {author}
 * @copyright {copyright}
 * @package   {package}
 */
class TrackingServiceWSService extends \SoapClient {

	const WSDL_FILE = "https://www.chronopost.fr/tracking-cxf/TrackingServiceWS?wsdl";
	private $classmap = array(
			'resultTrackWithSenderRef' => 'resultTrackWithSenderRef',
			'listEvents' => 'listEvents',
			'event' => 'event',
			'resultTrackSearch' => 'resultTrackSearch',
			'infosPOD' => 'infosPOD',
			'resultTrackSkybillV2' => 'resultTrackSkybillV2',
			'listEventInfoComps' => 'listEventInfoComps',
			'eventInfoComp' => 'eventInfoComp',
			'infoComp' => 'infoComp',
			'resultTrackSkybill' => 'resultTrackSkybill',
			'resultCancelSkybill' => 'resultCancelSkybill',
			'resultSearchPOD' => 'resultSearchPOD',
			'resultSearchPODWithSenderRef' => 'resultSearchPODWithSenderRef',
			'parcelPOD' => 'parcelPOD',
			'trackWithSenderRef' => 'trackWithSenderRef',
			'trackWithSenderRefResponse' => 'trackWithSenderRefResponse',
			'trackSearch' => 'trackSearch',
			'trackSearchResponse' => 'trackSearchResponse',
			'trackSkybillV2' => 'trackSkybillV2',
			'trackSkybillV2Response' => 'trackSkybillV2Response',
			'trackSkybill' => 'trackSkybill',
			'trackSkybillResponse' => 'trackSkybillResponse',
			'cancelSkybill' => 'cancelSkybill',
			'cancelSkybillResponse' => 'cancelSkybillResponse',
			'searchPOD' => 'searchPOD',
			'searchPODResponse' => 'searchPODResponse',
			'searchPODWithSenderRef' => 'searchPODWithSenderRef',
			'searchPODWithSenderRefResponse' => 'searchPODWithSenderRefResponse',
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
	 * @param trackWithSenderRef $parameters
	 * @return trackWithSenderRefResponse
	 */
	public function trackWithSenderRef(trackWithSenderRef $parameters) {
		return $this->__soapCall('trackWithSenderRef', array($parameters), array(
						'uri' => 'http://cxf.tracking.soap.chronopost.fr/',
						'soapaction' => ''
					)
			);
	}

	/**
	 *  
	 *
	 * @param trackSearch $parameters
	 * @return trackSearchResponse
	 */
	public function trackSearch(trackSearch $parameters) {
		return $this->__soapCall('trackSearch', array($parameters), array(
						'uri' => 'http://cxf.tracking.soap.chronopost.fr/',
						'soapaction' => ''
					)
			);
	}

	/**
	 *  
	 *
	 * @param trackSkybillV2 $parameters
	 * @return trackSkybillV2Response
	 */
	public function trackSkybillV2(trackSkybillV2 $parameters) {
		return $this->__soapCall('trackSkybillV2', array($parameters), array(
						'uri' => 'http://cxf.tracking.soap.chronopost.fr/',
						'soapaction' => ''
					)
			);
	}

	/**
	 *  
	 *
	 * @param trackSkybill $parameters
	 * @return trackSkybillResponse
	 */
	public function trackSkybill(trackSkybill $parameters) {
		return $this->__soapCall('trackSkybill', array($parameters), array(
						'uri' => 'http://cxf.tracking.soap.chronopost.fr/',
						'soapaction' => ''
					)
			);
	}

	/**
	 *  
	 *
	 * @param cancelSkybill $parameters
	 * @return cancelSkybillResponse
	 */
	public function cancelSkybill(cancelSkybill $parameters) {
		return $this->__soapCall('cancelSkybill', array($parameters), array(
						'uri' => 'http://cxf.tracking.soap.chronopost.fr/',
						'soapaction' => ''
					)
			);
	}

	/**
	 *  
	 *
	 * @param searchPOD $parameters
	 * @return searchPODResponse
	 */
	public function searchPOD(searchPOD $parameters) {
		return $this->__soapCall('searchPOD', array($parameters), array(
						'uri' => 'http://cxf.tracking.soap.chronopost.fr/',
						'soapaction' => ''
					)
			);
	}

	/**
	 *  
	 *
	 * @param searchPODWithSenderRef $parameters
	 * @return searchPODWithSenderRefResponse
	 */
	public function searchPODWithSenderRef(searchPODWithSenderRef $parameters) {
		return $this->__soapCall('searchPODWithSenderRef', array($parameters), array(
						'uri' => 'http://cxf.tracking.soap.chronopost.fr/',
						'soapaction' => ''
					)
			);
	}

}


