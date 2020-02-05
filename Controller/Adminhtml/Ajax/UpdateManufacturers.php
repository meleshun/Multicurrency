<?php
/**
 * Copyright © 2019 Cubo. All rights reserved.
 * See https://cubo.agency/
**/
namespace Cubo\Multicurrency\Controller\Adminhtml\Ajax;

// Update list of manufacturers
// Data is taken from the 'manufacturer' attribute
class UpdateManufacturers extends \Magento\Framework\App\Action\Action {
	public function execute() {

		// Manufacturers
		$current_manufacturers = $_POST['data'];
		$actual_manufacturers = [];

		// Get values from a table cubo_multicurrency_manufacturers
		$om = \Magento\Framework\App\ObjectManager::getInstance();
		$attributeManufacturers = $om->get(\Magento\Catalog\Api\ProductAttributeRepositoryInterface::class)->get('manufacturer');

		foreach ($attributeManufacturers->getOptions() as $option) {
			$manufacturer_label = trim($option->getLabel());
			if ($manufacturer_label) {
				$actual_manufacturers[] = $manufacturer_label;
			}
		}

		foreach ($current_manufacturers as $current_manufacturer) {
			$hash_current_manufacturers[] = $current_manufacturer[0];
		}

		foreach ($actual_manufacturers as $actual_manufacturer) {
			if (in_array($actual_manufacturer, $hash_current_manufacturers)) {
				$i = array_search($actual_manufacturer, $hash_current_manufacturers);
				$data[] = [$actual_manufacturer, $current_manufacturers[$i][1]];
			} else {
				$data[] = [$actual_manufacturer, 0];
			}
		}


		$connection = $om->get('Magento\Framework\App\ResourceConnection')->getConnection();
		$connection->query("DELETE FROM cubo_multicurrency_manufacturers");

		foreach ($data as $row) {
			$manufacturer_rates = round($row[1], 4);
			$query = "INSERT INTO cubo_multicurrency_manufacturers(manufacturer_label, manufacturer_rates) values('{$row[0]}', '{$manufacturer_rates}')";

			$connection->query($query);
			
			echo "<tr><td>{$row[0]}</td><td class=\"td-input\"><input type=\"text\" value=\"{$row[1]}\"></td></tr>";
		}
	}
}