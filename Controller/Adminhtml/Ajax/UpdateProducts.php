<?php
/**
 * Copyright © 2019 Cubo. All rights reserved.
 * See https://cubo.agency/
**/
namespace Cubo\Multicurrency\Controller\Adminhtml\Ajax;

// Calculate the cost of goods in UAH
// For goods without value in UAH
class UpdateProducts extends \Magento\Framework\App\Action\Action {
	public function execute() {

		$manufacturers = [];
		$hash_manufacturers = [];

		$om = \Magento\Framework\App\ObjectManager::getInstance();

		// Get an array with a bet
		$connection = $om->get('Magento\Framework\App\ResourceConnection')->getConnection();
		$result = $connection->query("SELECT * FROM cubo_multicurrency_manufacturers");

		foreach ($result as $i) {
			$manufacturers[] = $i;
		}

		foreach ($manufacturers as $manufacturer) {
			$hash_manufacturers[] = $manufacturer['manufacturer_label'];
		}

		// Go through the goods and set the value
		$productCollection = $om->create('Magento\Catalog\Model\ResourceModel\Product\Collection');
		$collection = $productCollection->addAttributeToSelect('*')->load();

		foreach ($collection as $product) {

			// If the price is specified in UAH
			if (floatval($product->getPrice())) continue;

			$attr_manufacturer = $product->getResource()->getAttribute('manufacturer')->setStoreId(0)->getFrontend()->getValue($product);

			// Is there a manufacturer
			if (!$attr_manufacturer) continue;

			$i = array_search($attr_manufacturer, $hash_manufacturers);
			$manufacturer_rates = floatval($manufacturers[$i]['manufacturer_rates']);

			// Manufacturer's course is not zero
			if (!$manufacturer_rates) continue;

			$price_dollar = floatval($product->getResource()->getAttribute('price_dollar')->setStoreId(0)->getFrontend()->getValue($product));
			$price_euro = floatval($product->getResource()->getAttribute('price_euro')->setStoreId(0)->getFrontend()->getValue($product));

			// If the price is given in USD or EUR
			if ($price_dollar || $price_euro) {
				$rates = $price_dollar ? $price_dollar : $price_euro;
				$price =  $manufacturer_rates * $rates;
				$product->setPrice($price)->save();
			}
			
		}
	}
}