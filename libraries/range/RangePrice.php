<?php

class RangePrice extends RangePriceCore
{


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
				'id_range_price' => (int)$this->id,
				'id_range_weight' => 0,
				'id_carrier' => (int)$this->id_carrier,
				'id_zone' => (int)$zone['id_zone'],
				'price' => 1,
			);
		$carrier->addDeliveryPrice($price_list);

		return true;
	}
}
