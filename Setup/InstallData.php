<?php
/**
 * Copyright © 2019 Cubo. All rights reserved.
 * See https://cubo.agency/
**/

namespace Cubo\Multicurrency\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
          /**
           * Install manufacturer
           */
          $om = \Magento\Framework\App\ObjectManager::getInstance();

          /** @var \Magento\Catalog\Api\Data\ProductAttributeInterface $attribute */
          $attributeManufacturers = $om->get(\Magento\Catalog\Api\ProductAttributeRepositoryInterface::class)->get('manufacturer');

          foreach ($attributeManufacturers->getOptions() as $option) {
            $manufacturer_label = trim($option->getLabel());
            if ($manufacturer_label) {
              $data[] = ['manufacturer_label' => $manufacturer_label];
            }
          }
          
          foreach ($data as $bind) {
              $setup->getConnection()
                ->insertForce($setup->getTable('cubo_multicurrency_manufacturers'), $bind);
          }
    }
}
