<?php
/**
  * MODULE PRESTASHOP OFFICIEL CHRONOPOST
  * 
  * LICENSE : All rights reserved - COPY AND REDISTRIBUTION FORBIDDEN WITHOUT PRIOR CONSENT FROM OXILEO
  * LICENCE : Tous droits réservés, le droit d'auteur s'applique - COPIE ET REDISTRIBUTION INTERDITES SANS ACCORD EXPRES D'OXILEO
  *
  * @author    Oxileo SAS <contact@oxileo.eu>
  * @copyright 2001-2014 Oxileo SAS
  * @license   Proprietary - no redistribution without authorization
  */

/**
 * resultQuickCost class
 */
//require_once 'resultQuickCost.php';
/**
 * service class
 */
require_once 'service.php';
/**
 * resultQuickCostV2 class
 */
require_once 'resultQuickCostV2.php';
/**
 * assurance class
 */
//require_once 'assurance.php';
/**
 * resultCalculateProducts class
 */
require_once 'resultCalculateProducts.php';
/**
 * product class
 */
//require_once 'product.php';
/**
 * quickCost class
 */
require_once 'quickCost.php';
/**
 * quickCostResponse class
 */
require_once 'quickCostResponse.php';
/**
 * calculateProducts class
 */
require_once 'calculateProducts.php';
/**
 * calculateProductsResponse class
 */
require_once 'calculateProductsResponse.php';

/**
 * QuickcostServiceWSService class
 * 
 *  
 * 
 * @author    {author}
 * @copyright {copyright}
 * @package   {package}
 */
class QuickcostServiceWSService extends SoapClient {

  public function QuickcostServiceWSService($wsdl = "https://www.chronopost.fr/quickcost-cxf/QuickcostServiceWS?wsdl", $options = array()) {
	parent::__construct($wsdl, $options);
  }

  /**
   *  
   *
   * @param quickCost $parameters
   * @return quickCostResponse
   */
  public function quickCost(quickCost $parameters) {
	return $this->__call('quickCost', array(
			new SoapParam($parameters, 'parameters')
	  ),
	  array(
			'uri' => 'http://cxf.quickcost.soap.chronopost.fr/',
			'soapaction' => ''
		   )
	  );
  }

  /**
   *  
   *
   * @param calculateProducts $parameters
   * @return calculateProductsResponse
   */
  public function calculateProducts(calculateProducts $parameters) {
	return $this->__call('calculateProducts', array(
			new SoapParam($parameters, 'parameters')
	  ),
	  array(
			'uri' => 'http://cxf.quickcost.soap.chronopost.fr/',
			'soapaction' => ''
		   )
	  );
  }

}

?>
