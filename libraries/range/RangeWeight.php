<?php

class RangeWeight extends RangeWeightCore
{


	public $price_to_affect;

	public function __construct($id = null, $id_lang = null, $id_shop = null)
	{
		$this->price_to_affect=0;
		return parent::__construct($id, $id_lang, $id_shop);
	}

	/**
	 * Override add to create delivery value for all zones
	 * @see classes/ObjectModelCore::add()
	 * 
	 * @param bool $null_values
	 * @param bool $autodate
	 * @return boolean Insertion result
	 */
	public function add($autodate = true, $null_values = false)
	{
		if (!ObjectModel::add($autodate, $null_values) || !Validate::isLoadedObject($this))
			return false;

		$carrier = new Carrier((int)$this->id_carrier);
		$price_list = array();
		foreach ($carrier->getZones() as $zone)
			$price_list[] = array(
				'id_range_price' => 0,
				'id_range_weight' => (int)$this->id,
				'id_carrier' => (int)$this->id_carrier,
				'id_zone' => (int)$zone['id_zone'],
				'price' => (float)($this->price_to_affect)
			);

	   
		$carrier->addDeliveryPrice($price_list);

		return true;
	}

}

?>
