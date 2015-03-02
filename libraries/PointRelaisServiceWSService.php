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
 * pointChronopost class
 */
require_once 'pointChronopost.php';
/**
 * bureauDeTabac class
 */
require_once 'bureauDeTabac.php';
/**
 * bureauDeTabacAvecCoord class
 */
require_once 'bureauDeTabacAvecCoord.php';
/**
 * bureauDeTabacAvecPF class
 */
require_once 'bureauDeTabacAvecPF.php';
/**
 * pointCHRResult class
 */
require_once 'pointCHRResult.php';
/**
 * pointCHR class
 */
require_once 'pointCHR.php';
/**
 * listeHoraireOuverturePourUnJour class
 */
require_once 'listeHoraireOuverturePourUnJour.php';
/**
 * horaireOuverture class
 */
require_once 'horaireOuverture.php';
/**
 * periodeFermeture class
 */
require_once 'periodeFermeture.php';
/**
 * tourneeResult class
 */
require_once 'tourneeResult.php';
/**
 * tournee class
 */
require_once 'tournee.php';
/**
 * recherchePointChronopostParId class
 */
require_once 'recherchePointChronopostParId.php';
/**
 * recherchePointChronopostParIdResponse class
 */
require_once 'recherchePointChronopostParIdResponse.php';
/**
 * rechercheBtParIdChronopostA2Pas class
 */
require_once 'rechercheBtParIdChronopostA2Pas.php';
/**
 * rechercheBtParIdChronopostA2PasResponse class
 */
require_once 'rechercheBtParIdChronopostA2PasResponse.php';
/**
 * rechercheBtAvecPFParIdChronopostA2Pas class
 */
require_once 'rechercheBtAvecPFParIdChronopostA2Pas.php';
/**
 * rechercheBtAvecPFParIdChronopostA2PasResponse class
 */
require_once 'rechercheBtAvecPFParIdChronopostA2PasResponse.php';
/**
 * rechercheDetailPointChronopost class
 */
require_once 'rechercheDetailPointChronopost.php';
/**
 * rechercheDetailPointChronopostResponse class
 */
require_once 'rechercheDetailPointChronopostResponse.php';
/**
 * rechercheTournee class
 */
require_once 'rechercheTournee.php';
/**
 * rechercheTourneeResponse class
 */
require_once 'rechercheTourneeResponse.php';
/**
 * recherchePointChronopostParCoordonneesGeographiques class
 */
require_once 'recherchePointChronopostParCoordonneesGeographiques.php';
/**
 * recherchePointChronopostParCoordonneesGeographiquesResponse class
 */
require_once 'recherchePointChronopostParCoordonneesGeographiquesResponse.php';
/**
 * rechercheBtAvecPFParCodeproduitEtCodepostalEtDate class
 */
require_once 'rechercheBtAvecPFParCodeproduitEtCodepostalEtDate.php';
/**
 * rechercheBtAvecPFParCodeproduitEtCodepostalEtDateResponse class
 */
require_once 'rechercheBtAvecPFParCodeproduitEtCodepostalEtDateResponse.php';
/**
 * recherchePointChronopost class
 */
require_once 'recherchePointChronopost.php';
/**
 * recherchePointChronopostResponse class
 */
require_once 'recherchePointChronopostResponse.php';
/**
 * rechercheBtParCodeproduitEtCodepostalEtDate class
 */
require_once 'rechercheBtParCodeproduitEtCodepostalEtDate.php';
/**
 * rechercheBtParCodeproduitEtCodepostalEtDateResponse class
 */
require_once 'rechercheBtParCodeproduitEtCodepostalEtDateResponse.php';

/**
 * PointRelaisServiceWSService class
 * 
 *  
 * 
 * @author    {author}
 * @copyright {copyright}
 * @package   {package}
 */
class PointRelaisServiceWSService extends SoapClient {

  public function PointRelaisServiceWSService($wsdl = "https://www.chronopost.fr/recherchebt-ws-cxf/PointRelaisServiceWS?wsdl", $options = array()) {
	parent::__construct($wsdl, $options);
  }

  /**
   *  
   *
   * @param recherchePointChronopostParId $parameters
   * @return recherchePointChronopostParIdResponse
   */
  public function recherchePointChronopostParId(recherchePointChronopostParId $parameters) {
	return $this->__call('recherchePointChronopostParId', array(
			new SoapParam($parameters, 'parameters')
	  ),
	  array(
			'uri' => 'http://cxf.rechercheBt.soap.chronopost.fr/',
			'soapaction' => ''
		   )
	  );
  }

  /**
   *  
   *
   * @param rechercheBtAvecPFParIdChronopostA2Pas $parameters
   * @return rechercheBtAvecPFParIdChronopostA2PasResponse
   */
  public function rechercheBtAvecPFParIdChronopostA2Pas(rechercheBtAvecPFParIdChronopostA2Pas $parameters) {
	return $this->__call('rechercheBtAvecPFParIdChronopostA2Pas', array(
			new SoapParam($parameters, 'parameters')
	  ),
	  array(
			'uri' => 'http://cxf.rechercheBt.soap.chronopost.fr/',
			'soapaction' => ''
		   )
	  );
  }

  /**
   *  
   *
   * @param rechercheBtParIdChronopostA2Pas $parameters
   * @return rechercheBtParIdChronopostA2PasResponse
   */
  public function rechercheBtParIdChronopostA2Pas(rechercheBtParIdChronopostA2Pas $parameters) {
	return $this->__call('rechercheBtParIdChronopostA2Pas', array(
			new SoapParam($parameters, 'parameters')
	  ),
	  array(
			'uri' => 'http://cxf.rechercheBt.soap.chronopost.fr/',
			'soapaction' => ''
		   )
	  );
  }

  /**
   *  
   *
   * @param rechercheDetailPointChronopost $parameters
   * @return rechercheDetailPointChronopostResponse
   */
  public function rechercheDetailPointChronopost(rechercheDetailPointChronopost $parameters) {
	return $this->__call('rechercheDetailPointChronopost', array(
			new SoapParam($parameters, 'parameters')
	  ),
	  array(
			'uri' => 'http://cxf.rechercheBt.soap.chronopost.fr/',
			'soapaction' => ''
		   )
	  );
  }

  /**
   *  
   *
   * @param rechercheTournee $parameters
   * @return rechercheTourneeResponse
   */
  public function rechercheTournee(rechercheTournee $parameters) {
	return $this->__call('rechercheTournee', array(
			new SoapParam($parameters, 'parameters')
	  ),
	  array(
			'uri' => 'http://cxf.rechercheBt.soap.chronopost.fr/',
			'soapaction' => ''
		   )
	  );
  }

  /**
   *  
   *
   * @param recherchePointChronopostParCoordonneesGeographiques $parameters
   * @return recherchePointChronopostParCoordonneesGeographiquesResponse
   */
  public function recherchePointChronopostParCoordonneesGeographiques(recherchePointChronopostParCoordonneesGeographiques $parameters) {
	return $this->__call('recherchePointChronopostParCoordonneesGeographiques', array(
			new SoapParam($parameters, 'parameters')
	  ),
	  array(
			'uri' => 'http://cxf.rechercheBt.soap.chronopost.fr/',
			'soapaction' => ''
		   )
	  );
  }

  /**
   *  
   *
   * @param rechercheBtAvecPFParCodeproduitEtCodepostalEtDate $parameters
   * @return rechercheBtAvecPFParCodeproduitEtCodepostalEtDateResponse
   */
  public function rechercheBtAvecPFParCodeproduitEtCodepostalEtDate(rechercheBtAvecPFParCodeproduitEtCodepostalEtDate $parameters) {
	return $this->__call('rechercheBtAvecPFParCodeproduitEtCodepostalEtDate', array(
			new SoapParam($parameters, 'parameters')
	  ),
	  array(
			'uri' => 'http://cxf.rechercheBt.soap.chronopost.fr/',
			'soapaction' => ''
		   )
	  );
  }

  /**
   *  
   *
   * @param rechercheBtParCodeproduitEtCodepostalEtDate $parameters
   * @return rechercheBtParCodeproduitEtCodepostalEtDateResponse
   */
  public function rechercheBtParCodeproduitEtCodepostalEtDate(rechercheBtParCodeproduitEtCodepostalEtDate $parameters) {
	return $this->__call('rechercheBtParCodeproduitEtCodepostalEtDate', array(
			new SoapParam($parameters, 'parameters')
	  ),
	  array(
			'uri' => 'http://cxf.rechercheBt.soap.chronopost.fr/',
			'soapaction' => ''
		   )
	  );
  }

  /**
   *  
   *
   * @param recherchePointChronopost $parameters
   * @return recherchePointChronopostResponse
   */
  public function recherchePointChronopost(recherchePointChronopost $parameters) {
	return $this->__call('recherchePointChronopost', array(
			new SoapParam($parameters, 'parameters')
	  ),
	  array(
			'uri' => 'http://cxf.rechercheBt.soap.chronopost.fr/',
			'soapaction' => ''
		   )
	  );
  }

}

?>
